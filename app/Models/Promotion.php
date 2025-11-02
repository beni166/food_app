<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Category;

class Promotion extends Model
{
    protected $fillable = [
        'titre',
        'products_id',
        'category_id',
        'reduction',
        'date_debut',
        'date_fin'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }

    public function category()
    {
        return $this->belongsTo(category::class, 'category_id');
    }

    public function isActive()
    {
        $today = now()->toDateString();
        return $this->date_debut <= $today && $this->date_fin >= $today;
    }
}
