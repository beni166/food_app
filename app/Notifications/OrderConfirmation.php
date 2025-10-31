<?php

namespace App\Notifications;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class OrderConfirmation extends Notification
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('products');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Génération du PDF
        $pdf = Pdf::loadView('pdf.order', [
            'order' => $this->order,
            'user' => $notifiable
        ]);

        // Sauvegarde temporaire dans storage/app/public/factures
        $filename = "facture_{$this->order->id}.pdf";
        Storage::put("public/factures/{$filename}", $pdf->output());

        // URL signée temporaire (valable 30 minutes)
        $url = URL::temporarySignedRoute(
            'facture.download',
            now()->addMinutes(30),
            ['order' => $this->order->id]
        );

        // Calcul du total et des détails
        $total = 0;
        $details = '';

        foreach ($this->order->products as $item) {
            $qty = $item->pivot->quantity;

            // Utiliser le prix mémorisé lors de la création de la commande
            $prix = $item->pivot->prix_order;

            $subtotal = $prix * $qty;
            $total += $subtotal;

            $details .= "- {$item->name} × {$qty} = " . number_format($subtotal, 0, ',', ' ') . " FCFA\n";
        }


        return (new MailMessage)
            ->subject('Confirmation de votre commande')
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Merci pour votre commande passée le {$this->order->order_date}.")
            ->line("Résumé :")
            ->line($details)
            ->line("💰 Total : {$total} FCFA")
            ->line("📎 Votre facture peut être téléchargée ici (valable 30 min) :")
            ->action('Télécharger la facture', $url)
            ->salutation('Cordialement, l’équipe de BEN SHOP.')
            ->attachData($pdf->output(), $filename, [
                'mime' => 'application/pdf',
            ]);
    }
}
