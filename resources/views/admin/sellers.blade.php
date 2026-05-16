@extends('layouts.app')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.sidebar')<section class="col-md-9 col-lg-10 py-4">
<h1 class="h3">Manage sellers</h1><div class="card border-0 shadow-sm"><table class="table align-middle mb-0"><thead><tr><th>Store</th><th>Owner</th><th>Status</th><th></th></tr></thead><tbody>
@foreach($sellers as $seller)<tr><td>{{ $seller->store_name }}</td><td>{{ $seller->user->name }}</td><td>{{ $seller->status }}</td><td class="text-end"><form class="d-inline" method="post" action="{{ route('admin.sellers.approve', $seller) }}">@csrf @method('patch')<button class="btn btn-sm btn-success">Approve</button></form> <form class="d-inline" method="post" action="{{ route('admin.sellers.reject', $seller) }}">@csrf @method('patch')<button class="btn btn-sm btn-outline-danger">Reject</button></form></td></tr>@endforeach
</tbody></table></div><div class="mt-3">{{ $sellers->links() }}</div></section></div></div>
@endsection
