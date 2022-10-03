<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Ramsey\Collection\Collection;

class FriendRequest extends Model
{
    // fillable and protected fields
    protected $guarded=[];
    protected $casts = [
        'id' => 'string'
    ];

    /**
     *  Check if two users are friends
     * @param  String  $userID ,  of the first user to be cheked
     * @param  String  $friendID ,  of the second user to be cheked
     * @return FriendRequest|null
     */
    public static function isFriend($userID,$friendID){
        $friend=FriendRequest::where(function ($query) use ($userID,$friendID){
            $query->where('id',$userID.'_'.$friendID)
                ->orWhere('id',$friendID.'_'.$userID);
        })->where('status','approved')->first();
        return $friend;
    }
    /**
     *  Check if user sent friend request to another user
     * @param  String  $userID ,  of the first user
     * @param  String  $friendID ,  of the second user
     * @return FriendRequest|null
     */
    public static function isPendingRequest($userID,$friendID){
        $friend=FriendRequest::where(function ($query) use ($userID,$friendID){
            $query->where('id',$userID.'_'.$friendID)
                ->orWhere('id',$friendID.'_'.$userID);
        })->where('status','pending')->first();
        return $friend;
    }

    /**
     *  Make friend Request between two users are friends (status = pending)
     * @param  String  $userID ,  of the first user
     * @param  String  $friendID ,  of the second user
     * @return FriendRequest
     */
    public static function make($userID,$friendID){
        $requestID=$userID.'_'.$friendID;
        $friendRequest['id']=$requestID;
        $friendRequest['user_id']=$userID;
        $friendRequest['friend_id']=$friendID;
        $friendRequest['type']='normal';
        $friendRequest['status']='pending';
        return FriendRequest::create($friendRequest);
    }

    /**
     * Change friendship type between two users are friends (type = normal , family , mutual , work)
     * @param  String  $type of relationship
     * @return void
     */
    public function setType($type){
        $this->update(['type'=>$type]);
    }
    /**
     * End (delete) friendship  between two users
     * @param  String  $userID ,  of the first user
     * @param  String  $friendID ,  of the second user
     * @return void
     */
    public static function remove($userID,$friendID){
        $friendRequest = FriendRequest::where(function ($query) use($friendID,$userID) {
            $query->where('id',$userID.'_'.$friendID)
            ->orwhere('id',$friendID.'_'.$userID);
        })->first();
        if($friendRequest){
            $friendRequest->delete();
        }
    }

    /**
     * Approve (accept) friend request between two users (status = approved) [became friends]
     * @param  String  $userID ,  of the first user
     * @param  String  $friendID ,  of the second user
     * @return void
     */
    public static function approve($userID,$friendID){
        FriendRequest::where(function ($query) use ($userID,$friendID){
            $query->where('id',$friendID.'_'.$userID)
                ->orWhere('id',$userID.'_'.$friendID);
        })->update(['status'=>'approved']);
    }

    /**
     * Reject  friend request between two users (status = rejected)
     * @param  String  $userID ,  of the first user
     * @param  String  $friendID ,  of the second user
     * @return void
     */
    public static function reject($userID,$friendID){
        self::remove($userID,$friendID);
    }
    public static function getFriend($friendID){
        $friend=FriendRequest::where(function ($query) use ($friendID){
            $query->where('user_id',$friendID)
                ->orWhere('friend_id',$friendID);
        })->first();
        return $friend;
    }

    /**
     * Get  pending friend requests (sent or received) for a user
     * @param  String  $userID ,  of the  user to get pending requests
     * @return Collection
     */
    public static function friendRequests($userID){
        $friends=FriendRequest::where(function ($query) use ($userID){
            $query->where('user_id',$userID)
                ->orWhere('friend_id',$userID);
        })->where('status','approved')->get();
        $collection1=$friends->pluck('status','user_id');
        $collection2=$friends->pluck('status','friend_id');
        $friendRequests=$collection1->merge($collection2)->forget($userID);
        return $friendRequests;
    }
    /**
     * Get  sent pending friend requests (sent only) for a user
     * @param  String  $userID ,  of the  user
     * @return Collection
     */
    public static function sentRequests($userID){
        $sentRequests=FriendRequest::select('id','status','user_id')->where('user_id',$userID)->get();
        $mappedRequests=$sentRequests->map(function ($ele) {
            return ['id'=>$ele['id'],'friend_id' => $ele['user_id'] , 'status'=> $ele['status'], 'direction'=>'sent'];
        });;
        return $mappedRequests;
    }

    /**
     * Get  received pending friend requests (received only) for a user
     * @param  String  $userID ,  of the  user
     * @return Collection
     */
    public static function receivedRequests($userID){
        $receviedRequests=FriendRequest::select('id','status','friend_id')->where('friend_id',$userID)->get();
        $mappedRequests=$receviedRequests->map(function ($ele) {
            return ['id'=>$ele['id'],'user_id' => $ele['friend_id'] , 'status'=> $ele['status'], 'direction'=>'received'];
        });;
        return $mappedRequests;
    }

    /**
     * Get  pending friend requests (sent or received) for a user
     * @param  String  $userID ,  of the  user to get pending requests
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function requests($userID){
       $sentRequests=FriendRequest::sentRequests($userID);
       $receviedRequests=FriendRequest::receivedRequests($userID);
       $requests=$sentRequests->merge($receviedRequests);
        return $requests;
    }

    /**
     * Get   friends ids for a user
     * @param  String  $userID ,  of the  user to friends
     * @return Collection
     */
    public static function friendsIDs($userID){
        $friends=FriendRequest::where(function ($query) use ($userID){
            $query->where('user_id',$userID)
                ->orWhere('friend_id',$userID);
        })->where('status','approved')->get();
        $collection1=$friends->pluck('user_id')->reject($userID);
        $collection2=$friends->pluck('friend_id')->reject($userID);
        $friendsIDs=$collection1->merge($collection2);
        return $friendsIDs;
    }

    /**
     * Get   all my friend requests (pending :sent received  status :rejected or approved )
     * @param  String  $userID ,  of the  user to friends
     * @return Collection
     */
    public static function mayBefriendsIDs($userID){
        $friends=FriendRequest::where(function ($query) use ($userID){
            $query->where('user_id',$userID)
                ->orWhere('friend_id',$userID);
        })->get();
        $collection1=$friends->pluck('user_id');
        $collection2=$friends->pluck('friend_id');
        $friendsIDs=$collection1->merge($collection2)->forget($userID);
        return $friendsIDs;
    }

    /**
     * Get  sent friend requests ids (pending :sent status :pending )
     * @param  String  $userID ,  of the  user
     * @return Collection
     */
    public static function sentRequestsIDs($userID){
        $sentRequestIDs=FriendRequest::select('friend_id')->where(function ($query) use ($userID){
            $query->where('user_id',$userID)
            ->where('status','pending');
        })->get();
        return $sentRequestIDs->pluck('friend_id');
    }
    /**
     * Get  received friend requests ids (pending :received status :pending )
     * @param  String  $userID ,  of the  user
     * @return Collection
     */
    public static function receivedRequestsIDs($userID){
        $receivedRequestIDs=FriendRequest::select('user_id')->where(function ($query) use ($userID){
            $query->where('friend_id',$userID)
                ->where('status','pending');
        })->get();
        return $receivedRequestIDs->pluck('user_id');
    }


}
