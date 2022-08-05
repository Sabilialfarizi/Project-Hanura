@extends('layouts.master', ['title' => 'Create Jam Masuk dan Pulang'])
@section('content')

<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Add Jam Masuk dan Pulang</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('hrd.jam.store') }}" method="post" id="form">
            @csrf
            @include('hrd.jam.form')
        </form>
    </div>
</div>
@stop
