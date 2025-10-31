<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Promotion::with(['product', 'category']);

        // Filtres dynamiques
        if ($request->filled('products_id')) {
            $query->where('products_id', $request->products_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // On récupère toutes les promotions actives et valides
        $promotions = $query->orderBy('date_debut', 'desc')->get()->map(function ($promo) {
            return [
                'id' => $promo->id,
                'title' => $promo->title,
                'description' => $promo->description,
                'discount' => $promo->discount,
                'date_debut' => $promo->date_debut,
                'date_fin' => $promo->date_fin,
                'products' => $promo->product ? [
                    'id' => $promo->product->id,
                    'name' => $promo->product->name,
                    'prix' => $promo->product->prix,
                    'image' => $promo->product->image_url ?? null,
                ] : null,
                'category' => $promo->category ? [
                    'id' => $promo->category->id,
                    'name' => $promo->category->name,
                ] : null,
            ];
        });

        return response()->json([

            'status' => 200,
            'data' => $promotions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
