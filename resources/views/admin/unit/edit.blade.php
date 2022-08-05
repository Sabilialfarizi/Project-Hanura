@extends('layouts.master', ['title' => 'Unit Rumah'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Edit Unit Rumah</h4>
    </div>
</div>

<form action="{{ route('admin.unit.update', $unit->id_unit_rumah) }}" method="post">
    @method('PATCH')
    @csrf

    @include('admin.unit.form')
</form>
@stop
