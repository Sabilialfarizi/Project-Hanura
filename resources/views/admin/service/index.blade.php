@extends('layouts.master', ['title' => 'Service'])

@section('content')
<div class="row">
    <div class="col-sm-4">
        <h1 class="page-title">Service</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        @can('service-create')
        <a href="{{ route('admin.service.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Service</a>
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
                        <th>Kode Service</th>
                        <th>Nama</th>
                        <th>Description</th>
                        <th>Durasi</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->kode_barang }}</td>
                        <td>{{ $service->nama_barang }}</td>
                        <td>{{ $service->description }}</td>
                        <td>{{ $service->durasi }}</td>
                        <td>{{ $service->type }}</td>
                        <td>
                            @can('service-edit')
                            <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('service-delete')
                            <form action="{{ route('admin.service.destroy', $service->id) }}" method="post" style="display: inline;" class="delete-form">
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