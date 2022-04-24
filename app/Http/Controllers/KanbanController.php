<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Attachement;
use App\CardLabel;
use App\CardUser;
use App\Checklist;
use App\ChecklistItem;
use App\Comment;
use App\KanbanLabel;
use App\KanbanUser;
use App\Label;
use App\WorkGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Card;
use App\User;
use App\Board;
use App\Kanban;
use App\WorkGroupUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;


class KanbanController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
    }

    public function Search(Request $result)
    {
        $workgroups = WorkGroup::where('title','LIKE','%'.$result->search.'%')->get();
        $kanbans = Kanban::where('title', 'LIKE', '%'.$result->search.'%')->get();
        return $workgroups;
    }

    /**
     * @return Application|Factory|View
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
     * @return Application|Factory|RedirectResponse|View
     */
    public function kanban($id)
    {
        if($this->allowedKanbanAccess($id) == 'True' && $this->allowedKanbanAccess($id) != 'public') {
            return view('kanban', [
                'kanban' => $id,
            ]);
        }
        if($this->allowedKanbanAccess($id) == 'public') {
            return view('kanban', [
                'kanban' => $id,
                'visibility' => 'public',
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
        if($this->allowedKanbanAccess($request->id) == "True" || $this->allowedKanbanAccess($request->id) == "public") {
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
                        if ($b->id == $order->{'id'} && $b->isActive == true) {
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
    public function verifyCardId(Request $request): string
    {
        if ($this->allowedBoardAccess($request->board)) {
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
    public function saveToDB(Request $request): string
    {
        if($this->allowedKanbanAccess($request->kanbanId) == "True") {
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
    public function boardMaxId(Request $request): int
    {
        return Board::max('id') ?? 0;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function saveBoard(Request $request): string
    {
        if($this->allowedKanbanAccess($request->kanbanId) == "True"){
            Board::create([
                'id' => $request->board[0]['id'],
                'title' => $request->board[0]['title'],
                'isActive' => True,
                'kanban_id' => $request->kanbanId,
                'created_by' => Auth::user()->id,
            ]);
            return 'true';
        }
        return 'false';
    }

    public function debug(){
dd(Kanban::select('id')->first());
    }

    public function joinCard(Request $request)
    {
        $card = Card::where('id',$request->card_id)->first();
        if ($this->allowedBoardAccess($card->board_id)) {
            $carduser = CardUser::where('card_id',$request->card_id)->where('user_id',$request->user_id)->first();
            if ($carduser !== null) {
                $carduser->delete();
                return 0;
            }else{
                $carduser = CardUser::create(['user_id' => $request->user_id, 'card_id' => $card->id]);
                return 1;
            }
        }
        return '';
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCard(Request $request)
    {
        $card = Card::where('id',$request->id)->first();
        $board = Board::where('id', $card->board_id)->first();

        if ($this->allowedBoardAccess($card->board_id) == True || $this->allowedKanbanAccess($board->kanban_id) == "public" || $this->allowedKanbanAccess($board->kanban_id) == "True") {
            $board = Board::where('id',$card->board_id)->first();
            $kanban = Kanban::where('id',$board->kanban_id)->first();
            $workgroup = WorkGroup::where('id',$kanban->workgroup_id)->first();
            $workgroupuser = WorkGroupUser::where('workgroup_id',$workgroup->id)->get('user_id');
            $users = [];
            foreach($workgroupuser as $wku)
            {
                $user = User::where('id',$wku->user_id)->select()->first();
                foreach(CardUser::where('card_id',$card->id)->where('user_id',$wku->user_id)->get() as $cu){
                    if($user->id == $cu->user_id){
                        $user["card_user"] = 1;
                    }else{
                        $user["card_user"] = 0;
                    }
                }
                array_push($users, $user);
            }
            $checklist = Checklist::where('card_id', $request->id)->first();
            $checklistitems = ChecklistItem::where('card_id', $request->id)->get();
            $attachments = Attachement::where('card_id', $request->id)->get();
            $comments = Comment::where('card_id', $request->id)->get();
            $labels = KanbanLabel::where('kanban_id', $kanban->id)->get();
            $cardlabel = [];
            foreach($labels as $label){
                array_push($cardlabel,[Label::where('id',$label->label_id)->first(),CardLabel::where('card_id',$card->id)->where('label_id',$label->label_id)->first()]);
            }
            $cardInfos = [
                'card' => $card,
                'checklist' => $checklist,
                'checklistitems' => $checklistitems,
                'workgroupuser' => $users,
                'attachments' => $attachments,
                'comments' => $comments,
                'labels' => $cardlabel,
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
        if ($this->allowedBoardAccess($request->id)) {
            return Board::select('title')->where('id', $request->id)->get();
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function editCard(Request $request): string
    {
        $card = Card::where('id','=',$request->id)->first();
        if ($this->allowedBoardAccess($card->board_id)){
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
        if ($this->allowedBoardAccess($request->id)){
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

    public function addChecklist(Request $request): string
    {
        $card = Card::where('id','=',$request->card_id)->first();
        if($this->allowedBoardAccess($card->board_id)){
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
     * @return mixed
     */
    public function addChecklistItem(Request $request)
    {
        $card = Card::where('id',$request->card_id)->first();
        if($this->allowedBoardAccess($card->board_id)) {
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
    public function saveChecklist(Request $request): string
    {
        $item = ChecklistItem::where('id',$request->id)->first();
        $card = Card::where('id',$item->card_id)->first();
        if($this->allowedBoardAccess($card->board_id)) {
            ChecklistItem::where('id', $request->id)->update(['isChecked' => !$item->isChecked]);
            return 'Ok';
        }
        return 'Nok';
    }

    /**
     * @param $boardId
     * @return string
     */
    public function allowedBoardAccess($boardId)
    {
        $board = Board::where('id',$boardId)->first();
        $kanban = Kanban::where('id',$board->kanban_id)->first();
        if($kanban->visibility == "private")
        {
            $kanbanuser = KanbanUser::where('kanban_id',$kanban->id)->get();
            foreach ($kanbanuser as $ku){
                if (Auth::user()->id == $ku->user_id){
                    return "True";
                }
            }
        }else if($kanban->visibility == "visible")
        {
            $workgroup = WorkGroup::where('id',$kanban->workgroup_id)->first();
            $workgroupuser = WorkGroupUser::where('workgroup_id',$workgroup->id)->get();
            foreach ($workgroupuser as $wk){
                if (Auth::user()->id == $wk->user_id){
                    return "True";
                }
            }
        }
        else if($kanban->visibility == "public")
        {
            $workgroup = WorkGroup::where('id',$kanban->workgroup_id)->first();
            $workgroupuser = WorkGroupUser::where('workgroup_id',$workgroup->id)->get();
            foreach ($workgroupuser as $wk){
                if (Auth::user()->id == $wk->user_id){
                    return "True";
                }
            }
            return "public";
        }
        return "False";
    }

    /**
     * @param $kanbanId
     * @return string
     */
    public function allowedKanbanAccess($kanbanId)
    {
        $kanban = Kanban::where('id',$kanbanId)->first();
        if($kanban->visibility == "private")
        {
            $kanbanuser = KanbanUser::where('kanban_id',$kanban->id)->get();
            foreach ($kanbanuser as $ku){
                if (Auth::user()->id == $ku->user_id){
                    return "True";
                }
            }
        }else if($kanban->visibility == "visible")
        {
            $workgroup = WorkGroup::where('id',$kanban->workgroup_id)->first();
            $workgroupuser = WorkGroupUser::where('workgroup_id',$workgroup->id)->get();
            foreach ($workgroupuser as $wk){
                if (Auth::user()->id == $wk->user_id){
                    return "True";
                }
            }
        }
        else if($kanban->visibility == "public")
        {
            $workgroup = WorkGroup::where('id',$kanban->workgroup_id)->first();
            $workgroupuser = WorkGroupUser::where('workgroup_id',$workgroup->id)->get();
            foreach ($workgroupuser as $wk){
                if (Auth::user()->id == $wk->user_id){
                    return "True";
                }
            }
            return "public";
        }
        return 'False';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function archiveCard(Request $request): string
    {
        $card = Card::where('id','=',$request->card_id)->first();
        if ($this->allowedBoardAccess($card->board_id) == 'True'){
            if(Card::where('id', $card->id)->update(['isActive' => !$card->isActive]))
            {
                return 'Ok';
            }
        }
        return 'Nok';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function archiveBoard(Request $request)
    {
        $board = Board::where('id', $request->board_id)->first();
        if ($this->allowedBoardAccess($board->id) == 'True'){
            if(Board::where('id', $board->id)->update(['isActive' => !$board->isActive]))
            {
                return 'Ok';
            }
        }
        return 'Nok';
    }

    /**
     * @param Request $request
     * @return array
     */
    public function kanbanInfos(Request $request)
    {
        $kanban = Kanban::where('id', $request->id)->first();
        $workgroupuser = WorkGroupUser::where('workgroup_id',$kanban->workgroup_id)->get();
        $users = [];
        foreach($workgroupuser as $wku)
        {
            $user = User::where('id',$wku->user_id)->select()->first();

            if($kanban->visibility == "visible"){
                $user["kanban_user"] = 1;
            }else if($kanban->visibility == "private"){
                $ku = KanbanUser::where('kanban_id',$kanban->id)->where('user_id',$user->id)->first();
                if($ku != null){
                    $user["kanban_user"] = 1;
                }else{
                    $user["kanban_user"] = 0;
                }
            }else{
                $user["kanban_user"] = 1;
            }
            array_push($users, $user);
        }
       $kanbanInfos = [
           'kanban'=>$kanban,
           'workgroupuser'=>$users,
           'labels' => KanbanLabel::where('kanban_id',$request->id)->with('label')->get(),
       ];
       return $kanbanInfos;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function editKanban(Request $request)
    {
        if(isset($request->title) && isset($request->visibility) && ($request->visibility == "visible" || $request->visibility == "private" || $request->visibility == "public")){
            Kanban::where('id',$request->id)->update(['title'=>$request->title,'visibility'=>$request->visibility]);

            if (KanbanUser::where('kanban_id',$request->id)->where('user_id',Auth::user()->id)->first() == null) {
                KanbanUser::create(['user_id' => Auth::user()->id, 'kanban_id' => $request->id]);
            }
            $ku = KanbanUser::where('kanban_id',$request->id)->get();
            return $ku;
        }
        return 'Nok';
    }

    public function joinKanban(Request $request)
    {
        $kanbanuser = KanbanUser::where('kanban_id',$request->kanban_id)->where('user_id',$request->user_id)->first();
        if ($kanbanuser != null) {
            $kanbanuser->delete();
            return 0;
        }else{
            $kanbanuser = KanbanUser::create(['user_id' => $request->user_id, 'kanban_id' => $request->kanban_id]);
            return 1;
        }
    }
    public function uploadFile(Request $request)
    {
        $request->validate([
            'image.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,jpg,gif,svg',
        ]);
        if($file = $request->hasFile('file')) {

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filename = Hash::make($request->file->hashName());
            $filename = str_replace('/', 'l', $filename);
            $filename = str_replace('.', 'i', $filename);
            $filename = $filename.'.'. $request->file->extension();
            $destinationPath = public_path() . '/attachments';
            $attachement = Attachement::create([
                'original_name' => $request->file->getClientOriginalName(),
                'filepath' => 'attachments/' .$filename,
                'uploaded_by' => Auth::user()->id,
                'card_id' => $request->card_id,
            ]);
            $file->move($destinationPath, $filename);
            return back();
        }
        return back();
    }

    public function deleteFile(Request $request)
    {
        $attachement = Attachement::where('id',$request->id)->first();
        $card = Card::where('id','=',$attachement->card_id)->first();
        if ($this->allowedBoardAccess($card->board_id) == 'True') {
            if (file_exists($attachement->filepath)){
                unlink($attachement->filepath);
            }
            $attachement->delete();
            return "Ok";
        }
        return "Nok";
    }

    public function showFile($id){
        $attachement = Attachement::where('id',$id)->first();
        $card = Card::where('id','=',$attachement->card_id)->first();
        if ($this->allowedBoardAccess($card->board_id) == 'True') {
            return redirect($attachement->filepath);
        }
        return back();
    }
    public function deleteItem(Request $request)
    {
        $checklistitem = ChecklistItem::where('id',$request->id)->first();
        $card = Card::where('id','=',$checklistitem->card_id)->first();
        if ($this->allowedBoardAccess($card->board_id) == 'True') {
            $checklistitem->delete();
            return "Ok";
        }
        return "Nok";
    }

    public function getAlert()
    {
        setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
        $carduser = CardUser::where('user_id', 1)->with('card')->get();
        $alerts = [];

        foreach($carduser as $cu){
            $card = Card::where('id', $cu->card_id)->whereDate('endDate','<=', date("Y-m-d"))->first();
            $card2 = Card::where('id', $cu->card_id)->whereDate('endDate','>', date("Y-m-d"))->get();
            foreach($card2 as $c){
                Alert::where('card_id', $c->id)->where('user_id', Auth::user()->id)->delete();
            }
            if($card != []) {
                $alerte = Alert::with('card')->where('user_id', Auth::user()->id)->where('card_id', $card->id)->first();

                if ($alerte == []) {
                    $alerte = Alert::create([
                        'card_id' => $cu->card->id,
                        'user_id' => Auth::user()->id,
                    ]);
                }
            }

        }
        return(Alert::with('card')->where('is_read',false)->where('user_id', Auth::user()->id)->get());
    }
    public function readAlert(Request $request)
    {
        $alert = Alert::where('id',$request->id)->where('user_id', Auth::user()->id)->first();
        if($alert){
            $alert->is_read = true;
            $alert->save();
            return 'Ok';
        }
        return 'Nok';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function addComment(Request $request)
    {
        $card = Card::where('id','=',$request->card_id)->first();
        if ($this->allowedBoardAccess($card->board_id) == 'True') {
            $comment = Comment::create([
                'message' => $request->comment,
                'created_by' => Auth::user()->id,
                'card_id' => $request->card_id
            ]);
            return $comment;
        }
        return 'Nok';
    }
    public function deleteComment(Request $request)
    {
        $comment = Comment::where('id',$request->id)->first();
        $card = Card::where('id','=',$comment->card_id)->first();
        if ($this->allowedBoardAccess($card->board_id) == 'True') {
            if($comment){
                $comment->delete();
                return 'Ok';
            }
        }
        return 'Nok';
    }

    public function archived($id)
    {
        if($this->allowedKanbanAccess($id) == 'True') {
            return view('archive', [
                'kanban' => $id,
            ]);
        }
        return back();
    }
    public function getArchived(Request $request)
    {
        $cards = [];
        $archivedBoards = [];
        $boards = Board::where('kanban_id',$request->kanban_id)->get();
        foreach($boards as $board){
            if($board->isActive == true){
                array_push($cards,Card::where('board_id',$board->id)->where('isActive',false)->get());
            }
        }
        foreach($boards as $board){
            if($board->isActive == false){
                array_push($archivedBoards,$board);
            }
        }
        return [
            'cards'=> $cards,
            'boards' => $archivedBoards
            ];
    }
    public function unarchiveCard(Request $request)
    {
        $card = Card::where('id','=',$request->id)->first();
        if ($this->allowedBoardAccess($card->board_id) == 'True') {
            $card->isActive = true;
            $card->save();

            $board = Board::where('id',$card->board_id)->first();
            $kanban = Kanban::where('id',$board->kanban_id)->first();
            $order = json_decode($kanban->order, true);
            $cards = Card::where('id','=',$request->id)->where('isActive',true)->first();
            $json = [];
            foreach($order as $ord){
                if(isset($ord['items']) && "$cards->board_id" == $ord['id']){
                    array_push($ord['items'],"$cards->id");
                }else if(!isset($ord['items']) &&"$cards->board_id" == $ord['id']){
                    $ord['items']=["$cards->id"];
                }
                array_push($json,$ord);
            }
            $kanban->order = $json;
            $kanban->save();

            return "Ok";
        }
        return "Nok";
    }

    public function unarchiveBoard(Request $request)
    {
        if ($this->allowedBoardAccess($request->id) == 'True') {
            Board::where('id',$request->id)->update(['isActive'=> true]);
            $board = Board::where('id',$request->id)->first();
            $kanban = Kanban::where('id',$board->kanban_id)->first();
            $order = json_decode($kanban->order, true);
            $cards = Card::where('board_id',$board->id)->where('isActive',true)->get();
            $items=[];
            foreach($cards as $card){
                array_push($items,$card->id);
            }
            array_push($order,["id"=>$board->id,"items"=>$items]);
            $kanban->order = $order;
            $kanban->save();
            return "Ok";
        }
        return "Nok";
    }

    public function useLabel(Request $request)
    {
        $cardlabel = CardLabel::where(['label_id' => $request->id, 'card_id' => $request->card_id])->first();
        if ($cardlabel !== null) {
            $cardlabel->delete();
            return 0;
        }else{
            $cardlabel = CardLabel::create(['label_id' => $request->id, 'card_id' => $request->card_id]);
            return 1;
        }
    }

    public function addLabel(Request $request)
    {
        Label::create([
            'label' => $request->label,
            'color' => $request->color,
            'created_by' => Auth::user()->id,
        ]);
        KanbanLabel::create([
            'kanban_id' => $request->kanban,
            'label_id' => Label::where([
                'label' => $request->label,
                'color' => $request->color,
                'created_by' => Auth::user()->id,
            ])->first()->id,
        ]);
        return Label::where([
            'label' => $request->label,
            'color' => $request->color,
            'created_by' => Auth::user()->id,
        ])->first();
    }
    public function deleteLabel(Request $request)
    {
        CardLabel::where('label_id',$request->id)->delete();
        KanbanLabel::where('label_id',$request->id)->where('kanban_id',$request->kanban)->delete();
        Label::where('id', $request->id)->delete();
        return 'Ok';
    }
}
