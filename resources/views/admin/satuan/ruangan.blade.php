@extends('layouts.master', ['title' => 'Ruangan'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Ruangan Cabang {{ $cabang->nama }}</h4>
    </div>

    <div class="col-sm-8 col-9 text-right m-b-20">
        @can('cabang-create')
        <a href="/admin/ruangan/{{$cabang->id}}/create" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Ruangan</a>
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
                        <th>Nama Ruangan</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($ruangan as $ruang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ruang->nama_ruangan }}</td>
                        <td>
                            <a href="{{ route('admin.ruangan.edit', $ruang->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                            <form action="{{ route('admin.ruangan.destroy', $ruang->id) }}" method="post" style="display: inline;" class="delete-form">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop