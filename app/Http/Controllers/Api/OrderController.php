<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with('items.product', 'user')->latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'shipping_address' => ['required', 'min:10'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $products = Product::whereIn('id', collect($data['items'])->pluck('product_id'))->get()->keyBy('id');
            $subtotal = collect($data['items'])->sum(fn ($item) => $products[$item['product_id']]->price * $item['quantity']);

            $order = Order::create([
                'user_id' => $data['user_id'],
                'order_number' => 'API-'.Str::upper(Str::random(8)),
                'subtotal' => $subtotal,
                'tax' => round($subtotal * 0.05, 2),
                'shipping' => 99,
                'total' => $subtotal + round($subtotal * 0.05, 2) + 99,
                'shipping_address' => $data['shipping_address'],
            ]);

            foreach ($data['items'] as $item) {
                $product = $products[$item['product_id']];
                $order->items()->create([
                    'product_id' => $product->id,
                    'seller_id' => $product->seller_id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                ]);
            }

            return $order;
        });

        return response()->json($order->load('items.product'), 201);
    }

    public function show(Order $order)
    {
        return response()->json($order->load('items.product', 'payment'));
    }
}
