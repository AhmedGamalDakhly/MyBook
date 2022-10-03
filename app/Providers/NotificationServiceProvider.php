<?php

namespace App\Providers;

use App\Chat;
use App\Http\Controllers\NotificationController;
use App\Notification;
use Illuminate\Support\ServiceProvider;


class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //Build Notification for (header and  notifications) views
        view()->composer(['front.layout.header','front.notifications'],function ($view){
            $userID=auth()->user()['id'];
            $myNotifications=Notification::getMyNotifications($userID);
            $notification['myNotificationsCount']=count(Notification::unseenNotifications($userID));
            $notification['myNotifications']=NotificationController::buildNotifications($userID,$myNotifications);
            $view->with($notification);
        });

    }
}
