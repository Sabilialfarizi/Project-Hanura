@extends('layouts.master', ['title' => 'Payment'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Edit Payment</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('admin.payments.update', $payment->id) }}" method="post">
            @method('PATCH')
            @csrf
            @include('admin.payment.form')
        </form>
    </div>
</div>
@stop