@extends('layouts.master', ['title' => 'Komisi'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Edit Komisi</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('admin.komisi.update', $komisi->id) }}" method="post">
            @method('PATCH')
            @csrf
            @include('admin.komisi.form')
        </form>
    </div>
</div>
@stop