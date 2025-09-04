<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
     \Illuminate\Support\Facades\Log::info("Broadcast channel check: user {$user->id}, id={$id}");
    return (int) $user->id === (int) $id;
});
