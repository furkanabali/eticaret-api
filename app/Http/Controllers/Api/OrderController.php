<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems.product')->get();

        return response()->json([
            'success' => true,
            'message' => 'Siparişler başarıyla listelendi.',
            'data' => $orders
        ], 200);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu siparişi görüntülemeye yetkiniz yok.',
                'errors' => []
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sipariş detayı başarıyla getirildi.',
            'data' => $order->load('orderItems.product')
        ], 200);
    }

    public function store()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Sepetiniz boş.',
                'errors' => []
            ], 400);
        }

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $orderItems = [];

            foreach ($cart->cartItems as $cartItem) {
                $product = $cartItem->product;

                if ($product->stock_quantity < $cartItem->quantity) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "{$product->name} ürünü için yeterli stok bulunmuyor. Mevcut stok: {$product->stock_quantity}",
                        'errors' => []
                    ], 400);
                }

                $totalAmount += $product->price * $cartItem->quantity;

                $product->stock_quantity -= $cartItem->quantity;
                $product->save();

                $orderItems[] = new OrderItem([
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                ]);
            }

            $order = new Order([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);
            $order->save();
            $order->orderItems()->saveMany($orderItems);

            $cart->cartItems()->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Siparişiniz başarıyla oluşturuldu.',
                'data' => $order->load('orderItems.product')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Sipariş oluşturulurken bir hata oluştu.',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}