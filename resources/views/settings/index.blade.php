@extends('layouts.master', ['title' => 'Informasi'])
@section('content')
<!-- @can('customer_create') -->
    <!-- <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary float-right" href="{{ route("dpp.informasi.create") }}">
                <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.information.title_singular') }}
            </a>
        </div>
    </div> -->
<!-- @endcan -->
<div class="row">
<div class="col-md-4">
        <h1 class="page-title">Informasi</h1>
    </div>
    <div class="col-sm-8 text-right m-b-20">
        <a href="{{ route('dpp.informasi.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Informasi</a>
    </div>
</div>

<x-alert></x-alert>
<div class="card">
    <div class="card-header">
        <!-- {{ trans('cruds.information.title_singular') }} {{ trans('global.list') }} -->
    <!-- Informasi -->
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="report table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">
                            No.
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.nama') }} -->
                             Nama
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.categories') }} -->
                            Kategori
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.pict') }} -->
                            Gambar
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.status') }} -->
                            status
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.created_by') }} -->
                            Pembuat
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.updated_by') }} -->
                            Di Update Oleh
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($info as $key => $rows)
                        <tr data-entry-id="{{ $rows->id }}">
                            <td>
                                {{$loop->iteration}}

                            </td>
                            <td>
                                {{ $rows->name ?? '' }}
                            </td>
                            <td>
                                @php
                                    $name = \App\ArticleCategory::getCategory($rows->kategori_id)
                                @endphp
                                {{ $name->name ?? '' }}
                            </td>
                            <td>
                                <img width=100 src="{{ asset('images/'.($rows->gambar)) }}">
                            </td>
                            <td>
                                <div class="d-flex justify-content-center mt-2">
                                     @if($rows->is_active == 0)
                                    <span class="custom-badge status-red">inactive</span>
                                    @endif
                                    @if($rows->is_active == 1)
                                    <span class="custom-badge status-green">active</span>
                                    @endif
                                
                                 </div>
                             </td>
                            <!-- <td>
                                @if($rows->is_active == 1)
                                    {{ trans('cruds.member.fields.active') }}
                                @elseif($rows->is_active == 0)
                                    {{ trans('cruds.member.fields.inactive') }}
                                @endif
                            </td> -->
                            <td>
                                @php
                                    $name = \App\User::getName($rows->created_by);
                                @endphp
                                {{ $name->name ?? '' }}
                            </td>
                            <td>
                                @php
                                    $name = \App\User::getName($rows->updated_by);
                                @endphp
                                {{ $name->name ?? '' }}
                            </td>
                            <td>
                              
                                    <a class="btn btn-xs btn-info" href="{{ route('dpp.informasi.edit', $rows->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('dpp.informasi.destroy', $rows->id) }}"
                                        class="delete-form"  style="display: inline-block;" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-xs btn-danger"><i
                                                class="fa fa-trash"></i></button>
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
                title: 'Laporan Informasi ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Informasi ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });

</script>
@stop