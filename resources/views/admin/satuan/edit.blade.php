@extends('layouts.master', ['title' => 'Satuan Barang'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Edit Satuan Barang</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form  action="{{ route('admin.satuan.update', $satuan->id) }}" method="post">
            @method('PATCH')
            @csrf
            @include('admin.satuan.form')
        </form>
    </div>
</div>
@stop
