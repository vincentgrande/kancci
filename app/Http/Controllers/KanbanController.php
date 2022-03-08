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

        return view('kanban',[
            'tables' => Table::all(),
            'cards' => Card::with('tables')->get(),
        ]);
    }

    public function getBoards(Request $request) 
    {
        $kanban = Kanban::where('id', 1)->get();
        $tables = Table::where('kanban_id', $kanban[0]->id)->get();
        $myBoards = [];
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
    }

    public function verifyCardId(Request $request)
    {
       if(Card::where('uid', $request->uid)->count() != 0) // Check if unique id already exists
       {
           return 'false';
       }
       $card = new Card;
       $card->uid = $request->uid;
       $card->title = "New card";
       $card->isActive = true;
       $card->table_id = $request->table;
       $card->save();
       return 'true';
    }

    public function saveToDB(Request $request)
    {
        /**
         * Save kanban in DB
         */
        $boards = json_encode($request->boards);
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
    }
}
