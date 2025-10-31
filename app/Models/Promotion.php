<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['titre', 'products_id', 'category_id', 'reduction', 'date_debut', 'date_fin'];

    public function product()
    {
        return $this->belongsTo(products::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function isActive()
    {
        $today = now()->toDateString();
        return $this->date_debut <= $today && $this->date_fin >= $today;
    }
}
