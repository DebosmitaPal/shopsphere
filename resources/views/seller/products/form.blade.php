@extends('layouts.app')
@section('content')
<div class="container-fluid"><div class="row">@include('seller.sidebar')<section class="col-md-9 col-lg-10 py-4">
<h1 class="h3">{{ $product->exists ? 'Edit product' : 'Add product' }}</h1>
<form class="card border-0 shadow-sm" method="post" enctype="multipart/form-data" action="{{ $product->exists ? route('seller.products.update', $product) : route('seller.products.store') }}">@csrf @if($product->exists) @method('put') @endif
<div class="card-body row g-3">
<div class="col-md-6"><input class="form-control" name="name" value="{{ old('name', $product->name) }}" placeholder="Product name" required></div>
<div class="col-md-6"><select class="form-select" name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></div>
<div class="col-md-4"><input class="form-control" name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" placeholder="Price" required></div>
<div class="col-md-4"><input class="form-control" name="stock_quantity" type="number" value="{{ old('stock_quantity', $product->stock_quantity ?? 1) }}" placeholder="Stock" required></div>
<div class="col-md-4"><select class="form-select" name="status"><option value="active">Active</option><option value="draft">Draft</option><option value="inactive">Inactive</option></select></div>
<div class="col-12"><textarea class="form-control" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea></div>
<div class="col-md-6"><input class="form-control" name="image" type="file" accept="image/*"></div>
<div class="col-12"><button class="btn btn-primary">Save product</button></div>
</div></form>
</section></div></div>
@endsection
