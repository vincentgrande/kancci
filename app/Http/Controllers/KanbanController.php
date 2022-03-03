<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\Table;

class KanbanController extends Controller
{
    public function index()
    {

        return view('kanban',[
            'tables' => Table::all(),
            'cards' => Card::with('tables')->get(),
        ]);
    }

    public function getBoards()
    {
        $tables = Table::all();
        $cards = Card::all();
        $myBoards = [];
        foreach($tables as $table)
        {
            $board['id'] = $table->id;
            $board['title'] = $table->title;
            $board['class'] = 'info';
            $board['item'] = [];
            foreach($cards as $card)
            {
                if($card->isActive == true && $table->id == $card->table_id)
                {
                    $item['id'] = $card->uid;
                    $item['title'] = $card->title;
                    $item['class'] = $card->uid;
                    array_push( $board['item'], $item);
                }
            }
            array_push( $myBoards, $board);
        }
        
        return json_encode($myBoards);
    }

    public function verifyCardId(Request $request)
    {
       if(Card::where('uid', $request->uid)->count() != 0)
       {
           return 'false';
       }
       return 'true';
    }

    public function saveToDB(Request $request)
    {
        return $request->boards;
    }
}
