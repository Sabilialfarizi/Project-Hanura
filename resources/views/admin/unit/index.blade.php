@extends('layouts.master', ['title' => 'Unit Rumah'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Master Unit Rumah</h4>
    </div>
    <div class="col-sm-8 text-right m-b-20">
        @can('product-create')
        <a href="{{ route('admin.unit.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Unit</a>
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
                        <th>Type</th>
                        <th>Blok</th>
                        <th>No</th>
                        <th>Lb</th>
                        <th>Lt</th>
                        <th>nstd</th>
                        <th>Total</th>
                        <th>Hagra Jual</th>
                        <th>Status Jual</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($units as $unit)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $unit->type }}</td>
                        <td>{{ $unit->blok }}</td>
                        <td>{{ $unit->no }}</td>
                        <td>{{ $unit->lb }}</td>
                        <td>{{ $unit->lt }}</td>
                        <td>{{ $unit->nstd }}</td>
                        <td>{{ $unit->total }}</td>
                        <td>{{ $unit->harga_jual }}</td>
                        <td>{{ $unit->status_penjualan }}</td>
                        <td>
                        
                            <a href="{{ route('admin.unit.edit', $unit->id_unit_rumah) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                   
                            @can('product-delete')
                            <form action="{{ route('admin.unit.destroy', $unit->id_unit_rumah) }}" method="post" style="display: inline;" class="delete-form">
                                @method('DELETE')
                                @csrf
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
                title: 'Laporan Pembelian ',
                messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Pembelian ',
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