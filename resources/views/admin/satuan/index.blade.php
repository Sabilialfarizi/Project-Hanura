@extends('layouts.master', ['title' => 'Satuan Barang'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Master Satuan Barang</h4>
    </div>
    <div class="col-sm-8 text-right m-b-20">
        @can('product-create')
        <a href="{{ route('admin.satuan.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Satuan Barang</a>
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
                        <th class="text-center" style="width:10px; ">No</th>
                        <th  class="text-center" style="width:200px; ">Nama</th>
                        {{-- <th>Total Item</th> --}}
                        <th style="width: 50px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($satuan as $satuans)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $satuans->nama }}</td>
                        {{-- <td>{{ $unit->kategori->count()}}</td> --}}
                        <td>
                            @can('product-edit')
                            <a href="{{ route('admin.satuan.edit', $satuans->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('product-delete')
                            <form action="{{ route('admin.satuan.destroy', $satuans->id) }}" method="post" style="display: inline;" class="delete-form">
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
                title: 'Laporan Satuan Barang',
                messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Satuan Barang ',
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