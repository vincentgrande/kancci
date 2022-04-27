<?php

namespace App\Http\Controllers;
use App\KanbanLabel;
use App\User;
use App\WorkGroup;
use App\WorkgroupPendingInvitation;
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
     * Initialize index View
     * @param $id
     * @return Application|Factory|RedirectResponse|View
     */
    public function index($id)
    {
        $user = Auth::user();
        $workGroup = WorkGroup::where('created_by', $user->id)->where('id', $id)->with('creator')->first();
        $workgroupUser = WorkGroupUser::where('workgroup_id', $id)->with('user')->get();
        if ($workGroup == null & $workgroupUser == null) {
            return redirect()->route('index');
        }
        return view('workgroup', [
            'workgroup' => $workGroup,
            'workgroup_users' => $workgroupUser,
        ]);
    }

    /**
     * Create a new Kanban
     * @param Request $request
     * @return RedirectResponse
     */
    public function addKanban(Request $request): RedirectResponse
    {
        Kanban::create([
            'title' => $request->title,
            'workgroup_id' => $request->workgroup_id,
            'background' => '/wallpaper/' . $request->background . '.jpg',
            'visibility' => 'visible',
            'created_by' => Auth::user()->id,
        ]);
        KanbanLabel::create([
            'kanban_id' => Kanban::where('title',$request->title)->where('workgroup_id',$request->workgroup_id)->select('id')->first()->id,
            'label_id' => 1
        ]);
        KanbanLabel::create([
            'kanban_id' => Kanban::where('title',$request->title)->where('workgroup_id',$request->workgroup_id)->select('id')->first()->id,
            'label_id' => 2
        ]);
        KanbanLabel::create([
            'kanban_id' => Kanban::where('title',$request->title)->where('workgroup_id',$request->workgroup_id)->select('id')->first()->id,
            'label_id' => 3
        ]);
        return back();
    }

    /**
     * Get all the Kanban from a Workgroup
     * @param Request $request
     * @return Kanban | null
     */
    public function getKanban(Request $request)
    {

        $kanban = Kanban::where('workgroup_id', $request->workgroup_id)->get();
        return $kanban;

    }

    /**
     * Function to let a User leave a Workgroup
     * @param Request $request
     * @return string
     */
    public function leaveWorkgroup(Request $request): string
    {
        try
        {
            $workgroup_user = WorkGroupUser::where('workgroup_id', $request->workgroup_id)->where('user_id', Auth::user()->id)->first();
            if($workgroup_user != null)
            {
                $workgroup_user->delete();
            }
            return "true";
        }catch (Exception $ex)
        {
            return $ex->getMessage();
        }
    }

    /**
     * Trying to invite a User to a Workgroup
     * @param Request $request
     * @return String
     */
    public function inviteUser(Request $request) : String
    {
        try
        {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                WorkGroupUser::create([
                    'user_id' => $user->id,
                    'workgroup_id' => $request->workgroup_id
                ]);
            } else {
                WorkgroupPendingInvitation::create([
                    'email' => $request->email,
                    'workgroup_id' => $request->workgroup_id
                ]);
            }
            return "true";
        }
        catch (Exception $ex)
        {
            return $ex->getMessage();
        }
    }

    /**
     * Delete the invited User from a Workgroup
     * @param Request $request
     * @return string
     */
    public function deleteInvitedUser(Request $request): string
    {
        try {
            $user = User::where('email', $request->email)->first();
            $workgroup_pending_invitation = WorkgroupPendingInvitation::where('email', $request->email)->where('workgroup_id', $request->workgroup_id)->first();
            if ($user != null) {
                $workgroup_user = WorkGroupUser::where('id', $user->id)->where('workgroup_id', $request->workgroup_id)->first();
                if($workgroup_user != null)
                {
                    $workgroup_user->delete();
                }
                else
                {
                    if($workgroup_pending_invitation != null)
                    {
                        $workgroup_pending_invitation->delete();
                    }
                }
            } else {
                if($workgroup_pending_invitation != null)
                {
                    $workgroup_pending_invitation->delete();
                }
            }
            return "true";
        }
        catch (Exception $ex)
        {
            return $ex->getMessage();
        }
    }

    /**
     * Get WorkGroupUser by User id
     * @return WorkGroupUser | null
     */
    public function getWorkgroup()
    {
        $user = Auth::user();
        $workGroup = WorkGroupUser::where('user_id', $user->id)->with('user')->with('workgroup')->get();
        return $workGroup;
    }

    /**
     * Get Workgroup and WorkgroupUser by User id
     * @param $id
     * @return Application|Factory|View
     */
    public function getWorkgroupById($id)
    {
        $user = Auth::user();
        $workGroup = WorkGroup::where('created_by', $user->id)->where('id', $id)->with('creator')->get();
        $invited_users = WorkGroupUser::where('workgroup_id', $id)->with('user')->with('workgroup')->get();
        $pending_invitation = WorkgroupPendingInvitation::where('workgroup_id', $id)->with('workgroup')->get();
        return view('workgroup-info', [
            'workgroup' => $workGroup,
            'invited_users' => $invited_users,
            'pending_invitation' => $pending_invitation
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function UpdateWorkgroupInfos(Request $request)
    {
        $workgroup = WorkGroup::where('id', $request->id)->where('created_by', Auth::user()->id)->with('creator')->get();
        if ($workgroup == null) {
            throw new Exception("Workgroup was null");
        }
        $firstLetter = $request->title[0];
        $firstLetter = strtolower($firstLetter);
        WorkGroup::where('id', $request->id)->update(['title' => $request->title, 'logo' => "logos/" . $firstLetter . "_blue.png"]);
        return back();
    }

    /**
     * Add a new Workgroup
     * @param Request $request
     * @return RedirectResponse
     */
    public function addWorkgroup(Request $request): RedirectResponse
    {
        $firstLetter = $request->title[0];
        if(ctype_alpha($firstLetter)) {
            $firstLetter = strtolower($firstLetter);
            $workgroup = WorkGroup::create([
                'title' => $request->title,
                'logo' => "logos/" . $firstLetter . "_blue.png",
                'created_by' => Auth::user()->id,
            ]);
            WorkGroupUser::create([
                'user_id' => Auth::user()->id,
                'workgroup_id' => $workgroup->id,
                'isAdmin' => true,
            ]);
            return redirect()->route('index')->with('message', 'Workgroup created successfully !');
        }
        else
        {
            return redirect()->route('index')->with('error', 'Your first character must be a letter.');
        }
    }

    /**
     * Function to Initialize the view to manage user's rights on Workgroup
     * @param $id
     * @return Application|Factory|View|void
     */
    public function usersManagement($id)
    {
            $workgroupUser = WorkGroupUser::where('workgroup_id', $id)->with('user')->with('workgroup')->get();
            $workgroup = WorkGroup::where('id', $id)->first();
            if($workgroupUser != null)
            {
                return view('workgroup-user', [
                    'workgroup_users' => $workgroupUser,
                        'workgroup' => $workgroup,
                        ]);
            }
    }

    /**
     * Function to change Role from an User to a Workgroup
     * @param Request $request
     * @return bool
     */
    public function changeRole(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user != null)
        {
            $workgroup_user = WorkGroupUser::where('workgroup_id', $request->workgroup_id)->where('user_id', $user->id)->first();
            if($workgroup_user != null)
            {
                if($request->value == "1")
                {
                    $workgroup_user->update(['isAdmin' => true]);
                }
                else
                {
                    $workgroup_user->update(['isAdmin' => false]);
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        return true;
    }
}
