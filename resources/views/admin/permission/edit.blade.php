@extends('layouts.master', ['title' => 'Permissions'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Edit Permissions</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="post">
            @method('PATCH')
            @csrf
            @include('admin.permission.form')
        </form>
    </div>
</div>
@stop