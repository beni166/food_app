<?php

use Illuminate\Support\Facades\Broadcast;

// Canal privé pour les admins
Broadcast::channel('admin.notifications', function ($user) {
    // S'assure que $user n'est pas null
    return $user && ($user->is_admin ?? false);
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return $user && ((int)$user->id === (int)$userId);
});;
