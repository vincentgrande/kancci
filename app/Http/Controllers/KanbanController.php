<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\ChecklistItem;
use App\WorkGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use App\Card;
use App\Board;
use App\Kanban;
use App\WorkGroupUser;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Integer;


class KanbanController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            $workGroup = WorkGroupUser::where('user_id',$user->id)->with('user')->with('workgroup')->get();

            return view('index', [
                'workgroups' => $workGroup,
            ]);
        }else{
            return view('welcome');
        }
    }

    /**
     * @param $id
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function kanban($id)
    {
        if($this->allowedKanbanAccess($id) == True) {
            return view('kanban', [
                'kanban' => $id,
            ]);
        }
        return redirect()->route('index');
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function getBoards(Request $request)
    {
        if($this->allowedKanbanAccess($request->id) == True) {
            $kanban = Kanban::where('id', $request->id)->first();
            $boards = Board::where('kanban_id', $kanban['id'])->get();
            $myBoards = [];
            if (json_decode($kanban['order']) != null) {
                foreach (json_decode($kanban['order']) as $order) {
                    $cards = [];
                    foreach ($boards as $b) {
                        if (isset($order->{'items'})) {
                            foreach ($order->{'items'} as $ord) {
                                $uid = $ord;
                                $card = Card::where('board_id', $b->id)->where('id', $uid)->first();
                                array_push($cards, $card);
                            }
                        }
                        if ($b->id == $order->{'id'}) {
                            $board['id'] = $b->id;
                            $board['title'] = $b->title;
                            $board['class'] = 'info';
                            $board['item'] = [];
                            foreach ($cards as $card) {
                                if ($card != null && $card->isActive == true && $b->id == $card->board_id) {
                                    $item['id'] = $card->id;
                                    $item['title'] = $card->title;
                                    $item['class'] = $card->uid;
                                    array_push($board['item'], $item);
                                }
                            }
                            array_push($myBoards, $board);
                        }
                    }
                }
                return json_encode($myBoards);
            } else {
                return json_encode(null);
            }
        }
        return '';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function verifyCardId(Request $request)
    {
        if ($this->allowedBoardAccess($request->board) == True) {
            $card = Card::create([
                    'title' => $request->title,
                    'description' => '',
                    'isActive' => true,
                    'board_id' => $request->board,
                    'created_by' => Auth::user()->id,
                ]);
                return $card->id;
            }
        return '';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function saveToDB(Request $request)
    {
        if($this->allowedKanbanAccess($request->kanbanId) == True) {
            $boards = json_encode($request->boards);
            if ($request->boards != null) {
                foreach ($request->boards as $b) {
                    if (isset($b['items'])) {
                        foreach ($b['items'] as $item) {
                            Card::where('id', $item)->update(['board_id' => $b['id']]); // Change card's board_id value
                        }
                    }
                }
                if (Kanban::where('id', $request->kanbanId)->update(['order' => $boards])) {
                    return 'Ok';
                }
                return 'Nok';
            } else {
                if (Kanban::where('id', $request->kanbanId)->update(['order' => $boards])) {
                    return 'Ok';
                }
                return 'Nok';
            }
        }
        return 'Nok';
    }

    /**
     * @param Request $request
     * @return int
     */
    public function boardMaxId(Request $request)
    {
        return Board::max('id') ?? 0;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function saveBoard(Request $request)
    {
        if($this->allowedKanbanAccess($request->kanbanId) == True){
            Board::create([
                'id' => $request->board[0]['id'],
                'title' => $request->board[0]['title'],
                'kanban_id' => $request->kanbanId,
                'created_by' => Auth::user()->id,
            ]);
            return 'true';
        }
        return 'false';
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCard(Request $request)
    {
        $card = Card::where('id',$request->id)->first();
        if ($this->allowedBoardAccess($card->board_id) == True) {
            $checklist = Checklist::where('card_id', $request->id)->first();
            $checklistitems = ChecklistItem::where('card_id', $request->id)->get();
            $cardInfos = [
                'card' => $card,
                'checklist' => $checklist,
                'checklistitems' => $checklistitems,
            ];
            return $cardInfos;
        }
        return '';
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getBoard(Request $request)
    {
        if ($this->allowedBoardAccess($request->id) == True) {
            return Board::select('title')->where('id', $request->id)->get();
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function editCard(Request $request)
    {
        $card = Card::where('id','=',$request->id)->first();
        if ($this->allowedBoardAccess($card->board_id) == True){
                if (isset($request->id) && isset($request->title)){
                    if(Card::where('id', $request->id)->update(['title' => $request->title,'description'=>$request->description,'startDate' => $request->startDate, 'endDate' => $request->endDate]) && Checklist::where('card_id', $request->id)->update(['title' => $request->checklisttitle]))
                    {
                        return 'Ok';
                    }
                }
            }
        return 'Nok';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function editBoard(Request $request): string
    {
        if ($this->allowedBoardAccess($request->id) == True){
            if (isset($request->id) && isset($request->title)){
                if(Board::where('id', $request->id)->update(['title' => $request->title]))
                {
                    return 'Ok';
                }
            }
        }
        return 'Nok';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function addChecklist(Request $request)
    {
        $card = Card::where('id','=',$request->card_id)->first();
        if($this->allowedBoardAccess($card->board_id) == True){
            $checklist = Checklist::create([
                'title' => 'New checklist',
                'card_id' => $request->card_id,
            ]);
            Card::where('id',$request->card_id)->update(['checklist_id' => $checklist->id]);
            if($checklist){
                return 'Ok';
            } else {
                return 'Nok';
            }
        }
        return 'Nok';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function addChecklistItem(Request $request)
    {
        $card = Card::where('id',$request->card_id)->first();
        if($this->allowedBoardAccess($card->board_id) == True) {
            $checklistitem = ChecklistItem::create([
                'label' => $request->item,
                'isChecked' => False,
                'checklist_id' => $card->checklist_id,
                'card_id' => $card->id
            ]);
            if ($checklistitem) {
                return $checklistitem;
            } else {
                return 'Nok';
            }
        }
        return 'Nok';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function saveChecklist(Request $request)
    {
        $item = ChecklistItem::where('id',$request->id)->first();
        $card = Card::where('id',$item->card_id)->first();
        if($this->allowedBoardAccess($card->board_id) == True) {
            ChecklistItem::where('id', $request->id)->update(['isChecked' => !$item->isChecked]);
            return 'Ok';
        }
        return 'Nok';
    }

    /**
     * @param $boardId
     * @return bool
     */
    public function allowedBoardAccess($boardId):bool
    {
        $board = Board::where('id',$boardId)->first();
        $kanban = Kanban::where('id',$board->kanban_id)->first();
        $workgroup = WorkGroup::where('id',$kanban->workgroup_id)->first();
        $workgroupuser = WorkGroupUser::where('workgroup_id',$workgroup->id)->get();
        foreach ($workgroupuser as $wk){
            if (Auth::user()->id == $wk->user_id){
                return True;
            }
        }
        return False;
    }

    /**
     * @param $kanbanId
     * @return bool
     */
    public function allowedKanbanAccess($kanbanId):bool
    {
        $kanban = Kanban::where('id',$kanbanId)->first();
        $workgroup = WorkGroup::where('id',$kanban->workgroup_id)->first();
        $workgroupuser = WorkGroupUser::where('workgroup_id',$workgroup->id)->get();
        foreach ($workgroupuser as $wk){
            if (Auth::user()->id == $wk->user_id){
                return True;
            }
        }
        return False;
    }
    public function archiveCard(Request $request)
    {
        $card = Card::where('id','=',$request->card_id)->first();
        if ($this->allowedBoardAccess($card->board_id) == True){
            if(Card::where('id', $card->id)->update(['isActive' => !$card->isActive]))
            {
                return 'Ok';
            }
        }
        return 'Nok';
    }
}
