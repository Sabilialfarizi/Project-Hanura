@extends('layouts.master', ['title' => 'Warehouse'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Master Warehouse</h4>
    </div>
    <div class="col-sm-8 text-right m-b-20">
        @can('product-create')
        <a href="{{ route('admin.warehouse.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Kategori Barang</a>
        @endcan
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
                        <th>Nama Warehouse</th>
                        <th>Alamat</th>
                        <th>Perusahaan</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($warehouses as $warehouse)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $warehouse->nama_warehouse }}</td>
                        <td>{{ $warehouse->alamat }}</td>
                        <td>{{ $warehouse->perusahaan->nama_perusahaan}}</td>
                        <td>
                            @can('product-edit')
                            <a href="{{ route('admin.warehouse.edit', $warehouse->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('product-delete')
                            <form action="{{ route('admin.warehouse.destroy', $warehouse->id) }}" method="post" style="display: inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></button>
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
                title: 'Laporan Warehouse ',
                messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Warehouse ',
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