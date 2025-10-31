<?php

namespace App\Http\Controllers\user;

use App\Events\MyEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  public function index()
  {
    $user = auth()->user();
    $orders = $user->order()->orderBy('id', 'desc')->get();
    //dd($orders);
    return view('user.orders.index', compact('orders'));
  }

  public function cancel($id)
  {
    $order = Order::where('id', $id)
      ->where('user_id', auth()->id()) // Sécurité : un user ne peut annuler que ses commandes
      ->firstOrFail();

    if (!in_array(strtolower($order->statut), ['en_attente', 'nouveau'])) {
      return response()->json([
        'success' => false,
        'message' => 'Impossible d\'annuler cette commande. Elle est déjà en cours de livraison ou livrée.'
      ], 403);
    }

    // Annuler la commande
    $order->statut = 'annuler';
    $order->save();

    $order->user->notify(new OrderStatusUpdated(
      $order,
      "Votre commande #{$order->id} a été annulée avec succès."
    ));

    return response()->json([
      'success' => true,
      'message' => 'Commande annulée avec succès'
    ]);
  }
}
