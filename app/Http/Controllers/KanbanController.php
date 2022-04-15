<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\ChecklistItem;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use App\Card;
use App\Board;
use App\Kanban;
use App\WorkGroupUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Builder;

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
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function kanban($id)
    {
        return view('kanban', [
            'kanban' => $id,
        ]);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function getBoards(Request $request)
    {
        // TO DO : check if user is allowed to get the requested boards
        $kanban = Kanban::where('id', $request->id)->first();

        $boards = Board::where('kanban_id', $kanban['id'])->get();
        $myBoards = [];
        if(json_decode($kanban['order']) != null)
        {
            foreach(json_decode($kanban['order']) as $order)
            {
                $cards = [];
                foreach($boards as $b)
                {

                    if(isset($order->{'items'})){
                        foreach($order->{'items'} as $ord){
                            $uid = $ord;
                            $card = Card::where('board_id', $b->id)->where('id', $uid)->first();
                            array_push($cards, $card);
                        }
                    }
                    if($b->id == $order->{'id'}){
                        $board['id'] = $b->id;
                        $board['title'] = $b->title;
                        $board['class'] = 'info';
                        $board['item'] = [];

                        foreach($cards as $card)
                        {
                            if($card != null && $card->isActive == true && $b->id == $card->board_id)
                            {
                                $item['id'] = $card->id;
                                $item['title'] = $card->title;
                                $item['class'] = $card->uid;
                                array_push( $board['item'], $item);
                            }
                        }
                        array_push( $myBoards, $board);
                    }
                }
            }
            return json_encode($myBoards);
        }else{
            return json_encode(null);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function verifyCardId(Request $request)
    {
        $card = Card::create([
            'title' => $request->title,
            'description' => '',
            'isActive' => true,
            'board_id' => $request->board,
            'created_by' => Auth::user()->id,
        ]);
        return $card->id;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function saveToDB(Request $request)
    {
        $boards = json_encode($request->boards);
        if($request->boards != null)
        {
            foreach($request->boards as $b)
            {
                if(isset($b['items'])){
                    foreach($b['items'] as $item)
                    {
                        Card::where('id',$item)->update(['board_id' => $b['id']]); // Change card's board_id value
                    }
                }
            }
            if(Kanban::where('id', $request->kanbanId)->update(['order' => $boards]))
            {
                return 'Ok';
            }
            return 'nok';
        }else{
            if(Kanban::where('id', $request->kanbanId)->update(['order' => $boards]))
            {
                return 'Ok';
            }
            return 'nok';
        }
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
        Board::create([
            'id' => $request->board[0]['id'],
            'title' => $request->board[0]['title'],
            'kanban_id' => $request->kanbanId,
            'created_by' => Auth::user()->id,
        ]);
        return 'true';
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCard(Request $request)
    {
        // TO DO : Check if user is allowed to access to this card
        $card = Card::where('id',$request->id)->first();
        $checklist = Checklist::where('card_id',$request->id)->first();
        $checklistitems = ChecklistItem::where('card_id',$request->id)->get();
        $cardInfos = [
            'card' => $card,
            'checklist' => $checklist,
            'checklistitems' => $checklistitems,
        ];
        return $cardInfos;

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getBoard(Request $request)
    {
        // TO DO : Check if user is allowed to access to this board
        return Board::select('title')->where('id',$request->id)->get();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function editCard(Request $request)
    {
        if(Card::where('id', $request->id)->update(['title' => $request->title]) && Checklist::where('card_id', $request->id)->update(['title' => $request->checklisttitle]))
        {
            return 'Ok';
        }
        return 'nok';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function editBoard(Request $request): string
    {
        if(Board::where('id', $request->id)->update(['title' => $request->title]))
        {
            return 'Ok';
        }
        return 'nok';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function addChecklist(Request $request)
    {
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
    public function addChecklistItem(Request $request)
    {
        $card = Card::where('id',$request->card_id)->first();
        $checklistitem = ChecklistItem::create([
            'label' => $request->item,
            'isChecked' => False,
            'checklist_id' => $card->checklist_id,
            'card_id' => $card->id
        ]);
        if($checklistitem){
            return $checklistitem;
        } else {
            return 'Nok';
        }
    }

    public function saveChecklist(Request $request)
    {
        $item = ChecklistItem::where('id',$request->id)->first();
        ChecklistItem::where('id',$request->id)->update(['isChecked'=> !$item->isChecked]);
        return 'Ok';
    }


}
