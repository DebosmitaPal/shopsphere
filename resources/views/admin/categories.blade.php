@extends('layouts.app')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.sidebar')<section class="col-md-9 col-lg-10 py-4">
<h1 class="h3">Manage categories</h1>
<form class="row g-2 mb-3" method="post" action="{{ route('admin.categories.store') }}">@csrf <div class="col-md-4"><input class="form-control" name="name" placeholder="Category name"></div><div class="col-md-6"><input class="form-control" name="description" placeholder="Description"></div><div class="col-md-2"><button class="btn btn-primary w-100">Add</button></div></form>
<div class="card border-0 shadow-sm"><table class="table mb-0"><tbody>@foreach($categories as $category)<tr><td>{{ $category->name }}</td><td>{{ $category->description }}</td><td>{{ $category->is_active ? 'Active' : 'Hidden' }}</td><td><form method="post" action="{{ route('admin.categories.destroy', $category) }}">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach</tbody></table></div>
</section></div></div>
@endsection
