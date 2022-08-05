@extends('layouts.master', ['title' => 'Create Holidays Date'])
@section('content')

<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Add Holidays Date</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('hrd.holidays.store') }}" method="post" id="form">
            @csrf
            @include('hrd.holidays.form')
        </form>
    </div>
</div>
@stop
