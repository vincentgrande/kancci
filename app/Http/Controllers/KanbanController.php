<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\Table;

class KanbanController extends Controller
{
    public function index(){

        return view('kanban',[
            'tables' => Table::all(),
            'cards' => Card::with('tables')->get(),
        ]);
    }
}
