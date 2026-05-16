<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('products.index', [
            'products' => Product::with(['category', 'seller'])->withCount('reviews')->visible()->filter($request->all())->paginate(12)->withQueryString(),
            'categories' => Category::where('is_active', true)->get(),
            'filters' => $request->only(['search', 'category', 'min_price', 'max_price']),
            'activeCompare' => session('compare', []),
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'seller.user', 'reviews.user']);
        $recentIds = collect(session('recently_viewed', []))
            ->reject(fn ($id) => (int) $id === $product->id)
            ->take(4)
            ->values();

        $updatedRecentIds = collect($recentIds->all())->prepend($product->id)->take(5)->values()->all();
        session(['recently_viewed' => $updatedRecentIds]);

        $recentlyViewed = Product::with(['category', 'seller'])
            ->withCount('reviews')
            ->whereIn('id', $recentIds)
            ->get();
        $bundleProducts = Product::with(['category', 'seller'])
            ->withCount('reviews')
            ->visible()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->orderByRaw('ABS(price - ?) ASC', [$product->price])
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'recentlyViewed', 'bundleProducts'));
    }
}
