<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
 public function products()
    {
        return $this->hasMany(products::class);
    }
    public function promotion()
    {
        return $this->hasOne(Promotion::class)
            ->where('reduction', '>', 0)
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now());
    }
}
