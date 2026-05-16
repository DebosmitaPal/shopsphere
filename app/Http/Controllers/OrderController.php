<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index', ['orders' => auth()->user()->orders()->latest()->paginate(10)]);
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id() || auth()->user()->role === 'admin', 403);

        return view('orders.show', ['order' => $order->load('items.product.seller', 'payment')]);
    }
}
