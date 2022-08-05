@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-4">
      <h4 class="page-title"> Provinsi : <span style="font-weight:bold;">{{$provinsi->name}}</span> <br>Kabupaten / Kota :  <span style="font-weight:bold;">{{$kabupaten->name}}</span> <br> Kecamatan :  <span style="font-weight:bold;">{{$detail->name}}</span></h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>

<div class="card">
    <div class="card-header">
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable report">
                <thead>
                <tr style="font-size:16px;">
                        <th width="10">
                            No.
                        </th>
                            <th>Kode</th>
                            <th>Kelurahan / Desa</th>
                            <!-- <th>Kecamatan</th> -->
                            <th>Total Anggota</th>
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($kelurahan as $data)
                        <tr style="font-size:16px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <!--<td><a  style=" color:#D6A62C; font-weight:bold;" href="/dpp/provinsi/{{$data->id_kel}}/kelurahan/data" >{{$data->id_kel}}</a></td>-->
                            <td>{{$data->id_kel}}</td>
                            <td>
                                @php
                                    $name = \App\Kelurahan::getKel($data->id_kel)
                                @endphp
                                {{ $name->name ?? '' }}
                            </td>
                            <td>{{ \App\DetailUsers::join('users','detail_users.userid','=','users.id')
                              ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                              ->where('detail_users.kelurahan_domisili', $data->id_kel)
                              ->where('detail_users.status_kta', 1)
                               ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                                ->groupBy('detail_users.nik')                    
                              ->get()
                              ->count() }}</td>
                            <!-- anggota per provinsi -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script>
    $('.report').DataTable({
        "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
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
                        title: 'Laporan Kecamatan',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-pdf',
                        title: 'Laporan Kecamatan ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-pdf',
                        title: 'Laporan Kecamatan ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ],
    });

</script>
@stop