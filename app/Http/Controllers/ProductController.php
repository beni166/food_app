<?php

namespace App\Http\Controllers;


use App\Models\products;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function promotedProducts()
    {
        $now = now();

        // Récupérer tous les produits avec leurs promotions et catégories
        $products = Products::with(['promotion', 'category.promotion'])->get();

        $promoProducts = [];

        foreach ($products as $product) {
            $promo = null;

            // Vérifier si le produit a une promo active
            if (
                $product->promotion &&
                $product->promotion->reduction > 0 &&
                $now->between($product->promotion->date_debut, $product->promotion->date_fin)
            ) {
                $promo = $product->promotion;
            }
            // Sinon vérifier si la catégorie a une promo active
            elseif (
                $product->category &&
                $product->category->promotion &&
                $product->category->promotion->reduction > 0 &&
                $now->between($product->category->promotion->date_debut, $product->category->promotion->date_fin)
            ) {
                $promo = $product->category->promotion;
            }

            if ($promo) {
                // Ajouter la promo effective au produit
                $product->effective_promotion = $promo;
                $promoProducts[] = $product;
            }
        }

        return response()->json([
            'statut' => 200,
            'data' => $promoProducts
        ]);
    }



    public function foodsByCategory($id)
    {
        $products = Products::with(['category.promotion'])
            ->where('category_id', $id) // 🟢 FILTRAGE par catégorie
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'prix' => $product->prix,
                    'image' => $product->image,
                    'slug' => $product->slug,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,

                    // Promotion directe ou via catégorie
                    'promotion' => $product->promotion ?? $product->category->promotion,

                    // Inclure aussi les détails de la catégorie si besoin
                    'category' => $product->category,
                ];
            });

        return response()->json([
            'status' => 200,
            'data' => $products
        ]);
    }



    public function searchs(Request $request)
    {
        $request->validate([
            'p' => "nullable|string"
        ]);

        $search = $request->input('p');

        $product = products::with($search, function ($qBuilder) use ($search) {
            $qBuilder->where('name', 'like', "%$search%")->orwhereHas('category', function ($c) use ($search) {
                $c->where('name', 'like', "%$search%");
            });
        })->get();

        // Recherche par statut ou ID
        if ($search) {
            $search->where('name', "like", "%" . $search . "%");
        }


        return response()->json([
            'status' => 'success',
            'results' => $product
        ]);
    }


    public function search(Request $request)
    {
        $request->validate([
            'q' => 'nullable|string|max:255',
        ]);

        $query = $request->input('q');

        $products = products::with('category') // si tu veux inclure la catégorie dans le résultat
            ->when($query, function ($qBuilder) use ($query) {
                $qBuilder->where('name', 'like', "%$query%")
                    ->orWhereHas('category', function ($c) use ($query) {
                        $c->where('name', 'like', "%$query%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'results' => $products
        ]);
    }
}
