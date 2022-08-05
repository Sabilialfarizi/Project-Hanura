@extends('layouts.master', ['title' => 'Show Kabupaten'])

@section('content')
<div class="row">
    <div class="col-md-4">
      <h4 class="page-title">Provinsi  {{$kabupaten->name}}</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>
<!--<div style="margin-bottom: 10px;" class="row">-->
<!--    <div class="col-lg-12">-->
<!--        <a  style="background-color:#D6A62C; color:#ffff; font-weight:bold;"   class="btn float-right" href="{{ '/dpp/kabupaten/create' }}">-->
<!--            <i class="fa fa-plus"></i> Add Kabupaten/Kota-->
<!--        </a>-->
<!--    </div>-->
<!--</div>-->
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
                            <th>Kabupaten / Kota</th>
                            <th>Total Kecamatan</th>
                            <th>Total Anggota</th>
                            <!--<th>Action</th>-->
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($provinsi as $data)
                        @php
                           $anggota = DB::table('detail_users')->where('kabupaten_domisili', $data->id_kab)
                                ->where('status_kta',1)
                                ->where(DB::raw('LENGTH(no_member)'),'>',[18,20])
                                ->groupBy('detail_users.nik')
                                ->get();
                        @endphp
                        <tr style="font-size:16px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <!--<td><a style="color:#D6A62C; font-weight:bold;" href="/dpp/provinsi/{{$data->id_kab}}/data" >{{$data->id_kab}}</a></td>-->
                            <td>{{$data->id_kab}}</td>
                            <td> @php
                                    $name = \App\Kabupaten::getKab($data->id_kab)
                                    
                          
                                @endphp
                                {{ $name->name ?? '' }}</td>
                            <td><a style="color:#D6A62C; font-weight:bold;" href="/dpc/provinsi/{{$data->id_kab}}/kecamatan" >{{ 
                           \App\Kecamatan::where('id_kab', $data->id_kab)->groupBy('id')->get()->count()}}</a></td>
                            
                           <td>
                        
                            {{$anggota->count()}}
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
<style>
        .table.dataTable {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }

        .btn.btn-pdf {
            background-color: #D6A62C;
        }
       
    </style>
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
                        title: 'Laporan Provinsi',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-pdf',
                        title: 'Laporan Provinsi ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-pdf',
                        title: 'Laporan Provinsi ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    // {
                    //   text: 'Lampiran 1 Model F2 Parpol',
                    //   action: function ( e, dt, button, config ) {
                    //         window.location = '/dpp/provinsi/lampiran_parpol/{{ $kabupaten->id_prov }}';
                      
                    //   }        
                    //  },
                    //  {
                    //   text: 'Lampiran 1 Model F2.HP-Parpol',
                    //   action: function ( e, dt, button, config ) {
                    //         window.location = '/dpp/provinsi/lampiran_hp_parpol/{{ $kabupaten->id_prov }}';
                      
                    //   }        
                    //  },
                ],
    });

</script>
@stop
