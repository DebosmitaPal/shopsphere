<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return view('seller.products.index', [
            'products' => auth()->user()->seller->products()->with('category')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('seller.products.form', ['product' => new Product, 'categories' => Category::where('is_active', true)->get()]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['seller_id'] = auth()->user()->seller->id;
        $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(5));
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('seller.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $this->authorizeSellerProduct($product);

        return view('seller.products.form', ['product' => $product, 'categories' => Category::where('is_active', true)->get()]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorizeSellerProduct($product);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }
        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeSellerProduct($product);
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    private function authorizeSellerProduct(Product $product): void
    {
        abort_unless($product->seller_id === auth()->user()->seller->id, 403);
    }
}
