@extends('layouts.master', ['title' => 'Service'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Edit Service</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('admin.service.update', $service->id) }}" method="post">
            @method('PATCH')
            @csrf
            @include('admin.service.form')
        </form>
    </div>
</div>
@stop