<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Events\NotificationEvent;
use App\FriendRequest;
use App\Group;
use App\Profile;
use App\User;
use App\Notification;
use App\Content;
use http\Env\Request;
use Illuminate\Support\Str;
use Ramsey\Collection\Collection;

class NotificationController extends Controller
{
    //
    /**
     * Define Notification Messages
     */
    protected static $notificationMessages = [
        'post-create' => 'created a new post',
        'post-share'=>'shared your post',
        'your-post-share'=>'shared a post',
        'tag'=>'tagged you',
        'like-post'=>'liked your post',
        'like-comment'=>'liked your comment',
        'like-reply'=>'liked your reply',
        'comment-create'=>'comment on  your post',
         'reply-create'=>'replayed to your comment',
         'friend-create'=>'is now your friend',
        'friend-request'=>'sent you a friend request',
        'friend-request-reject'=>'rejected your friend request',
        'friend-request-accept'=>'accepted your friend request',
        'unfriend'=>'ended  friendship',
        'group-create'=>'created a new group',
        'group-request'=>'sent you a request to join your group',
        'group-request-accept'=>'accepted your  request to join their group',
        'group-request-reject'=>'rejected your  request to join their group',
        'group-member'=>'added you to their group',
        'group-member-remove'=>'removed you from their group',
        'group-invite'=>'invited you to their group',
        'group-invite-accept'=>'accepted your invite and joined your group',
        'group-invite-reject'=>'rejected your invite and joined your group',
        'group-exit'=>'leaved your group',
        'group-change-cover'=>'changed group cover image',

    ];

    /**
     *  View Available Notifications
     */
    public function index(){
        return view('front.notifications');
    }

    /**
     *  Create new notification with profile followers  as notification followers
     *
     * @param  Profile  $profile of the user caused the notification
     * @param  String  $contentID  of the content the notification made on
     * @param  String  $contentTable table of the content the notification made on
     * @param  String  $actionType type of action of the notification
     */
    public static function addNotification($profile,$contentID,$contentTable,$actionType){
        $notification['id']=Str::random(8);
        $notification['content_id']=$contentID;
        $notification['content_table']=$contentTable;
        $notification['user_id']=$profile['user_id'];
        $notification['content_table']=$contentTable;
        $notification['text']='substr();';//back here
        $notification['action_type']=$actionType;
        $follwers=$profile->followers();
        if($follwers){
            foreach ($follwers as $follwer){
                $notificationFollowers[$follwer]="unseen";
            }
            $notification['followers']=$notificationFollowers;

        }
        NotificationEvent::dispatch($notification,$follwers);
        Notification::create($notification);
    }

    /**
     *  Create new notification with specific followers  as notification followers
     *
     * @param  Profile  $profile of the user caused the notification
     * @param  String  $contentID  of the content the notification made on
     * @param  String  $contentTable table of the content the notification made on
     * @param  String  $actionType type of action of the notification
     * @param  Array  $followers array of followers of this notification
     */
    public static function Notify($userID,$contentID,$contentTable,$actionType,$followers){
        $notification['id']=Str::random(8);
        $notification['content_id']=$contentID;
        $notification['content_table']=$contentTable;
        $notification['user_id']=$userID;
        $notification['content_table']=$contentTable;
        $notification['text']='substr();';//back here
        $notification['action_type']=$actionType;
        if($followers){
            foreach ($followers as $follwer){
                $notificationFollowers[$follwer]="unseen";
            }
        }
        $notification['followers']=$notificationFollowers;
        NotificationEvent::dispatch($notification,$notificationFollowers);
        Notification::create($notification);
    }

    /**
     * Delete notification
     *
     * @param  String  $userID   of the user caused the notification
     * @param  String  $contentID  of the content the notification made on
     * @param  String  $actionType type of action of the notification
     */
    public static function deleteNotification($userID,$contentID,$actionType){
        $notification=Notification::where(function ($query) use ($userID,$contentID,$actionType){
            $query->where('content_id',$contentID)
                ->where('user_id',$userID)
                ->where('action_type',$actionType);
        })->delete();
    }

    /**
     * Show Content of the notification (make link for that content )
     *
     * @param  User  $user  current authenticated user
     * @param  String  $notificationID  of the  notification to get Content
     */
    public static function showContent(User $user ,$notificationID){
        $notification= Notification::where('id',$notificationID)->first();
        $actionType=$notification['action_type'];
        if($notification){
        $notification->setSeen($user['id']);
        switch ($notification['content_table']){
            case 'posts':
                $content['posts']=array(Content::getParentPost($notification['content_id']));
                $content['pageID']=$user['id'];
                $content['pageType']='profile';
                return view('front.notification_post')->with($content);
            case 'friend_requests' :
                return redirect()->route('friends.route');
            case 'groups' :
                if($actionType=='group-member' || $actionType='group-request-accept'){
                    return redirect()->route('group.route',$notification['content_id']);
                }
                return redirect()->route('groups.route');
            default :
                return redirect()->back();
        }
        }
        return redirect()->back();
    }

    /**
     * Set notification state as seen
     *
     * @param  User  $user  current authenticated user
     * @param  String  $notificationID  of the  notification to set  seen
     */
    public static function setSeen(User $user ,$notificationID){
        $notification= Notification::where('id',$notificationID)->first();
        $notification->setSeen($user['id']);
        return response()->json(['check'=> 'success','msg'=> 'seen']);
    }

    /**
     * Build notification Message
     *
     * @param  String  $userID   of current authenticated user
     * @param  Collection  $myNotes  collection my  notifications
     */
    public static  function buildNotifications($userID,$myNotes){
        $notificationBuilder=array();
        foreach ($myNotes as $notification){
            $userProfile=  Profile::select('name')->where('user_id',$notification['user_id'])->first();
            $notification['state']=$notification->isSeen($userID);
            $notification['category']=$notification['content_table'];
            $notification['userName']=$userProfile['name'];
            if(key_exists($notification['action_type'],self::$notificationMessages)){
                $notification['msg']=self::$notificationMessages[$notification['action_type']];
            }else{
                $notification['msg']="message not defined";
            }

            $notificationBuilder[]=$notification;
        }
        return $notificationBuilder;
    }

}
