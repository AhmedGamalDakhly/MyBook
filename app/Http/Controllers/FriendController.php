<?php

namespace App\Http\Controllers;

use App\FriendRequest;
use App\User;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ramsey\Collection\Collection;

class FriendController extends Controller
{

    /**
     * Get  Friends page (pending requests , my friends )
     * @return View
     */
    public function index()
    {
        return view('front.friends');
    }

    /**
     * Send Friend Request  to another user
     * @param  User  $user current authenticated user
     * @param  String  $friendID  of the  user to send friend request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addFriend(User $user,$friendID){
        $userID=$user['id'];
        $friendProfile=Profile::where('user_id',$friendID)->first();
        if($friendProfile){
            FriendRequest::make($userID,$friendID);
            NotificationController::Notify($userID, $friendID,'friend_requests','friend-request',[$friendID]);
            return response()->json(['check'=> 'success', 'msg' => 'friend-request sent']);
        }
        return response()->json(['check'=> 'failed' ]);
    }

    /**
     * Delete  Friend Request  (End Friendship between two users)
     * @param  User  $user current authenticated user
     * @param  String  $friendID  of the  user to send friend request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unFriend(User $user,$friendID){
        $userID=$user['id'];
        $profile=$user->profile;
        $friendProfile=Profile::where('user_id',$friendID)->first();
        FriendRequest::remove($userID,$friendID);
        $friendProfile->unFollowProfile($userID);
        $profile->unFollowProfile($friendID);
        NotificationController::Notify($userID, $friendID,'friend_requests','unfriend',[$friendID]);
        return response()->json(['check'=> 'success' , 'msg'=>'']);
    }

    /**
     * Accept Friend Request  (Start Friendship between two users)
     * @param  User  $user current authenticated user
     * @param  String  $friendID  of the  friend
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveFriendRequest(User $user,$friendID){
        $userID=$user['id'];
        FriendRequest::approve($userID,$friendID);
        $profile=$user->profile;
        $friendProfile=Profile::where('user_id',$friendID)->first();
        $friendProfile->followProfile($userID);
        $profile->followProfile($friendID);
        NotificationController::Notify($userID, $friendID,'friend_requests','friend-request-accept',[$friendID]);
        return response()->json(['check'=> 'success' , 'msg'=>'Request Approved']);

    }

    /**
     * Delete/Reject  Friend Request   between two users
     * @param  User  $user current authenticated user
     * @param  String  $friendID  of the  friend
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectFriendRequest(User $user,$friendID){
        $userID=$user['id'];
        FriendRequest::remove($userID,$friendID);
        NotificationController::Notify($userID, $friendID,'friend_requests','friend-request-reject',[$friendID]);
        return response()->json(['check'=> 'success' , 'msg'=>'friend request rejected']);
    }



}
