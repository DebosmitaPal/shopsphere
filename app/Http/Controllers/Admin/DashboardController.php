<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'revenue' => Order::sum('total'),
                'orders' => Order::count(),
                'sellers' => Seller::count(),
                'customers' => User::where('role', 'customer')->count(),
            ],
            'pendingSellers' => Seller::with('user')->where('status', 'pending')->latest()->get(),
            'lowStockProducts' => Product::with('seller')->where('stock_quantity', '<=', 5)->get(),
            'recentOrders' => Order::with('user')->latest()->take(8)->get(),
        ]);
    }
}
