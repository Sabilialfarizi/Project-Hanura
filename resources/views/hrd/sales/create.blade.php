@extends('layouts.master', ['title' => 'Add Team Sales'])

@section('content')
<div class="row justify-content-left text-left">
    <div class="col-md-6">
        <h4 class="page-title">Add Team Sales</h4>
    </div>
</div>

<form action="{{ route('hrd.sales.store') }}" method="post" enctype="multipart/form-data">
    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    </div>
    @endif
    @csrf
    @include('hrd.sales.form')

</form>
@stop

@section('footer')
<script>
    $(".select2").select2()

</script>
@stop
