@extends('layouts.master' )
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
        <h1 class="page-title">Master Jabatan</h1>
    </div>
    <div class="col-sm-8 text-right m-b-20">
        <a style="color:#FFFF; background-color:#D6A62C; font-weight:bold;" href="{{ route('dpp.jabatan.create') }}" class="btn  float-right"><i class="fa fa-plus"></i> Add Jabatan</a>
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
                             Kode
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.categories') }} -->
                            Nama
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.pict') }} -->
                            Status
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.status') }} -->
                            Tipe Daerah
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.created_by') }} -->
                            Tanggal Dibuat
                        </th>
                        <th>
                            <!-- {{ trans('cruds.information.fields.created_by') }} -->
                            Tanggal Diupdate
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jabatan as $key => $rows)
                        <tr data-entry-id="{{ $rows->id }}">
                            <td>
                                {{$loop->iteration}}

                            </td>
                            <td>
                                {{ $rows->kode ?? '-' }}
                            </td>
                            <td>
                                {{ $rows->nama ?? '-' }}
                            </td>
                            <td>
                                {{ $rows->status ?? '-' }}
                            </td>
                            <td>
                                {{ $rows->nama_tipe ?? '-' }}
                            </td>
                            <td>
                                {{ Carbon\carbon::parse($rows->created_at)->isoFormat('dddd, D-M-Y') ?? '' }}
                            </td>
                            <td>
                                @if($rows->updated_at == null)
                                <span>-</span>
                                @else
                                {{ Carbon\carbon::parse($rows->updated_at)->isoFormat('dddd, D-M-Y') }}    
                                @endif
                            </td>
                           
                           
                            <td>
                              
                                    <a  data-toggle="tooltip" data-placement="top" title="Perbaiki Jabatan" class="btn btn-sm"style="background-color:#D6A62C; color:#ffff; font-weight:bold;"  href="{{ route('dpp.jabatan.edit', $rows->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('dpp.jabatan.destroy', $rows->id) }}"
                                        class="delete-form"  style="display: inline-block;" method="post">
                                        @csrf
                                        @method('delete')
                                        <button data-toggle="tooltip" data-placement="top" title="Hapus Jabatan"type="submit" class="btn btn-sm btn-danger"><i
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
<style>
        .table.dataTable {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }

        .btn.btn-default {
            background-color: #D6A62C;
        }
       
    </style>
@stop
@section('footer')
<script>
    $('.report').DataTable({
        dom: 'Bfrtip',
        buttons: [{
                extend: 'copy',
                className: 'btn btn-default',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                className: 'btn btn-default',
                title: 'Laporan Jabatan ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-default',
                title: 'Laporan Jabatan ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });

</script>
@stop