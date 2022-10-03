<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
/**
 * new notification event class used to implements real time notifications   by broadcasting new notifications  using broadcast channels
 *
 */
class NotificationEvent implements  ShouldBroadcast
{


    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notification;
    public $followers;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notification,$followers)
    {
        //
        $this->notification=$notification;
        $this->followers=$followers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels=array();
        foreach ($this->followers as $follower){
            $channels[]=new PrivateChannel('notification-channel'. $follower);
        }
        return $channels;
    }
}
