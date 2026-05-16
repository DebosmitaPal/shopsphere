<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders', ['orders' => Order::with('user', 'payment')->latest()->paginate(15)]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate(['status' => ['required', 'in:pending,confirmed,packed,shipped,delivered,cancelled']]);
        $order->update($data);

        return back()->with('success', 'Order status updated.');
    }
}
