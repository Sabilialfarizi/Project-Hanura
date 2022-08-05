@extends('layouts.master', ['title' => 'Simbol'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Add Simbol</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('admin.simbol.store') }}" method="post">
            @csrf
            @include('admin.simbol.form')
        </form>
    </div>
</div>
@stop