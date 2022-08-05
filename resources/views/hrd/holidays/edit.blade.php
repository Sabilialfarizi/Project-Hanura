@extends('layouts.master', ['title' => 'Edit Holidays Date'])
@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Edit Holidays Date</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('hrd.holidays.update', $Holidays->id) }}" method="post" id="form">
            @csrf
            @method('put')
            @include('hrd.holidays.form')

        </form>
    </div>
</div>

@stop
