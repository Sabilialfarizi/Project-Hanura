@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-8">
      <h4 class="page-title"> Provinsi : <span style="font-weight:bold;">{{$provinsi->name}}</span> <br>Kabupaten / Kota :  <span style="font-weight:bold;">{{$kabupaten->name}}</span> <br> Kecamatan :  <span style="font-weight:bold;">{{$detail->name}}</span></h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a style="background-color:#D6A62C; color:#ffff; font-weight:bold;"  class="btn float-right" href="{{ "/dpp/kecamatan/$id_kec[0]/kelurahan/create" }}">
            <i class="fa fa-plus"></i> Add Kelurahan/Desa
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable report">
                <thead>
                <tr style="font-size:12px;">
                        <th width="10">
                            No.
                        </th>
                            <th>Kode</th>
                            <th>Kode KPU</th>
                            <th>Kelurahan / Desa</th>
                             <th>Tipe</th> 
                            <th>Total Anggota</th>
                            <!--<th>Total Pengurus</th>-->
                            <th>Action</th>
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($kelurahan as $data)
                        <tr style="font-size:12px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <td><a  style=" color:#D6A62C; font-weight:bold;" href="/dpp/provinsi/{{$data->id_kel}}/kelurahan/data" >{{$data->id_kel}}</a></td>
                            <td>{{$data->id_kpu == 0 ? 'Belum Mengisi ID KPU' : $data->id_kpu}}</td>
                            <td>
                                @php
                                    $name = \App\Kelurahan::getKel($data->id_kel)
                                @endphp
                                {{ $name->name ?? '' }}
                            </td>
                            <td>
                               {{$data->id_wilayah == 3 ? 'Desa' : 'Kelurahan'}}
                            </td>
                            <td>{{ \App\DetailUsers::where('detail_users.kelurahan_domisili', $data->id_kel)
                              ->where('detail_users.status_kta', 1)
                               ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                              ->groupBy('detail_users.nik')                        
                              ->get()
                              ->count() }}</td>
                            <!--<td>{{\App\Kepengurusan::where('id_daerah', $data->id_kel)->where('deleted_at',null)->get()->count() }}</td>-->
                            
                            <td>
                                <div class="d-flex">
                                    <a  data-toggle="tooltip" data-placement="top" title="Edit Kelurahan" href="{{ "/dpp/kecamatan/$id_kec[0]/kelurahan/$data->id_kel/edit" }} "class="btn btn-sm mr-2 btn-warning" style="height:30px;"><i class="fa-solid fa-edit"></i></a>
                                    <form method="post" action="{{ "/dpp/kecamatan/$id_kec[0]/kelurahan/$data->id_kel" }}">
                                        @csrf
                                        @method('delete')
                                        <button   data-toggle="tooltip" data-placement="top" title="Hapus Kelurahan" style="height:30px;" type="submit" class="btn btn-danger btn-sm btn-secondary"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                              </div>
                            </td>
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