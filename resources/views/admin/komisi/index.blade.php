@extends('layouts.master', ['title' => 'Komisi'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Komisi</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        @can('komisi-create')
        <a href="{{ route('admin.komisi.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Komisi</a>
        @endcan
    </div>
</div>

<x-alert></x-alert>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                        <th>Persentase</th>
                        <th>Min Transaksi</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($komisi as $kms)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kms->role->key }}</td>
                        <td>{{ $kms->persentase }}</td>
                        <td>@currency($kms->min_transaksi)</td>
                        <td>
                            @can('komisi-edit')
                            <a href="{{ route('admin.komisi.edit', $kms->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('komisi-delete')
                            <form action="{{ route('admin.komisi.destroy', $kms->id) }}" method="post" style="display: inline;" class="delete-form">
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