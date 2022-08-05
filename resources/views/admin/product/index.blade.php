@extends('layouts.master', ['title' => 'Produk'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Barang</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        @can('cabang-create')
        <a href="{{ route('admin.product.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Produk</a>
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
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                       
                        <td>{{ $product->kode_barang }}</td>    
                        <td>{{ $product->nama_barang }}</td>    
                        <td>{{ $product->nama_kategori }}</td>
                        <td>
                            @can('product-edit')
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('product-delete')
                            <form action="{{ route('admin.product.destroy', $product->id) }}" method="post" style="display: inline;" class="delete-form">
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
