@extends('layouts.master', ['title' => 'Master User'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Master User</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        @can('user-create')
        <a href="{{ route('admin.users.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add User</a>
        @endcan
    </div>
</div>

<x-alert></x-alert>

<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table datatable">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Cabang</th>
                        <th>Mac Address</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                            <span class="custom-badge status-blue">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->cabang->nama }}</td>
                        <td>{{ $user->mac_address }}</td>
                        <td>
                            @can('user-edit')
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('user-delete')
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" style="display: inline;" class="delete-form">
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