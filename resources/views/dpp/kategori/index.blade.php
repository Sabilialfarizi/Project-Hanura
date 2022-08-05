@extends('layouts.master')
@section('content')

<div class="row">
<div class="col-md-4">
        <h1 class="page-title">Kategori Informasi</h1>
    </div>
    <div class="col-sm-8 text-right m-b-20">
        <a style="color:#FFFF; background-color:#D6A62C; font-weight:bold;" href="{{ route('dpp.kategori.create') }}" class="btn float-right"><i class="fa fa-plus"></i> Add Informasi</a>
    </div>
</div>

<x-alert></x-alert>
<div class="card">
    <div class="card-header">
        <!-- {{ trans('cruds.category.title_singular') }} {{ trans('global.list') }} -->
    </div>

    <div class="card-body">
        <div class="table-responsive">
              <table class="report table table-bordered table-striped table-hover datatable report">
                <thead>
                    <tr>
                        <th width="10">
                            No.

                        </th>
                        <th>
                            <!-- {{ trans('cruds.category.fields.nama') }} -->
                             nama
                        </th>
                        <th style="text-align:center;">
                            <!-- {{ trans('cruds.category.fields.status') }} -->
                        status
                        </th>
                        <th>
                            <!-- {{ trans('cruds.category.fields.created_by') }} -->
                        Created By
                        </th>
                        <th>
                            <!-- {{ trans('cruds.category.fields.updated_by') }} -->
                        Updated By
                        </th>
                        <th>
                           Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category as $key => $rows)
                        <tr data-entry-id="{{ $rows->id }}">
                            <td>
                                {{$loop->iteration}}

                            </td>
                            <td>
                                {{ $rows->name ?? '' }}
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
                              
                              <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kategori" class="btn btn-sm"style="background-color:#D6A62C; color:#ffff; font-weight:bold;"  href="{{ route('dpp.kategori.edit', $rows->id) }}">
                                  <i class="fa fa-edit"></i>
                              </a>
                              
                              <form action="{{ route('dpp.kategori.destroy', $rows->id) }}"
                                  class="delete-form"  style="display: inline-block;" method="post">
                                  @csrf
                                  @method('delete')
                                  <button data-toggle="tooltip" data-placement="top" title="Hapus Kategori" type="submit" class="btn btn-xs btn-danger"><i
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
                title: 'Laporan Kategori Informasi ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-default',
                title: 'Laporan Kategori Informasi ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });

</script>
@stop
