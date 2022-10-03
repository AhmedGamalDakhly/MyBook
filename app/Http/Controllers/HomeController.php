<?php

namespace App\Http\Controllers;

use App\FriendRequest;
use App\Profile;
use App\User;
use App\Content;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     *  Get HomePage
     * @param  User  $user cuurent authenticated user
     * @return \Illuminate\View\View
     */
    public function index(User $user){
        $postsLimit=10;
        $userID=$user['id'];
        $timeLinePosts=self::homePosts($user->profile,$postsLimit);
        $HomePageData['posts']=$timeLinePosts;
        $HomePageData['pageType']='profile';
        $HomePageData['pageID']=$userID;
        $HomePageData['posts']=$timeLinePosts;
        return view('front.home')->with($HomePageData);
    }

    /**
     *  Get posts required for HomePage
     * @param  Profile  $profile of user
     * @return Collection of posts
     */
    public static function homePosts($profile,$limit=10){
       $followings=$profile->followings();
        if($followings) {
            $followings[]=$profile['user_id'];
           $timeLinePosts = Content::where(function ($query) use ($followings) {
               $query->whereIn('page_id', array_keys($followings))
                   ->whereIn('type', ['post', 'shared']);
           })->take($limit)->orderBy('updated_at', 'DESC')->get();
           return $timeLinePosts;
       }
        return null;
    }

}
