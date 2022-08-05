@extends('layouts.master', ['title' => 'Permissions'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Add Roles</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('hrd.permission.store') }}" method="post">
            @csrf
            @include('hrd.permission.form')
        </form>
    </div>
</div>
@stop