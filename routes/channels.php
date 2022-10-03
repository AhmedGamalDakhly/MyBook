<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*private channel for chatting app*/
Broadcast::channel('chat-channel{receiverID}', function ($user,$receiverID) {
    return $user->id === $receiverID;
});

/*private channel for notification feature*/
Broadcast::channel('notification-channel{receiverID}', function ($user,$receiverID) {
    return true;
});
