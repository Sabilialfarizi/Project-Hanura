@extends('layouts.master', ['title' => 'Komisi'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Add Komisi</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('admin.komisi.store') }}" method="post">
            @csrf
            @include('admin.komisi.form')
        </form>
    </div>
</div>
@stop