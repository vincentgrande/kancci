<?php

namespace App\Http\Controllers;
use App\WorkGroupUser;
use App\Kanban;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WorkgroupController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();
        $workGroup = WorkGroupUser::where('user_id',$user->id)->where('workgroup_id', $id)->with('user')->with('workgroup')->first();
        if ($workGroup == null){
            return redirect()->route('index');
        }
        $kanban = Kanban::where('workgroup_id',$workGroup->workgroup_id)->get();

        return view('workgroup',[
            'workgroup' => $workGroup,
            'kanbans' => $kanban,
        ]);
    }
}
