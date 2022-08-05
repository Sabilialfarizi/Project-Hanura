@extends('layouts.master', ['title' => 'Show Kabupaten'])

@section('content')
<div class="row">
    <div class="col-md-4">
      <h4 class="page-title">Provinsi {{$kabupaten->name}}</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable report">
                <thead>
                <tr style="font-size:16px;">
                        <th width="10">
                            No.
                        </th>
                            <th>Kode</th>
                            <th>Kabupaten</th>
                            <th>Total Anggota</th>
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($provinsi as $data)
                        <tr style="font-size:16px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <td>{{$data->id_kab }}</td>
                            <td> @php
                                    $name = \App\Kabupaten::getKab($data->id_kab)
                                @endphp
                                {{ $name->name ?? '' }}</td>
                            <td>{{ \App\DetailUsers::where('kabupaten_domisili', $data->id_kab)->count() }}</td>
                            <!-- anggota per provinsi -->
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
                title: 'Laporan Kabupaten ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Kabupaten ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });

</script>
@stop
