@extends('layouts.master', ['title' => 'Voucher'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Add Voucher</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('admin.voucher.store') }}" method="post">
            @csrf
            @include('admin.voucher.form')
        </form>
    </div>
</div>
@stop

@section('footer')
<script>
    $("#random").on('click', function() {
        if ($(this).is(':checked')) {
            $(this).val(1)
            $(".kuota").empty().append('Total Generate')
            $(".kode").hide()
        } else {
            $(this).val(0)
            $(".kuota").empty().append('Kuota')
            $(".kode").show()
        }
    })
</script>
@stop