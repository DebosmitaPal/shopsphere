<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;

class SellerController extends Controller
{
    public function index()
    {
        return view('admin.sellers', ['sellers' => Seller::with('user')->latest()->paginate(15)]);
    }

    public function approve(Seller $seller)
    {
        $seller->update(['status' => 'approved', 'approved_at' => now()]);
        $seller->user->update(['status' => 'active']);

        return back()->with('success', 'Seller approved.');
    }

    public function reject(Seller $seller)
    {
        $seller->update(['status' => 'rejected']);
        $seller->user->update(['status' => 'inactive']);

        return back()->with('success', 'Seller rejected.');
    }
}
