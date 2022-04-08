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
        return view('workgroup',[
            'workgroup' => $workGroup,
        ]);
    }

    public function addKanban(Request $request)
    {
        Kanban::create([
            'title' => $request->title,
            'workgroup_id' => $request->workgroup_id,
            'visibility' => 'visible',
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('workgroup',['id'=>$request->workgroup_id]);
    }
    public function getKanban(Request $request){

        $kanban = Kanban::where('workgroup_id',$request->workgroup_id)->get();

        return $kanban;

    }
}
