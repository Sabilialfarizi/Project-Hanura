@extends('layouts.master', ['title' => 'Permissions'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Permissions</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        @can('permission-create')
        <a href="{{ route('admin.permissions.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Permission</a>
        @endcan
    </div>
</div>

<x-alert></x-alert>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Key Access</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $permission->key }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            @can('permission-edit')
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('permission-delete')
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="post" style="display: inline;" class="delete-form">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop