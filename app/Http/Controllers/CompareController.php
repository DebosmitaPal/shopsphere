<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        return view('compare.index', [
            'products' => Product::with('category', 'seller')->whereIn('id', session('compare', []))->get(),
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $items = collect(session('compare', []))->push($product->id)->unique()->take(4)->values()->all();
        session(['compare' => $items]);

        return back()->with('success', 'Product added to comparison.');
    }

    public function destroy(Request $request, Product $product)
    {
        session(['compare' => collect(session('compare', []))->reject(fn ($id) => (int) $id === $product->id)->values()->all()]);

        return back()->with('success', 'Comparison updated.');
    }

    public function clear()
    {
        session()->forget('compare');

        return redirect()->route('products.index')->with('success', 'Comparison cleared.');
    }
}
