<?php

namespace App\Http\Controllers;
use App\WorkGroup;
use App\WorkGroupUser;
use App\Kanban;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkgroupController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();
        $workGroup = WorkGroup::where('created_by',$user->id)->where('id', $id)->with('creator')->first();
        $workgroupUser = WorkGroupUser::where('workgroup_id', $id)->with('user')->get();
        if ($workGroup == null){
            return redirect()->route('index');
        }
        return view('workgroup',[
            'workgroup' => $workGroup,
            'workgroup_users' => $workgroupUser
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

        return back();
    }
    public function getKanban(Request $request){

        $kanban = Kanban::where('workgroup_id',$request->workgroup_id)->get();
        return $kanban;

    }
    public function getWorkgroup(){
        $user = Auth::user();
        $workGroup = WorkGroupUser::where('user_id',$user->id)->with('user')->with('workgroup')->get();
        return  $workGroup;
    }
    public function getWorkgroupById($id){
        $user = Auth::user();
        $workGroup = WorkGroup::where('created_by',$user->id)->where('id', $id)->with('creator')->get();
        return  view('workgroup-info', [
            'workgroup' => $workGroup
        ]);
    }

    /**
     * @throws \Exception
     */
    public function UpdateWorkgroupInfos(Request $request)
    {
        $workgroup = WorkGroup::where('id',$request->id)->where('created_by', Auth::user()->id)->with('creator')->get();
        if($workgroup == null)
        {
            throw new \Exception("Workgroup was null");
        }
        WorkGroup::where('id', $request->id)->update(['title' => $request->title]);
        return route('WorkgroupInfosGet', ['id' => $request->id]);

    }

    public function addWorkgroup(Request $request){
        $firstLetter = $request->title[0];
        $firstLetter = strtolower($firstLetter);
        $workgroup = WorkGroup::create([
            'title' => $request->title,
            'logo' => "logos/".$firstLetter."_blue.png",
            'created_by' => Auth::user()->id,
        ]);
        WorkGroupUser::create([
            'user_id' => Auth::user()->id,
            'workgroup_id' => $workgroup->id,
        ]);
        return back();
    }
}
