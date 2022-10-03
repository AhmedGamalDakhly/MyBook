<?php

namespace App\Providers;

use App\FriendRequest;
use App\Profile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class FriendsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get friends for the cuurent user
        view()->composer(['front.friends','front.messanger','front.layout.header','front.home'],function ($view){
            $user=auth()->user();
            $userID=$user['id'];
            $friendsIDs=FriendRequest::friendsIDs($userID);
            $data['myFriends']=Profile::whereIn('user_id',$friendsIDs)->get();
            $data['suggestedFriends']=Profile::whereNotIn('user_id',FriendRequest::mayBefriendsIDs($userID)->push($userID))->get();
            $data['sentRequests']=Profile::whereIn('user_id',FriendRequest::sentRequestsIDs($userID))->get();
            $data['receivedRequests']=Profile::whereIn('user_id',FriendRequest::receivedRequestsIDs($userID))->get();
            $data['chatID']="";
            $view->with($data);
        });



    }
}
