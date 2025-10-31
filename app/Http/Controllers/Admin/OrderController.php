<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\products;
use App\Models\Promotion;
use App\Events\MyEvent;
use App\Events\MyUser;
use App\Notifications\OrderStatusUpdated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with([
            'user',
            'products',
            'products.category'
        ])->orderBy('id', 'desc')->get();

        // Calcul du total uniquement avec les prix sauvegardés dans la pivot
        foreach ($orders as $order) {
            $order->total_price = 0;

            foreach ($order->products as $product) {
                $order->total_price += $product->pivot->prix_order * $product->pivot->quantity;
            }
        }

        return view('Admin.orders.index', compact('orders'));
    }





    /**
     * Show the form for creating a new resource.
  

    
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation du statut
        $request->validate([
            'statut' => 'required|string|in:en_livraison,annuler,livrer,Nouveau',
        ]);

        $order = Order::findOrFail($id);
        $order->statut = $request->input('statut');
        $order->save();

        $order->user->notify(new OrderStatusUpdated(
            $order,
            "Le statut de votre commande #{$order->id} a été mis à jour : {$order->status}"
        ));
        event(new MyEvent("Votre commande a été mise à jour", auth()->id()));


        return response()->json(['success' => true]);
    }



    /**
     * Display the specified resource.
     */
    public function updateProductStatus(Request $request, $orderId, $productId)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'statut' => 'required|string|in:commandé,en_livraison,livrer'
                ],
                ['statut.required' => 'Le statut de la commande est requis']
            );

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }
            $order = Order::findOrFail($orderId);
            $product = $order->products()->findOrFail($productId);
            $product->pivot->statut = $request->statut;
            $product->pivot->save();
            $user = $order->user;
            $user->notify(new OrderStatusUpdated(
                $order,
                "Le produit **{$product->name}** de votre commande #{$order->id} est maintenant : {$request->statut}"
            ));
           
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Statut du produit mis à jour',
                'data' => [
                    'order' => $order->id,
                    'product' => $product->id,
                    'statut' => $request->statut
                ]
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), 500);
        }
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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $order = Order::findOrFail($id);
        return view('Admin.orders.orders', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAll()
    {

        $oders = Order::where('user_id', auth('sanctum')->user()->id)->with('products')->orderBy('id', 'desc')->get();
        return view('Admin.orders.orders', compact('orders'));
    }
}
