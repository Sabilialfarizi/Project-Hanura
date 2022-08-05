@extends('layouts.master', ['title' => 'Status'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Status</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        @can('status-create')
        <a href="{{ route('admin.status.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Status</a>
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
                        <th>Status</th>
                        <th>Warna</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($status as $stt)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stt->status }}</td>
                        <td>{{ $stt->warna }}</td>
                        <td>
                            @can('status-edit')
                            <a href="{{ route('admin.status.edit', $stt->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('status-delete')
                            <form action="{{ route('admin.status.destroy', $stt->id) }}" method="post" style="display: inline;" class="delete-form">
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