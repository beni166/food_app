<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Promotion;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Notifications\OrderConfirmation;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function saveOrder(Request $request)
    {

        DB::beginTransaction();

        try {

            //Donnee de la commande

            $orderData = [
                'order_date' => now(),
                'user_id' => auth('sanctum')->user()->id
            ];

            //Valider les donnees recu

            $validator = Validator::make($request->all(), [
                'items' => 'required|array',
                'items.*.id' => 'required|exists:Products,id',
                'items.*.quantity' => 'required|integer|min:1'
            ], [
                'items.required' => 'Vous devez passer au moins un repas',
                'item.*.id.required' => 'Vous devez passer l\'identitifants des repas',
                'items.*.id.exists' => 'L\'identitifiant du repas est invalide'
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }

            $order = Order::createWithFood($orderData, $request->items);

            $user = auth()->user();

            DB::commit();
            return $this->successResponse([
                'order' => $order
            ], 'La commande à été enregistrée', 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function updateProductStatus(Request $request, $orderId, $productId)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'statut' => 'required|string'
                ],
                ['statut.required' => 'Le status de la command est requis']
            );
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }
            $orderId = Order::findOrFail($orderId);
            $product = $orderId->products()->findOrFail($productId);
            $product->pivot->statut = $request->statut;
            $product->pivot->save();
            $product->update();
            DB::commit();
            return $this->successResponse(['order' => $product], 'Commande mise à jour');
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), 500);
        }
    }




    public function getAll()
    {
        try {
            $orders = Order::where('user_id', auth('sanctum')->user()->id)
                ->with([
                    'products.promotion',
                    'products.category.promotion'
                ])
                ->orderBy('id', 'desc')
                ->get();

            foreach ($orders as $order) {
                foreach ($order->products as $product) {
                    // Historique
                    if ($product->promotion) {
                        $product->effective_promotion = $product->promotion;
                    } elseif ($product->category && $product->category->promotion) {
                        $product->effective_promotion = $product->category->promotion;
                    } else {
                        $product->effective_promotion = null;
                    }

                    // Promo active uniquement si dans la période
                    $today = now()->toDateString();
                    $product->active_promotion = null;
                    if ($product->effective_promotion) {
                        if ($product->effective_promotion->date_debut <= $today && $product->effective_promotion->date_fin >= $today) {
                            $product->active_promotion = $product->effective_promotion;
                        }
                    }
                }
            }

            return $this->successResponse(['items' => $orders], 'Commandes récupérées avec promotions');
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 500);
        }
    }







    public function getOne(Order $order)
    {
        try {

            $order->load('products');
            return $this->successResponse($order, 'Commande récupérée', 200);
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 500);
        }
    }

    public function changeStatus(Order $order, Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'statut' => 'required|string'
                ],
                ['statut.required' => 'Le status de la command est requis']
            );
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }
            $order->statut = $request->statut;
            $order->update();
            DB::commit();
            return $this->successResponse(['order' => $order], 'Commande mise à jour');
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
}
