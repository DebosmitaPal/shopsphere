<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'featuredProducts' => Product::with(['category', 'seller'])->withCount('reviews')->visible()->latest()->take(8)->get(),
            'latestProducts' => Product::with(['category', 'seller'])->withCount('reviews')->visible()->oldest('stock_quantity')->take(4)->get(),
            'dealProducts' => Product::with(['category', 'seller'])->withCount('reviews')->visible()->orderBy('price')->take(3)->get(),
            'categories' => Category::where('is_active', true)->withCount('products')->get(),
            'stats' => [
                'sellers' => Seller::where('status', 'approved')->count(),
                'products' => Product::visible()->count(),
                'customers' => User::where('role', 'customer')->count(),
                'orders' => Order::count(),
            ],
        ]);
    }
}
