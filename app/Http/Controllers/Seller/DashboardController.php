<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $seller = auth()->user()->seller;
        $items = OrderItem::where('seller_id', $seller->id)->with('order', 'product');

        return view('seller.dashboard', [
            'seller' => $seller,
            'stats' => [
                'products' => $seller->products()->count(),
                'low_stock' => $seller->products()->where('stock_quantity', '<=', 5)->count(),
                'orders' => (clone $items)->count(),
                'sales' => (clone $items)->sum('total'),
            ],
            'recentItems' => $items->latest()->take(8)->get(),
            'lowStockProducts' => $seller->products()->where('stock_quantity', '<=', 5)->get(),
        ]);
    }
}
