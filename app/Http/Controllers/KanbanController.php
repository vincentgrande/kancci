<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use App\Card;
use App\Board;
use App\Kanban;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class KanbanController extends Controller
{
    /**
     * Create a new controller instance.
     *
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
            return view('index');
        }else{
            return view('welcome');
        }
    }

    /**
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function kanban()
    {
        return view('kanban');
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function getBoards(Request $request)
    {
        // TO DO : check if user is allowed to get the requested boards
        $kanban = Kanban::where('id', $request->id)->get();
        $boards = Board::where('kanban_id', $kanban[0]->id)->get();
        $myBoards = [];
        if(json_decode($kanban[0]->order) != null)
        {
            foreach(json_decode($kanban[0]->order) as $order)
            {
                $cards = [];
                foreach($boards as $b)
                {
                    if(isset($order->{'items'})){
                        foreach($order->{'items'} as $ord){
                            $uid = $ord;
                            $card = Card::where('board_id', $b->id)->where('uid', $uid)->first();
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
                                $item['id'] = $card->uid;
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
        if(Card::where('uid', $request->uid)->count() != 0) // Check if unique id already exists
        {
            return 'False';
        }
        $card = Card::create([
            'uid' => $request->uid,
            'title' => $request->title,
            'isActive' => true,
            'board_id' => $request->board,
        ]);
        return 'True';
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
                        Card::where('uid',$item)->update(['board_id' => $b['id']]); // Change card's board_id value
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
            'kanban_id' => $request->kanbanId
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
        return Card::where('uid',$request->id)->first();
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
        if(Card::where('uid', $request->id)->update(['title' => $request->title]))
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
}
