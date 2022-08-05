@extends('layouts.master', ['title' => 'Master Jabatan'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Master Jabatan</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">

        <a href="{{ route('hrd.jabatan.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Jabatan</a>

    </div>
</div>

<x-alert></x-alert>

{{-- <form action="{{ route('hrd.jabatan.index') }}" method="get">
    <div class="row filter-row">
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">From</label>
                <div class="cal-icon">
                    <input class="form-control floating datetimepicker" type="text" name="from" required>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">To</label>
                <div class="cal-icon">
                    <input class="form-control floating datetimepicker" type="text" name="to" required>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <button type="submit" class="btn btn-success btn-block">Search</button>
        </div>
    </div>
</form> --}}
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table report">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($jabatan as $jabatans)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$jabatans->nama}}</td>
                        <td>{{$jabatans->perusahaan->nama_perusahaan}}</td>
                        <td>{{$jabatans->status}}</td>
                        <td>

                            <a href="{{ route('hrd.jabatan.edit', $jabatans->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('hrd.jabatan.destroy', $jabatans->id) }}" method="post" style="display: inline;" class="delete-form">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>

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
                title: 'Laporan Jabatan ',
                messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Jabatan ',
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