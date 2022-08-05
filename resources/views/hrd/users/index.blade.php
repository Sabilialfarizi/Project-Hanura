@extends('layouts.master', ['title' => 'Master User'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Master User</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        <a href="{{ route('hrd.users.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add User</a>

    </div>
</div>
<x-alert></x-alert>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table report">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Jabatan</th>
                        <th>Perusahaan</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <th>{{ $user->name }}</th>
                        <th>{{ $user->email }}</th>
                        <th>
                            @foreach($user->roles as $role)
                            <span class="custom-badge status-blue">{{ $role->name }}</span>
                            @endforeach
                        </th>
                        <th>{{ $user->nama }}</th>
                        <th>{{ $user->nama_perusahaan }}</th>
                        <th>
                            <a href="{{ route('hrd.users.edit', $user->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('hrd.users.destroy', $user->id) }}" method="post" style="display: inline;" class="delete-form">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </th>
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
                title: 'Laporan Users ',
                messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Users ',
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