<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

use Illuminate\Notifications\Messages\DatabaseMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    public $order;
    public $message;

    public function __construct($order, $message)
    {
        $this->order = $order;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
        'message' => $this->message,
        'url' => route('user.notifications.read', $this->id), // <--- utiliser l'ID de la notification
    ];
    }

     public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            'user_name' => $this->order->user->name,
            'message' => 'Statut de changer !',
        ]);
    }
}
