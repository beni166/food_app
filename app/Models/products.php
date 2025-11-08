<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'prix',
        'description',
        'image',
        'category_id',
        'created_at',
        'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_foods')
            ->withPivot('quantity', 'statut', 'prix_order', 'delivery_date')
            ->withTimestamps();
    }

    // Promotion directe sur ce produit
    public function promotion()
    {
        return $this->hasOne(Promotion::class, 'products_id')
            ->where('reduction', '>', 0)
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now());
    }

    // Récupère la meilleure réduction applicable
    public function getPromoReductionAttribute()
    {
        if ($this->promotion) {
            return $this->promotion->reduction;
        }

        $catPromo = Promotion::whereNull('products_id')
            ->where('category_id', $this->category_id)
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->first();

        if ($catPromo) return $catPromo->reduction;

        $globalPromo = Promotion::whereNull('products_id')
            ->whereNull('category_id')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->first();

        return $globalPromo ? $globalPromo->reduction : null;
    }

    // Prix après réduction
    public function getPrixAvecPromoAttribute()
    {
        $reduction = $this->promo_reduction;
        if ($reduction) {
            return intval($this->prix) * (1 - $reduction / 100);
        }
        return intval($this->prix);
    }
}
