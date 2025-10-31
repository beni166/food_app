<?php

namespace App\Traits;

use App\Models\categories;
use App\Models\products;
use Illuminate\Support\Str;

trait UniqueSlugTrait
{
    function uniqueSlug($text, $model, $id = 0): string
    {
        $slug = Str::slug($text);
        $count = 1;
        while (true) {
            if ($model == "category") {
                if ($id != 0) {

                    if (!categories::where('slug', $slug)->where('id', '!=', $id)->first()) {
                        break;
                    }
                } else {
                    if (!categories::where('slug', $slug)->first()) {
                        break;
                    }
                }
            } else {
                if ($id != 0) {

                    if (!products::where('slug', $slug)->where('id', '!=', $id)->first()) {
                        break;
                    }
                } else {
                    if (!products::where('slug', $slug)->first()) {
                        break;
                    }
                }
            }
            $slug = $slug . '-' . 0 . $count;
            $count++;
        }
        return $slug;
    }
}
