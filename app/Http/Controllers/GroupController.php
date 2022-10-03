<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use App\Content;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class GroupController extends Controller
{

    /**
     *  Show available Groups
     * @param  User  $user  of the user
     * @return View
     */
    public function index(User $user){
        $userID=$user['id'];
        $groups['joinedGroups']=Group::joinedGroups($userID);
        $groups['requestedGroups']=Group::requestedToJoin($userID);
        $groups['groupsInvitedTo']=Group::groupsInvitedTo($userID);
        $groups['suggestedGroups']=Group::suggestedGroups($userID);
        return view('front.groups')->with($groups);
    }

    /**
     *  Show Form to create a new Group
     * @return View
     */
    public function newGroupForm(){
        return view('front.new_group');
    }

    /**
     *  Create New Group
     * @param  Request  $request  http request
     * @param  User  $user  of the user
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function create(Request $request,User $user){
        $groupData=$request->validate([
            'name'=>['required','max:100','unique:groups,name'],
            'desc'=>['required','max:300'],
            'type'=>['required'],
        ]);
        $profile=$user->profile;
        $group=GroupController::makeGroup($user['id'],$groupData);
        NotificationController::addNotification($profile, $group['id'],'groups','group-create');
       // $profile->followGroup($group);
        return redirect()->route('groups.route');
    }

    /**
     *  Send Join Request to  Group
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group to request to join
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestJoin(User $user,$groupID){
        $userID=$user['id'];
        $group=Group::where('id',$groupID)->first();
        $group->addRequest($userID);
        NotificationController::addNotification($user->profile, $group['id'],'groups','group-request');
        return response()->json(['check'=> 'success', 'msg' => 'Request Sent']);
    }

    /**
     *  Accept Join Request for  Group
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group to accept request
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptRequest(User $user,$groupID,$memberID){
        $group=Group::where('id',$groupID)->first();
        $accessResponse = Gate::inspect('update',$group);
        if($accessResponse->allowed()) {
            $group->acceptRequest($memberID);
            NotificationController::addNotification($user->profile, $group['id'],'groups','group-request-accept');
            return response()->json(['check'=> 'success', 'msg' => $accessResponse->message()]);
        }
        return response()->json(['check'=> 'failed', 'msg' => $accessResponse->message()]);
    }

    /**
     *  Reject/Delete Join Request for  Group
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group to reject request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectRequest(User $user,$groupID,$memberID){
        $group=Group::where('id',$groupID)->first();
        $accessResponse = Gate::inspect('update',$group);
        if($accessResponse->allowed()) {
            $group->refuseRequest($memberID);
            NotificationController::addNotification($user->profile, $group['id'],'groups','group-request-reject');
            return response()->json(['check'=> 'success', 'msg' => $accessResponse->message()]);
        }
        return response()->json(['check'=> 'failed', 'msg' => $accessResponse->message()]);
    }

    /**
     * Cancel sent  Request to join   Group
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group to cancel request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelJoinRequest(User $user,$groupID){
        $userID=$user['id'];
        $group=Group::where('id',$groupID)->first();
        $group->removeRequest($userID);
        return response()->json(['check'=> 'success', 'msg' => 'Request Rejected']);
    }

    /**
     * Exit the Group (End Membership)
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group to exit
     * @return \Illuminate\Http\JsonResponse
     */
    public function exitGroup(User $user,$groupID){
        $group=Group::where('id',$groupID)->first();
        $group->removeMember($user['id']);
        NotificationController::addNotification($user->profile, $group['id'],'groups','group-exit');
        return response()->json(['check'=> 'success', 'msg' => "removed"]);
    }

    /**
     * Show Group (Open  the group)
     * @param  String  $groupID  of the group to exit
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function showGroup($groupID){
        $group=Group::where('id',$groupID)->first();
        $groupData['group']=$group;
        $groupData['pageType']='group';
        $groupData['pageID']=$groupID;
        if(Auth::user()->can('view',$group)){//check if user is member of the group
            $postsLimit=10;
            $groupData['posts']=Content::groupPosts($groupID,$postsLimit);;
        }
        return view('front.groupPage')->with($groupData);
    }

    /**
     * Get Members of Group
     * @param  String  $groupID  of the group to get members
     * @return View
     */
    public function showMembers($groupID){
        $group=Group::where('id',$groupID)->first();
        $groupData['group'] = $group;
        $groupData['pageType']='group';
        $groupData['pageID']=$groupID;
        $accessResponse = Gate::inspect('view',$group);
        if($accessResponse->allowed()) {
            $membersIDs=$group->membersIDs();
            $membersProfiles = Profile::whereIn('user_id',$membersIDs)->get();
            $suggestedMembers = Profile::whereNotIn('user_id',$membersIDs)->get();
            $groupRequests=$group->requests();
            if (is_array($groupRequests)) {
                $groupData['groupRequests'] = Profile::whereIn('user_id', $groupRequests)->get();
            }
            $groupData['suggestedMembers'] = $suggestedMembers;
            $groupData['groupMembers'] = $membersProfiles;
            return view('front.members')->with($groupData);
        }

        return view('front.about_group')->with($groupData);
    }


    /**
     * Change cover image of Group
     *  @param  Request  http request
     *  @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group to update cover
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeCover(Request $request,User $user,$groupID){
        $group = Group::where('id', $groupID)->first();
        $accessResponse = Gate::inspect('update',$group);
        if($accessResponse->allowed()) {
            if ($request->hasFile('imageFile')) {
                $userId = $user['id'];
                $validate = $request->validate([
                    'imageFile' => 'file'
                ]);
                $imgFile = $request->file('imageFile');
                $imgFilePath= Self::changeGroupCover($groupID,$imgFile);
                NotificationController::addNotification($user->profile, $group['id'],'groups','group-change-cover');
                return response()->json(['check' => 'success', 'msg' => $accessResponse->message(), 'imgSrc' => asset($imgFilePath)]);
            }
        }
        return response()->json([ 'check'=> 'failed','msg'=> $accessResponse->message()]);
    }

    /**
     * Change cover image of Group
     *  @param  Request  http request
     * @param  String  $groupID  of the group to update cover
     * @param  File  $imgFile  image to set as cover
     * @return String
     */
    public function changeGroupCover($groupID,$imgFile){
                $group = Group::where('id', $groupID)->first();
                $img = Image::make($imgFile);
                $imgName = "group_" . 'img' . rand(12345, 9999) . $groupID . '.' . $imgFile->getClientOriginalExtension();
                $groupPath = 'uploads/groups/group_' . $groupID . '/';
                $imgPath = $groupPath . $imgName;
                $path = public_path($groupPath);
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $img->save($imgPath);//need optimize group , profile path back here
                $group->update(['cover' => $imgName, 'path' => $groupPath]);
                return $imgPath;
    }

    /**
     * Add member to Group (Start  membership)
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group to add member
     * @param  String  $memberID  of user to add to the group
     * @return String
     */
    public function addMember(User $user,$groupID,$memberID){
        $group=Group::where('id',$groupID)->first();
        $accessResponse = Gate::inspect('update',$group);
        if($accessResponse->allowed()) {
         $memberProfile=Profile::where('user_id',$memberID)->first();
         $group->addMember($memberID);
        $memberProfile->follow($groupID,'group');
         NotificationController::addNotification($user->profile, $group['id'],'groups','group-member');
        return response()->json(['check'=> 'success', 'msg' => $accessResponse->message()]);
        }
        return response()->json(['check'=> 'failed', 'msg' => $accessResponse->message()]);
    }

    /**
     * Remove member from Group (End  membership)
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group to add member
     * @param  String  $memberID  of user to add to the group
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeMember(User $user,$groupID,$memberID){
        $memberProfile=Profile::where('user_id',$memberID)->first();
        $group=Group::where('id',$groupID)->first();
        $accessResponse = Gate::inspect('update',$group);
        if($accessResponse->allowed()) {
        $group->removeMember($memberID);
        $memberProfile->unFollow($groupID,'group');
        NotificationController::addNotification($user->profile, $group['id'],'groups','group-member-remove');
            return response()->json(['check'=> 'success', 'msg' => $accessResponse->message()]);
        }
        return response()->json(['check'=> 'failed', 'msg' => $accessResponse->message()]);
    }

    /**
     * Invite user to join Group (send invitation to user)
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group
     * @param  String  $memberID  of user to invite to the group
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(User $user,$groupID,$memberID){

        $userID=$user['id'];
        $group=Group::where('id',$groupID)->first();
        $accessResponse = Gate::inspect('update',$group);
        if($accessResponse->allowed()) {
            if($group->isInvited($memberID)){
                NotificationController::deleteNotification($userID, $group['id'],'group-invite');
                $group->removeInvitation($memberID);
                return response()->json(['check'=> 'success', 'msg' => "Invite"]);
            }else{
                NotificationController::addNotification($user->profile, $group['id'],'groups','group-invite');
                $group->addInvitation($memberID);
                return response()->json(['check'=> 'success', 'msg' => "Invite Sent"]);
            }
         }
        return response()->json(['check'=> 'success', 'msg' =>  $accessResponse->message() ]);

    }

    /**
     * Accept Invitation  to join Group
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptInvite(User $user,$groupID){
        $group=Group::where('id',$groupID)->first();
            $profile=$user->profile;
            $group->acceptInvitation($user['id']);
            $profile->follow($groupID,'group');
            NotificationController::addNotification($profile, $group['id'], 'groups', 'group-invite-accept');
            return response()->json(['check' => 'success', 'msg' => "Invite Accepted"]);

    }

    /**
     * Reject/Refuse Invitation  to join Group
     * @param  User  $user  current authenticated user
     * @param  String  $groupID  of the group
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectInvite(User $user,$groupID){
        $profile=$user->profile;
        $group=Group::where('id',$groupID)->first();
        $group->refuseInvitation($user['id']);
        $profile->unFollow($groupID,'group');
        NotificationController::addNotification($profile, $group['id'],'groups','group-invite-reject');
        return response()->json(['check'=> 'success', 'msg' => "Invite Rejected"]);
    }

    /**
     * Make a new  Group
     * @param  String  $userID  used as owner of the  Group
     * @param  Array  $groupData  info used to make the group
     * @return Group
     */
    public static function makeGroup($userID,$groupData){
        $group['id']=Str::random(10);
        $group['name']=$groupData['name'];
        $group['desc']=$groupData['desc'];
        $group['type']=$groupData['type'];
        $group['members_count']=1;
        $group['members']=serialize(array($userID));
        $group['owner']=$userID;
        $group['path']='uploads/groups/default/';
        $group['cover']='default.png';
        $group['image']='default.png';
        $newGroup=Group::create($group);
        return $newGroup;
    }

}
