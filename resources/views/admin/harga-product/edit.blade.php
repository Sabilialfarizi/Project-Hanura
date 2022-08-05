@extends('layouts.master', ['title' => 'Harga Produk'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">
            @if(request()->is('admin/price-product*'))
            Edit Harga Produk
            @else
            Edit Harga Service
            @endif
        </h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="/admin/price/{{ $price->id }}/update" method="post">
            @method('PATCH')
            @csrf

            @include('admin.harga-product.form')

            <div class="m-t-20 text-center">
                <button type="submit" class="btn btn-primary submit-btn">Update</button>
            </div>
        </form>
    </div>
</div>
@stop