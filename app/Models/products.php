<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table = 'products';
    //
    protected $fillable = ['name', 'prix', 'description', 'image', 'category_id', 'created_at', 'updated_at'];


    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_foods')
            ->withPivot('quantity', 'statut','prix_order' ,'delivery_date')
            ->withTimestamps();
    }


    // Promo directe sur ce produit
    public function promotion()
    {
        return $this->hasOne(Promotion::class)
            ->where('reduction', '>', 0)
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->where(function ($query) {
                $query->whereNull('products_id')
                    ->orWhere('products_id', $this->id)
                    ->orWhereHas('category', function ($q) {
                        $q->where('id', $this->category_id);
                    });
            });
    }


    // Promo applicable : produit → catégorie → globale
    public function getPromoReductionAttribute()
    {
        // Promo sur le produit ?
        if ($this->promotion) {
            return $this->promotion->reduction;
        }

        // Promo sur la catégorie ?
        $catPromo = Promotion::whereNull('products_id')
            ->where('category_id', $this->category_id)
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->first();

        if ($catPromo) return $catPromo->reduction;

        // Promo globale ?
        $globalPromo = Promotion::whereNull('products_id')
            ->whereNull('category_id')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->first();

        return $globalPromo ? $globalPromo->reduction : null;
    }

    public function getPrixAvecPromoAttribute()
    {
        $reduction = $this->promo_reduction;
        if ($reduction) {
            return intval($this->prix) * (1 - $reduction / 100);
        }
        return intval($this->prix);
    }
}
