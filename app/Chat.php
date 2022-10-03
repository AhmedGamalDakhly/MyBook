<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded=[];
    protected $casts = [
        'id' => 'string'
    ];
    public $incrementing = false;

    /**
     *  Get Chat (messages) between two users
     * @param String $senderID of the sender user
     * @param String $receiverID of the receive user
     * @return Collection
     */
    public static function messages($senderID,$receiverID){
       return  Chat::where(function ($query) use($senderID,$receiverID){
            $query->where('id',$senderID.'_'.$receiverID)
                ->orWhere('id',$receiverID.'_'.$senderID);
        })->orderBy('created_at','ASC')->get();
    }

    /**
     *  Get Chat only new messages  (unseen messages) for user
     * @param String $userID of the sender user
     * @return Collection
     */
    public static function unSeenMessages($userID){
        return  Chat::where(function ($query) use($userID){
            $query->where('receiver',$userID);
        })->where('status','unseen')->get();
    }
    /**
     *  set unseen messages between user and sender as seen
     * @param String $userID of the sender user
     *  @param String $senderID of the sender user
     * @return Collection
     */
    public static function setSeen($userID,$senderID){
        $msg = Chat::where(function ($query) use($senderID,$userID){
            $query->where('id',$senderID.'_'.$userID);
        })->where('status','unseen')->update(['status'=>'seen']);
    }


}
