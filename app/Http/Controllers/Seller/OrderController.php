<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('seller.orders', [
            'items' => OrderItem::with('order.user', 'product')
                ->where('seller_id', auth()->user()->seller->id)
                ->latest()
                ->paginate(15),
        ]);
    }

    public function update(Request $request, OrderItem $item)
    {
        abort_unless($item->seller_id === auth()->user()->seller->id, 403);
        $data = $request->validate(['status' => ['required', 'in:packed,shipped,delivered']]);
        $item->order->update(['status' => $data['status']]);

        return back()->with('success', 'Order status updated.');
    }
}
