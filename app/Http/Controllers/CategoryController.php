<?php

namespace App\Http\Controllers;
use App\Models\Categories;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = category::all();
        return response()->json([
            'status' => 200,
            'data' => $category
        ],200);
    }
}
