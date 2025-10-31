<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MyEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;
    public $isAdmin;

    public function __construct($message, $userId, $isAdmin = false)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->isAdmin = $isAdmin;
    }

    public function broadcastOn()
    {
        if ($this->isAdmin) {
            // Canal privé pour tous les admins
            return new PrivateChannel('admin.notifications');
        }

        // Canal privé unique pour chaque utilisateur
        return new PrivateChannel("user.{$this->userId}.notifications");
    }

    public function broadcastAs()
    {
        return 'notification';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }
}
