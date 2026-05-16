<?php

namespace App\Http\Controllers;

use App\Models\Seller;

class StorefrontController extends Controller
{
    public function show(Seller $seller)
    {
        abort_unless($seller->status === 'approved', 404);

        return view('stores.show', [
            'seller' => $seller->load('user'),
            'products' => $seller->products()->with('category')->withCount('reviews')->visible()->paginate(8),
            'stats' => [
                'products' => $seller->products()->visible()->count(),
                'low_stock' => $seller->products()->where('stock_quantity', '<=', 5)->count(),
                'reviews' => $seller->products()->withCount('reviews')->get()->sum('reviews_count'),
            ],
        ]);
    }
}
