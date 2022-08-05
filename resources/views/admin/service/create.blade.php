@extends('layouts.master', ['title' => 'Service'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-6">
        <h1 class="page-title">Add Service</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('admin.service.store') }}" method="post">
            @csrf
            @include('admin.service.form')
        </form>
    </div>
</div>
@stop