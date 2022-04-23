<?php

namespace App\Http\Controllers;
use App\WorkGroup;
use App\WorkGroupUser;
use App\Kanban;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkgroupController extends Controller
{
    /**
     * @param $id
     * @return Application|Factory|RedirectResponse|View
     */
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addKanban(Request $request): RedirectResponse
    {
        Kanban::create([
            'title' => $request->title,
            'workgroup_id' => $request->workgroup_id,
            'background' => '/wallpaper/'.$request->background.'.jpg',
            'visibility' => 'visible',
            'created_by' => Auth::user()->id,
        ]);

        return back();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getKanban(Request $request){

        $kanban = Kanban::where('workgroup_id',$request->workgroup_id)->get();
        return $kanban;

    }

    /**
     * @return mixed
     */
    public function getWorkgroup(){
        $user = Auth::user();
        $workGroup = WorkGroupUser::where('user_id',$user->id)->with('user')->with('workgroup')->get();
        return  $workGroup;
    }

    /**
     * @return WorkGroup | null
     */
    public function getWorkgroupFromUser(){
        $user = Auth::user();
        $workGroup = WorkGroup::where('created_by',$user->id)->with('creator')->get();
        return  $workGroup;
    }

    /**
     * @return WorkGroupUser | null
     */
    public function getWorkGroupInvited() {
        $user = Auth::user();
        $workGroup = WorkGroupUser::where('user_id',$user->id)->with('user')->with('workgroup')->get();
        return  $workGroup;
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function getWorkgroupById($id){
        $user = Auth::user();
        $workGroup = WorkGroup::where('created_by',$user->id)->where('id', $id)->with('creator')->get();
        return  view('workgroup-info', [
            'workgroup' => $workGroup
        ]);
    }

    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function UpdateWorkgroupInfos(Request $request): string
    {
        $workgroup = WorkGroup::where('id',$request->id)->where('created_by', Auth::user()->id)->with('creator')->get();
        if($workgroup == null)
        {
            throw new Exception("Workgroup was null");
        }
        WorkGroup::where('id', $request->id)->update(['title' => $request->title]);
        return route('WorkgroupInfosGet', ['id' => $request->id]);

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addWorkgroup(Request $request): RedirectResponse
    {
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
