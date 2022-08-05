@extends('layouts.master', ['title' => 'Export KTA KTP'])
@section('content')
<div class="row">
<div class="col-md-4">
        <h1 class="page-title">Export KTA KTP</h1>
    </div>
</div>

<x-alert></x-alert>
<div class="card">
    <div class="card-header">
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="10">
                            No.
                        </th>
                        <th style="text-align:center;">
                             Kecamatan
                        </th>
                        <th style="text-align:center;">
                            Status
                        </th>
                        <th style="text-align:center;">
                            Message
                        </th>
                        <th style="text-align:center;">
                            Created At
                        </th>
                        <th style="text-align:center;">
                            Finished At
                        </th>
                        <th style="text-align:center;">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = $start = ($data->currentPage() - 1) * $data->perPage() + 1;?>
                    @foreach($data as $key => $rows)
                        <tr data-entry-id="{{ $rows->id }}">
                            <td style="text-align:center;">
                                {{$i++}}
                            </td>
                            <td style="text-align:center;">
                                {{$rows->Districts->name}}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center mt-2">
                                    @if($rows->status == 1)
                                        <span class="custom-badge status-blue">Pending</span>
                                    @elseif($rows->status == 2)
                                        <span class="custom-badge badge-warning">Process</span>
                                    @elseif($rows->status == 3)
                                        <span class="custom-badge status-green">Success</span>
                                    @elseif($rows->status == 4)
                                        <span class="custom-badge status-red">Error</span>
                                    @endif
                                 </div>
                             </td>
                            <td>
                                {{\Illuminate\Support\Str::limit($rows->message, 300)}}
                            </td>
                            <td style="text-align:center;">
                                {{$rows->created_at}}
                            </td>
                            <td style="text-align:center;">
                                {{$rows->finished_at}}
                            </td>
                            <td style="text-align:center;">
                                @if($rows->status == 3)
                                    <a href="{{ route('dpc.exports.download', $rows->id) }}" title="Export KTA KTP"class="btn btn-sm"style="background-color:#D6A62C; color:#ffff; font-weight:bold;" >
                                        <i class="fa fa-download"></i>
                                    </a>
                                @endif


                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($data->count() > 0)
            <p>Showing {{$data}} to {{$i-1}} of {{$data->total()}} entries</p>
        @endif
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
                title: 'Laporan Informasi ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-default',
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
