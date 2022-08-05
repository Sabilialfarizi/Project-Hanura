@extends('layouts.master', ['title' => 'Status'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Edit Status</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('admin.status.update', $status->id) }}" method="post">
            @method('PATCH')
            @csrf
            @include('admin.status.form')
        </form>
    </div>
</div>

@stop