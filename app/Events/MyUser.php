<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyUser implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $message;
    public $userId;

    public function __construct($message, $userId)
    {
        $this->message = $message;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->userId}.notifications");
    }

    public function broadcastAs()
    {
        return 'notify_user';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}
