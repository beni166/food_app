<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;

class CartController extends Controller
{
    public function index()
    {
        $panier = session()->get('panier', []);
        $cartCount = count($panier);
        return view('Admin.cart.index', compact('panier', 'cartCount'));
    }

    public function ajouter(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour ajouter au panier.');
        }

        $product = products::with(['promotion', 'category.promotion'])->findOrFail($request->produit_id);
        $quantite = $request->quantite ?? 1;

        // Calculer la promo effective
        $promo = null;
        if ($product->promotion) {
            $promo = $product->promotion;
        } elseif ($product->category && $product->category->promotion) {
            $promo = $product->category->promotion;
        }

        // Préparer les données à stocker dans le panier
        $panier = session()->get('panier', []);

        if (isset($panier[$product->id])) {
            $panier[$product->id]['quantite'] += $quantite;
        } else {
            $panier[$product->id] = [
                'nom' => $product->name,
                'prix' => $product->prix,
                'quantite' => $quantite,
                'image' => $product->image,
                'promotion' => $promo ? [
                    'id' => $promo->id,
                    'titre' => $promo->titre,
                    'reduction' => $promo->reduction,
                    'date_debut' => $promo->date_debut,
                    'date_fin' => $promo->date_fin,
                ] : null,
            ];
        }


        session()->put('panier', $panier);

        // Pour debug, tu peux décommenter la ligne suivante
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Produit ajouté au panier avec succès '
            ]);
        }

    }


    public function modifier(Request $request)
    {
        $panier = session()->get('panier', []);
        $produit_id = $request->produit_id;

        if (isset($panier[$produit_id])) {
            $panier[$produit_id]['quantite'] = $request->quantite;
            session()->put('panier', $panier);
            return response()->json([
                'success' => true,
                'message' => 'Quantité mise à jour',
            ]);

        }

        return redirect()->back()->with('error', 'Produit non trouvé.');
    }

    public function supprimer(Request $request)
    {
        $panier = session()->get('panier', []);
        $produit_id = $request->produit_id;

        if (isset($panier[$produit_id])) {
            unset($panier[$produit_id]);
            session()->put('panier', $panier);
        }

        return redirect()->back()->with('success', 'Produit retiré du panier.');
    }
}
