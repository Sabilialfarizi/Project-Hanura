@extends('layouts.master', ['title' => 'Roles'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-md-6">
        <h1 class="page-title">Edit Roles</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="post">
            @method('PATCH')
            @csrf
            @include('admin.roles.form')
        </form>
    </div>
</div>
@stop

@section('footer')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
@stop