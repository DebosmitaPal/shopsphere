<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        return response()->json(Seller::with('user')->paginate(10));
    }

    public function update(Request $request, Seller $seller)
    {
        $data = $request->validate(['status' => ['required', 'in:pending,approved,rejected']]);
        $seller->update($data + ['approved_at' => $data['status'] === 'approved' ? now() : null]);

        return response()->json($seller);
    }
}
