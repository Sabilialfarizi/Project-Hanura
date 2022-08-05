@extends('layouts.master', ['title' => 'Kategori Barang'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Master Kategori Barang</h4>
    </div>
    <div class="col-sm-8 text-right m-b-20">
        @can('product-create')
        <a href="{{ route('admin.kategori.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Kategori Barang</a>
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
                        <th>Nama Kategori</th>
                        <th>is_active</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($kategoris as $kategori)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                        <td>{{ $kategori->is_active }}</td>
                        <td>{{ $kategori->kategori->count()}}</td>
                        <td>
                            @can('product-edit')
                            <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('product-delete')
                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="post" style="display: inline;" class="delete-form">
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