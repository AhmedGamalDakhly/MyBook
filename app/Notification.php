<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Not;
use PhpParser\Node\Expr\Array_;

class Notification extends Model
{

    protected $guarded = [];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $casts = [
        'followers' => 'array',
        'id' => 'string'
    ];

    /**
     * Get the user whose action fired or caused the notification
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     * Get the Profile of ueser whose action fired or caused the notification
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile(){//profile whose action fired or caused the notification
        return $this->belongsTo('App\Profile','user_id','user_id');
    }
    /**
     * Get the content that  action of notification  performed on it
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content(){
        return $this->belongsTo('App\Content','id','content_id');
    }

    /**
     * Get the followers of this notification (users who follow this notification and cares about it)
     * @return array of followers ids
     */
    public function followers(){
       return $this['followers'];
    }

    /**
     *  Add new follower to this notification
     *
     * @param  String  $userID of the follower
     * @return void
     */
    public  function addFollower($userID){
        $data = $this['followers'];
        $data[$userID] = 'unseen';
        $this->update(['followers'=>$data]);
    }

    /**
     *  Mark  this notification as seen (status = seen ) for specific follower(user)
     *
     * @param  String  $userID of the follower
     * @return void
     */
    public  function setSeen($userID){
        $data = $this['followers'];
        $data[$userID] = 'seen';
        $this->update(['followers'=>$data]);
    }
    /**
     *  check  notification status as ( seen or unseen ) for specific follower(user)
     *
     * @param  String of the follower
     * @return boolean
     */
    public  function isSeen($userID){
        $notificationFollowers = $this['followers'];
        if($notificationFollowers[$userID] =='seen'){
            return true;
        }
        return false;
    }

    /**
     *  remove  follower from  this notification followers
     *
     * @param  String  $userID of the follower
     * @return boolean
     */
    public  function removeFollower($userID){
        $data = $this['followers'];
        unset($data[$userID]);
        $this->update(['followers'=>$data]);
    }
    /**
     *  Check  if this user is follower for this notification
     *
     * @param  String  $userID of the follower
     * @return boolean
     */
    public  function isFollower($userID){
        $followers= $this['followers'];
        return isset($followers[$userID]);
    }


    /**
     *  Get notifications for user (notifications that the user follows)
     *
     * @param  String  $userID of the follower
     * @return array
     */
    public static  function getMyNotifications($userID){
       $notifications=Notification::orderBy('created_at','DESC')->get();
       $myNotifications=array();
        foreach ($notifications as $notification){
            if($notification->isFollower($userID)){
               $myNotifications[]=$notification;
           }
        }

        return $myNotifications;
    }

    /**
     *  Get only the unseen notifications for user (notifications that the user follows and didn't see )
     *
     * @param  String  $userID of the follower
     * @return array
     */
    public static  function unseenNotifications($userID){
        $notifications=Notification::orderBy('created_at','DESC')->get();
        $myNotifications=array();
        foreach ($notifications as $notification){
            $notificationFollowers = $notification['followers'];
            if($notification->isFollower($userID)){
                if($notificationFollowers[$userID] =='unseen'){
                    $myNotifications[]=$notification;
                }
            }
        }
        return $myNotifications;
    }

}
