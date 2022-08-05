@extends('layouts.master', ['title' => 'Add User'])

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-title">Add User</h4>
    </div>
</div>

<form action="{{ route('hrd.users.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('hrd.users.form')

</form>
@stop

@section('footer')
<script>
    $(".select2").select2()
</script>
@stop