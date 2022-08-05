@extends('layouts.master', ['title' => 'Pasien'])

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h4 class="page-title">Edit Pasien</h4>
    </div>
</div>
<form action="{{ route('admin.pasien.update', $pasien->id) }}" method="post" enctype="multipart/form-data">
    @method('PATCH')
    @csrf
    @include('admin.patient.form')
</form>
@stop