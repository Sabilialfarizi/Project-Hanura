@extends('layouts.master', ['title' => 'Roles'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Edit Roles</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('hrd.permission.update', $permission->id) }}" method="post">
            @method('PATCH')
            @csrf
            @include('hrd.permission.form')
        </form>
    </div>
</div>
@stop