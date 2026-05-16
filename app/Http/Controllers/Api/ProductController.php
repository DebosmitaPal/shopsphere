<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(Product::with('category', 'seller')->filter($request->all())->paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seller_id' => ['required', 'exists:sellers,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:120'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
        ]);

        $product = Product::create($data + ['slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(5))]);

        return response()->json($product, 201)->header('X-ShopSphere', 'product-created');
    }

    public function show(Product $product)
    {
        return response()->json($product->load('category', 'seller', 'reviews'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['sometimes', 'exists:categories,id'],
            'name' => ['sometimes', 'max:120'],
            'description' => ['sometimes'],
            'price' => ['sometimes', 'numeric', 'min:1'],
            'stock_quantity' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', 'in:active,draft,inactive'],
        ]);
        $product->update($data);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
