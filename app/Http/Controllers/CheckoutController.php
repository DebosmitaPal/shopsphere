<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderConfirmationMail;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->orWhere('session_id', session()->getId())->get();
        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $coupon = Coupon::where('code', session('coupon'))->first();
        $discount = $coupon?->discountFor($subtotal) ?? 0;

        return view('checkout.create', compact('cartItems', 'subtotal', 'coupon', 'discount'));
    }

    public function store(CheckoutRequest $request)
    {
        $cartItems = Cart::with('product.seller')->where('user_id', auth()->id())->orWhere('session_id', session()->getId())->get();

        abort_if($cartItems->isEmpty(), 422, 'Cart is empty.');

        $order = DB::transaction(function () use ($cartItems, $request) {
            $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
            $coupon = Coupon::where('code', session('coupon'))->first();
            $discount = $coupon?->discountFor($subtotal) ?? 0;
            $tax = round($subtotal * 0.05, 2);
            $shipping = $subtotal > 2000 ? 0 : 99;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'SS-'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'coupon_code' => $discount > 0 ? $coupon?->code : null,
                'discount' => $discount,
                'total' => max(0, $subtotal - $discount) + $tax + $shipping,
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;
                if ($product->stock_quantity < $item->quantity) {
                    abort(422, "{$product->name} is out of stock.");
                }
                $order->items()->create([
                    'product_id' => $product->id,
                    'seller_id' => $product->seller_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                    'total' => $product->price * $item->quantity,
                ]);
                $product->decrement('stock_quantity', $item->quantity);
            }

            $order->payment()->create([
                'method' => $request->payment_method,
                'amount' => $order->total,
                'status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
                'paid_at' => $request->payment_method === 'cod' ? null : now(),
            ]);

            Cart::whereIn('id', $cartItems->pluck('id'))->delete();
            session()->forget('coupon');

            return $order->load('items.product', 'payment');
        });

        Mail::to(auth()->user()->email)->send(new OrderConfirmationMail($order));

        return redirect()->route('orders.show', $order)->with('success', __('messages.order_placed'));
    }
}
