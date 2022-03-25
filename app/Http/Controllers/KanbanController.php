<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\Table;
use App\Kanban;

class KanbanController extends Controller
{
    public function index()
    {
        return view('kanban');
    }

    public function getBoards(Request $request)
    {
        // TO DO : check if user is allowed to get the requested boards
        $kanban = Kanban::where('id', $request->id)->get();
        $tables = Table::where('kanban_id', $kanban[0]->id)->get();
        $myBoards = [];
        if(json_decode($kanban[0]->order) != null)
        {
            foreach(json_decode($kanban[0]->order) as $order)
            {
                $cards = [];
                foreach($tables as $table)
                {
                    if(isset($order->{'items'})){
                        foreach($order->{'items'} as $ord){
                            $uid = $ord;
                            $card = Card::where('table_id', $table->id)->where('uid', $uid)->first();
                            array_push($cards, $card);
                        }
                    }
                    if($table->id == $order->{'id'}){
                        $board['id'] = $table->id;
                        $board['title'] = $table->title;
                        $board['class'] = 'info';
                        $board['item'] = [];
                        foreach($cards as $card)
                        {
                            if($card != null && $card->isActive == true && $table->id == $card->table_id)
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

    public function verifyCardId(Request $request)
    {
        if(Card::where('uid', $request->uid)->count() != 0) // Check if unique id already exists
        {
            return 'false';
        }
        Card::create([
            'uid' => $request->uid,
            'title' => $request->title,
            'isActive' => true,
            'table_id' => $request->table,
        ]);
        return 'true';
    }

    public function saveToDB(Request $request)
    {
        /**
         * Save kanban in DB
         */
        $boards = json_encode($request->boards);
        if($request->boards != null)
        {
            foreach($request->boards as $b)
            {
                if(isset($b['items'])){
                    foreach($b['items'] as $item)
                    {
                        Card::where('uid',$item)->update(['table_id' => $b['id']]); // Change card's table_id value
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

    public function tablemaxid(Request $request)
    {
        return Table::max('id') ?? 0;
    }

    public function saveTable(Request $request)
    {
        Table::create([
            'id' => $request->board[0]['id'],
            'title' => $request->board[0]['title'],
            'kanban_id' => $request->kanbanId
        ]);
        return 'true';
    }

    public function getCard(Request $request)
    {
        // TO DO : Check if user is allowed to access to this card
        return Card::select('uid','title','description','startDate','endDate')->where('uid',$request->id)->get();
    }

    public function getBoard(Request $request)
    {
        // TO DO : Check if user is allowed to access to this board
        return Table::select('title')->where('id',$request->id)->get();
    }

    public function editCard(Request $request)
    {
        if(Card::where('uid', $request->id)->update(['title' => $request->title]))
        {
            return 'Ok';
        }
        return 'nok';
    }

    public function editBoard(Request $request)
    {
        if(Table::where('id', $request->id)->update(['title' => $request->title]))
        {
            return 'Ok';
        }
        return 'nok';
    }
}
