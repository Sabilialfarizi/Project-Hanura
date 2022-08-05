@extends('layouts.master', ['title' => 'Roles'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Roles</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        @can('roles-create')
        <a href="{{ route('admin.roles.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Role</a>
        @endcan
    </div>
</div>

<x-alert></x-alert>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table report">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Key Access</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->key }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @can('roles-show')
                            <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                            @endcan
                            @can('roles-edit')
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('roles-delete')
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="post" style="display: inline;" class="delete-form">
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



@section('footer')
<script>
    $('.report').DataTable({
        dom: 'Bfrtip',
        buttons: [{
                extend: 'copy',
                className: 'btn-default',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                className: 'btn-default',
                title: 'Laporan Roles',
                messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Roles ',
                messageTop: 'Tanggal {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });
</script>
@stop