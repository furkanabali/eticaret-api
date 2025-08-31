<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->firstOrCreate(['user_id' => $user->id]);

        return response()->json([
            'success' => true,
            'message' => 'Sepet başarıyla getirildi.',
            'data' => $cart
        ], 200);
    }

    public function addItem(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors()
            ], 422);
        }

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $product = Product::find($request->product_id);

        if ($request->quantity > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Yeterli stok bulunmuyor.',
                'errors' => []
            ], 400);
        }

        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ürün sepete başarıyla eklendi.',
            'data' => $cart->load('cartItems.product')
        ], 200);
    }

    public function updateItem(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors()
            ], 422);
        }

        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Sepet bulunamadı.',
                'errors' => []
            ], 404);
        }

        $cartItem = $cart->cartItems()->where('product_id', $request->product_id)->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Ürün sepette bulunamadı.',
                'errors' => []
            ], 404);
        }

        $product = $cartItem->product;
        if ($request->quantity > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Yeterli stok bulunmuyor.',
                'errors' => []
            ], 400);
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        if ($cartItem->quantity <= 0) {
            $cartItem->delete();
            $message = 'Ürün sepetten başarıyla çıkarıldı.';
        } else {
            $message = 'Sepet miktarı başarıyla güncellendi.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $cart->load('cartItems.product')
        ], 200);
    }

    public function removeItem($product_id)
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Sepet bulunamadı.',
                'errors' => []
            ], 404);
        }

        $cartItem = $cart->cartItems()->where('product_id', $product_id)->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Ürün sepette bulunamadı.',
                'errors' => []
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ürün sepetten başarıyla çıkarıldı.',
            'data' => $cart->load('cartItems.product')
        ], 200);
    }

    public function clear()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Sepet zaten boş.',
                'errors' => []
            ], 404);
        }

        $cart->cartItems()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sepet başarıyla temizlendi.',
            'data' => null
        ], 200);
    }
}