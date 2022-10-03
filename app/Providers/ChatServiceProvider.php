<?php

namespace App\Providers;

use App\Chat;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
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
        //check if the user has any new or unseen messages
        view()->composer(['front.layout.header'],function ($view){
            $userID=auth()->user()['id'];
            $chat['hasMsg']=false;
           if(count(Chat::unSeenMessages($userID))>0){
               $chat['hasMsg']=true; // user has unseen messages
           };
            $view->with($chat);
        });
    }
}
