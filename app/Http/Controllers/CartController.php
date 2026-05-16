<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return view('cart.index', ['cartItems' => $this->items($request)]);
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock_quantity]]);

        Cart::updateOrCreate(
            ['user_id' => optional($request->user())->id, 'session_id' => $request->session()->getId(), 'product_id' => $product->id],
            ['quantity' => $data['quantity']]
        );

        session(['cart_count' => Cart::where('session_id', $request->session()->getId())->sum('quantity')]);

        return back()->with('success', __('messages.added_to_cart'));
    }

    public function update(Request $request, Cart $cart)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $cart->update(['quantity' => min($data['quantity'], $cart->product->stock_quantity)]);

        return back()->with('success', __('messages.cart_updated'));
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return back()->with('success', __('messages.cart_updated'));
    }

    public function applyCoupon(Request $request)
    {
        $data = $request->validate(['code' => ['required', 'string', 'max:40']]);
        $subtotal = $this->items($request)->sum(fn ($item) => $item->product->price * $item->quantity);
        $coupon = Coupon::where('code', strtoupper($data['code']))->first();

        if (! $coupon || ! $coupon->isValidFor($subtotal)) {
            return back()->withErrors(['code' => 'Coupon is invalid, expired, or below minimum order value.']);
        }

        session(['coupon' => $coupon->code]);

        return back()->with('success', "Coupon {$coupon->code} applied.");
    }

    public function removeCoupon()
    {
        session()->forget('coupon');

        return back()->with('success', 'Coupon removed.');
    }

    private function items(Request $request)
    {
        return Cart::with('product.seller')
            ->where(fn ($query) => $query
                ->where('session_id', $request->session()->getId())
                ->when($request->user(), fn ($q) => $q->orWhere('user_id', $request->user()->id)))
            ->get();
    }
}
