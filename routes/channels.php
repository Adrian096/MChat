<?php

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

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('ChatApp.{id}', function ($user, $id) {
    if($user->canJoinRoom($id)){
        return ['id' => $user->id, 'name' => $user->name];
    }
});
