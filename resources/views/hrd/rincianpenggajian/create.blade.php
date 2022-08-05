@extends('layouts.master', ['title' => 'Create Rincian Gaji'])
@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Add Rincian Gaji</h4>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('hrd.rincianpenggajian.store') }}" method="post" id="form">
            @csrf
            @include('hrd.rincianpenggajian.form')
        </form>
    </div>
</div>
@stop
