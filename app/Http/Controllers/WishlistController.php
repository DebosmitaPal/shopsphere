<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        return view('wishlist.index', ['items' => auth()->user()->wishlists()->with('product')->latest()->get()]);
    }

    public function store(Product $product)
    {
        Wishlist::firstOrCreate(['user_id' => auth()->id(), 'product_id' => $product->id]);

        return back()->with('success', 'Product added to wishlist.');
    }

    public function destroy(Wishlist $wishlist)
    {
        abort_unless($wishlist->user_id === auth()->id(), 403);
        $wishlist->delete();

        return back()->with('success', 'Wishlist updated.');
    }
}
