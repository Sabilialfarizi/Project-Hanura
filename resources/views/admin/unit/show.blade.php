@extends('layouts.master', ['title' => 'Cabang'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Cabang {{ $cabang->nama }}</h4>
    </div>

    <x-alert></x-alert>
</div>

<div class="row">
    <div class="col-sm-4">
        <h4 class="page-title">List Harga Service</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        @can('cabang-create')
        <a href="/admin/price-service/{{ $cabang->id }}/create" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Harga Service</a>
        @endcan
    </div>

    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Service</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->product->kode_barang }}</td>
                        <td>{{ $service->product->nama_barang }}</td>
                        <td>@currency($service->harga)</td>
                        <td>{{ $service->product->durasi }}</td>
                        <td>
                            @can('product-edit')
                            <a href="/admin/price-service/{{ $service->id }}/edit" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('product-delete')
                            <form action="/admin/price/{{ $service->id }}/destroy" method="post" style="display: inline;" class="delete-form">
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

<div class="row mt-5">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">List Harga Produk</h4>
    </div>

    <div class="col-sm-8 col-9 text-right m-b-20">
        @can('cabang-create')
        <a href="/admin/price-product/{{ $cabang->id }}/create" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Harga Produk</a>
        @endcan
    </div>

    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->product->kode_barang }}</td>
                        <td>{{ $product->product->nama_barang }}</td>
                        <td>@currency($product->harga)</td>
                        <td>{{ $product->qty }}</td>
                        <td>
                            <a href="/admin/price-product/{{ $product->id }}/edit" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                            @can('product-delete')
                            <form action="/admin/price/{{ $product->id }}/destroy" method="post" style="display: inline;" class="delete-form">
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