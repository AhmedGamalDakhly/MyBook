<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
/**
 * new chat message event class used to implements real time chat application by broadcasting new messages using broadcast channels
 *
 */
class NewChatMessage implements ShouldBroadcast
{


    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $text;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$text)
    {
        $this->text=$text;
        $this->message=$message;
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat-channel123');
    }
}
