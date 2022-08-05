@extends('layouts.master', ['title' => 'Unit Rumah'])

@section('content')
<div class="row justify-content-left text-left">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Add Unit Rumah</h4>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-sm-12">
        <form action="{{ route('admin.unit.store') }}" method="post">
            @csrf
            @include('admin.unit.form')
        </form>
    </div>
</div>
@stop
