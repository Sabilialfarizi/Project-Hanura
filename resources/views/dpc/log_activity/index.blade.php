@extends('layouts.master', ['title' => 'Log Activity'])

@section('content')
<div class="row">
    <div class="col-md-4">
      <h4 class="page-title">Log Activity</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

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
                <tr style="font-size:14px;">
                        <th width="10">
                            No.
                        </th>
                            <th>User</th>
                            <th>Date</th>
                            <th>User Agent</th>
                            <th>Ip Address</th>
                            <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($loginActivities as $data)
                        <tr style="font-size:14px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <td>{{$data->user->name }}</td>
                            <td>{{ Carbon\Carbon::parse($data->created_at)->format("d/M/Y , H:i:s") }}</td>

                            <td>{{$data->user_agent }}</td>
                            <td>{{$data->ip_address }}</td>
                           
                           
                            <td>
                                <div class="btn-group">
                                    <form action="{{ route('dpp.log_activity.destroy', $data->id) }}"
                                        class="delete-form" method="post">
                                        @csrf
                                        @method('delete')
                                        <button data-toggle="tooltip" data-placement="top" title="Hapus Log Activity" type="submit" class="btn btn-sm btn-danger"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>
@stop
<style>
        .table.dataTable {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }

        .btn.btn-pdf {
            background-color: #D6A62C;
        }
       
    </style>
@section('footer')
<script>
    $('.report').DataTable({
        dom: 'Bfrtip',
        buttons: [{
                extend: 'copy',
                className: 'btn btn-pdf',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                     className: 'btn btn-pdf',
                title: 'Laporan Log Activity ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                     className: 'btn btn-pdf',
                title: 'Laporan Log Activity  ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });

</script>
@stop
