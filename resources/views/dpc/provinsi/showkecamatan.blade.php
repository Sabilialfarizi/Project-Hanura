@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6">
      <h4 class="page-title">
       
          Provinsi :  <span style="font-weight:bold;">{{$provinsi->name}}</span> <br>Kabupaten / Kota :  <span style="font-weight:bold;">{{$detail->name}}</span></h4>
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
                            <th>Kecamatan</th>
                            <th>Total Kelurahan / Desa</th>
                            <th>Total Anggota</th>
                            <!--<th>Action</th>-->
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($kecamatan as $data)
                        <tr style="font-size:16px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <!--<td><a style="color:#D6A62C; font-weight:bold;" href="/dpp/provinsi/{{$data->id_kec}}/kecamatan/data" >{{$data->id_kec}}</a></td>-->
                            <td>{{$data->id_kec}}</td>
                            <td> @php
                                    $name = \App\Kecamatan::getKec($data->id_kec)
                                @endphp
                                {{ $name->name ?? '' }}</td>
                            <td>
                                <a style="color:#D6A62C; font-weight:bold;" href="/dpc/provinsi/{{$data->id_kec}}/kelurahan" >{{ \App\Kelurahan::where('id_kec', $data->id_kec)->groupBy('id')->get()->count() }}</a></td>
                            <td>
                             @php
                            $anggota = \App\DetailUsers::join('users','detail_users.userid','=','users.id')
                                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                              ->where('detail_users.kecamatan_domisili', $data->id_kec)
                              ->where('detail_users.status_kta', 1)
                               ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                                 ->groupBy('detail_users.nik')                       
                              ->get()
                              ->count();
                            @endphp
                            {{$anggota}} 
                             </td>
                            
                <!--              <td><div class="d-flex justify-content-center">-->
                <!--     <a href="/dpp/kecamatan/{{$data->id_kec}}/kantor" class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-building"></i></a>-->
                <!--    <a href="/dpp/kecamatan/{{$data->id_kec}}/kepengurusan"class="btn btn-sm btn-secondary"><i class="fa-solid fa-person"></i></a>-->
                    
                         
                   
                    
                <!--</div></td>-->
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
