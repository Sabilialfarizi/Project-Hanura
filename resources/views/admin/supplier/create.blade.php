@extends('layouts.master', ['title' => 'Supplier'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Add Supplier</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('admin.supplier.store') }}" method="post">
            @csrf
            @include('admin.supplier.form')
        </form>
    </div>
</div>
@stop