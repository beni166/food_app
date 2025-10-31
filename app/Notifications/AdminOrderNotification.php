<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AdminOrderNotification extends Notification
{
    use Queueable;

    public $order;
    public $message;

    public function __construct(Order $order)
    {
        $this->order = $order->load('user');
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => "Nouvelle commande passée par {$this->order->user->name}",
            'url' => route('admin.notifications.read', $this->order->id),
        ];
    }

      public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            'user_name' => $this->order->user->name,
            'message' => 'Nouvelle commande reçue !',
        ]);
    }
}
