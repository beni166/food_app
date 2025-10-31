<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\products;
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
        $query->where('products_id', $request->product_id);
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    $promotions = $query->orderBy('date_debut', 'desc')->get();

    $products = products::all();
    $categories = Category::all();

    return view('Admin.promotions.index', compact('promotions', 'products', 'categories'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = products::all();
        $categories = category::all();
        return view('Admin.promotions.promo', compact('products', 'categories'));
        //  return view('Admin.promotions.promo', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'products_id' => 'nullable|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Interdire que les deux soient remplis en même temps
        if ($request->filled('products_id') && $request->filled('category_id')) {
            return back()->withErrors(['error' => 'Une promotion ne peut pas cibler à la fois un produit et une catégorie.']);
        }

        Promotion::create([
            'titre' => $request->titre,
            'products_id' => $request->products_id,
            'category_id' => $request->category_id,
            'reduction' => $request->reduction,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);
     //   dd($request->category_id);

        return redirect()->route('welcome')->with('success', 'Promotion enregistrée avec succès.');
    }



    /**
     * Store a newly created resource in storage.
     */


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
    public function edit(Promotion $promotion)
    {
        $products = products::all();
        $categories = Category::all();
        return view('admin.promotions.edit', compact('promotion', 'products', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'reduction' => 'required|integer|min:1|max:100',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'products_id' => 'nullable|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->filled('product_id') && $request->filled('category_id')) {
            return back()->withErrors(['error' => 'Choisir un produit ou une catégorie, pas les deux.']);
        }

        $promotion->update($request->all());

        return redirect()->route('admin.promotion.index')->with('success', 'Promotion mise à jour.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return back()->with('success', 'Promotion supprimée.');
    }

    public function toggle(Promotion $promotion)
    {
        $promotion->update(['actif' => !$promotion->actif]);
        return back()->with('success', 'Statut de la promotion mis à jour.');
    }
}
