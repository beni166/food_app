<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Events\AdminNotification;
use App\Models\Order;
use App\Models\products;
use App\Models\Promotion;
use App\Models\User;
use App\Notifications\AdminOrderNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Notifications\OrderConfirmation;
use App\Events\MyEvent;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = products::with('promotion', 'category')->orderByDesc('created_at');

        // Vérifie s’il y a un texte de recherche
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($cat) use ($search) {
                        $cat->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $products = $query->get();
        $categories = category::with('products')->get();

        return view('welcome', compact('categories', 'products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();

            $orderData = [
                'order_date' => now(),
                'user_id' => $user->id,
            ];

            // 🟢 Cas 1 : commande directe
            if ($request->has('produit_id')) {
                $request->validate([
                    'produit_id' => 'required|exists:products,id',
                    'quantite' => 'required|integer|min:1'
                ]);

                $order = Order::create($orderData);

                $product = Products::with(['promotion', 'category.promotion'])->findOrFail($request->produit_id);

                $finalPrice = $this->getFinalPrice($product);

                $order->products()->attach($product->id, [
                    'quantity' => $request->quantite,
                    'prix_order' => $finalPrice, // ✅ on garde le prix payé
                ]);
            }
            // 🟢 Cas 2 : commande via panier
            else {
                $request->validate([
                    'items' => 'required|array',
                    'items.*.id' => 'required|exists:products,id',
                    'items.*.quantity' => 'required|integer|min:1'
                ], [
                    'items.required' => 'Vous devez passer au moins un repas.',
                    'items.*.id.required' => 'L\'identifiant du repas est requis.',
                    'items.*.id.exists' => 'L\'identifiant du repas est invalide.',
                    'items.*.quantity.required' => 'La quantité est requise pour chaque produit.',
                    'items.*.quantity.integer' => 'La quantité doit être un nombre entier.',
                    'items.*.quantity.min' => 'La quantité doit être d\'au moins 1.'
                ]);

                $order = Order::create($orderData);

                foreach ($request->items as $item) {
                    $product = Products::with(['promotion', 'category.promotion'])->findOrFail($item['id']);

                    $finalPrice = $this->getFinalPrice($product);

                    $order->products()->attach($product->id, [
                        'quantity' => $item['quantity'],
                        'prix_order' => $finalPrice, // ✅ prix mémorisé
                    ]);
                }
            }

            // ✅ ENVOI DU MAIL AVEC PDF
            $user->notify(new OrderConfirmation($order));
            $admin = User::where('role', 'admin')->first();

            if ($admin) {
                $admin->notify(new AdminOrderNotification($order));
            }
            event(new AdminNotification("Nouvelle commande reçue !"));


            session()->forget('panier');
            DB::commit();
            return redirect()->route('welcome')->with('success', 'Commande passée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }

    /**
     * Calcul du prix final avec promo (produit, catégorie ou globale)
     */
    private function getFinalPrice(products $product)
    {
        $dateCommande = now()->toDateString();
        $promoProduit   = $product->promotion;
        $promoCategorie = $product->category?->promotion;
        $globalPromo    = Promotion::whereNull('products_id')->whereNull('category_id')->first();

        $isPromoActive = function ($promo) use ($dateCommande) {
            return $promo && $promo->date_debut <= $dateCommande && $promo->date_fin >= $dateCommande;
        };

        $finalPrice = $product->prix;

        if ($isPromoActive($promoProduit)) {
            $finalPrice = $product->prix - ($product->prix * $promoProduit->reduction / 100);
        } elseif ($isPromoActive($promoCategorie)) {
            $finalPrice = $product->prix - ($product->prix * $promoCategorie->reduction / 100);
        } elseif ($isPromoActive($globalPromo)) {
            $finalPrice = $product->prix - ($product->prix * $globalPromo->reduction / 100);
        }

        return $finalPrice;
    }



    public function showForm($id)
    {
        $produit = products::findOrFail($id); // récupère les infos du produit ou 404

        return view('Home.order', compact('produit'));
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


    private function errorResponse($message, $statusCode)
    {
        return response()->json([
            'status_code' => $statusCode,
            'status_message' => $message,
            'data' => null,
        ], $statusCode);
    }

    private function successResponse($data, $message, $statusCode = 200)
    {
        return response()->json([
            'status_code' => $statusCode,
            'status_message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
