<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function products()
    {
        return $this->belongsToMany(products::class, 'orders_foods')
            ->withPivot('quantity', 'statut', 'prix_order', 'delivery_date')
            ->withTimestamps();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function createWithFood($orderData, $items)
    {
        $order = self::create($orderData);

        foreach ($items as $item) {
            $product = Products::with('promotion')->findOrFail($item['id']);

            // Initialisation du prix
            $prix = $product->prix;

            // Application de la réduction s'il y a une promotion
            if ($product->promotion && $product->promotion->reduction > 0) {
                $reduction = $product->promotion->reduction;
                $prix = $prix - ($prix * $reduction / 100);
            }


            // Attachement dans la table pivot
            $order->products()->attach($product->id, [
                'quantity' => $item['quantity'],
            ]);
        }

        return $order;
    }
}
