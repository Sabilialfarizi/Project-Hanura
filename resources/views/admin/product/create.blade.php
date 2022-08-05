@extends('layouts.master', ['title' => 'Create Barang'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Add Produk</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('admin.product.store') }}" method="post">
            @csrf

            @include('admin.product.form')
        </form>
    </div>
</div>
@stop