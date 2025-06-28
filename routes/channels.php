<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// routes/channels.php


Broadcast::channel('show12', function () {
    return true; // libera acesso total (somente para testes!)
});
Broadcast::channel('chat', function () {
    return true; // libera acesso total (somente para testes!)
});
