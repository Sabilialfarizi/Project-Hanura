@extends('layouts.master', ['title' => 'Roles'])

@section('content')
<div class="row">
    <div class="col-md-6">
        <h1 class="page-title">Show Roles</h1>
        <div class="card">
            <div class="card-header">
                <h5 class="text-bold card-title">Show Role</h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <h5>Name : </h5>
                    <span class="custom-badge status-green">{{ $role->name }}</span>
                </div>
                <div class="">
                    <h5>Permissions : </h5>
                    @foreach($permissions as $permission)
                    <span class="badge badge-primary">{{ $permission->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop