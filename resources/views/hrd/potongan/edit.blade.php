@extends('layouts.master', ['title' => 'Edit Potongan'])
@section('content')

<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Edit Potongan Gaji</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('hrd.potongan.update', $potongan->id) }}" method="post" id="form">
            @csrf
            @method('put')
            @include('hrd.potongan.form')

        </form>
    </div>
</div>

@stop
