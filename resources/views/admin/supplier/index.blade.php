@extends('layouts.master', ['title' => 'Supplier'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Supplier</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        @can('supplier-create')
        <a href="{{ route('admin.supplier.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Supplier</a>
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
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telpon</th>
                        <th>Alamat</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $supplier->nama }}</td>
                        <td>{{ $supplier->telpon }}</td>
                        <td>{{ $supplier->alamat }}</td>
                        <td>
                            @can('supplier-edit')
                            <a href="{{ route('admin.supplier.edit', $supplier->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('supplier-delete')
                            <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="post" style="display: inline;" class="delete-form">
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