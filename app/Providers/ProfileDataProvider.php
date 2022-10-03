<?php

namespace App\Providers;

use App\Http\ProfileViewComposer;
use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ProfileDataProvider extends ServiceProvider
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
        //make basic info about the user profile available for these views
        view()->composer(['front.home','front.layout.header','front.profile','front.friends',
            'front.messanger','front.new_post','front.notifications',
            'front.groups','front.new_group','front.groupPage','front.notification_post',
            'front.members','front.about_group','front.settings'],ProfileViewComposer::class);

        //make profile settings  available for all views
        view()->composer('*',function ($view) {
            $user=Auth::user();
           $layout="";
            if($user){
                if($user->profile->settings()['layout']=='dark'){
                    $layout="\dark";
                }
            }
            return   $view->with('layout',$layout);
        });
    }
}
