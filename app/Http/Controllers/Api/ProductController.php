<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category'); 

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        if ($request->filled('search')) {
            $query->where('name', 'ilike', '%' . $request->input('search') . '%');
        }

        $limit = $request->input('limit', 20);
        $products = $query->paginate($limit);

        return response()->json([
            'success' => true,
            'message' => 'Ürünler başarıyla listelendi.',
            'data' => $products
        ], 200);
    }

    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'message' => 'Ürün detayı başarıyla getirildi.',
            'data' => $product->load('category')
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'category_id' => 'required|integer|exists:categories,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors()
            ], 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Ürün başarıyla eklendi.',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, Product $product)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:1',
                'stock_quantity' => 'required|integer|min:0',
                'category_id' => 'required|integer|exists:categories,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Ürün başarıyla güncellendi.',
            'data' => $product
        ], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ürün başarıyla silindi.',
            'data' => null
        ], 200);
    }
}