@extends('layouts.master', ['title' => 'Master User'])

@section('content')
<div class="row">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Team Sales</h4>
    </div>
    <div class="col-sm-8 col-9 text-right m-b-20">
        <a href="{{ route('hrd.sales.create') }}" class="btn btn btn-primary btn-rounded float-right"><i
                class="fa fa-plus"></i> Add Team Sales</a>

    </div>
</div>
<x-alert></x-alert>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table custom-table table-striped report" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Manager</th>
                        <th>Supervisor</th>
                        <th>Sales</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>
                  
                    @foreach($sales as $man)
                    <tr>
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <th>{{ $man->manager->name  }}</th>
                        <th>{{ $man->spv->name  }}</th>
                        
                        @foreach($sale as $sal)
                        <th>
                            @foreach($sal->sales as $pur)
                            <span class="custom-badge status-blue">{{ $pur->user->name }}</span>
                            @endforeach
                        </th>
                        @endforeach
                        <th>
                            <a href="{{ route('hrd.sales.edit', $man->user_id) }}" class="btn btn-sm btn-info"><i
                                    class="fa fa-edit"></i></a>
                            <a href="{{ route('hrd.sales.hapus', $man->user_id) }}" class=" btn btn-sm btn-danger"><i
                                    class="fa fa-trash"></i></a>
                        </th>
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
                title: 'Laporan Team Sales ',
                messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Team Sales ',
                messageTop: 'Tanggal {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });

</script>
@stop
