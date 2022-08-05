@extends('layouts.master', ['title' => 'Show Kecamatan'])

@section('content')
<div class="row">
    <div class="col-md-4">
      <h4 class="page-title">Kecamatan : {{$kelurahan->name}}</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>

<!--<div style="margin-bottom: 10px;" class="row">-->
<!--    <div class="col-lg-12">-->
<!--        <a style="background-color:#D6A62C; color:#ffff; font-weight:bold;"  class="btn float-right" href="{{ "/dpp/kecamatan/$id_kec[0]/kelurahan/create" }}">-->
<!--            <i class="fa fa-plus"></i> Add Kelurahan/Desa-->
<!--        </a>-->
<!--    </div>-->
<!--</div>-->

<div class="card">
    <div class="card-header">
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable report">
                <thead>
                <tr style="font-size:13px;">
                        <th width="10">
                            No.
                        </th>
                            <th>Kode</th>
                            <th>Kelurahan / Desa</th>
                            <!-- <th>Kecamatan</th> -->
                            <th>Total Anggota</th>
                            <!--<th>Action</th>-->
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($kecamatan as $data)
                        <tr style="font-size:13px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <td>{{$data->id_kel}}</td>
                            <td>
                                @php
                                    $name = \App\Kelurahan::getKel($data->id_kel)
                                @endphp
                                {{ $name->name ?? '' }}
                            </td>
                            <!-- <td>
                                @php
                                    $kec = \App\Kecamatan::getKec($data->kecamatan_domisili)
                                @endphp
                                {{ $kec->name ?? '' }}
                            </td> -->
                            <td><a  style=" color:#D6A62C; font-weight:bold;" href="/dpp/kecamatan/{{$data->id_kel}}/showKelurahan" >{{ \App\DetailUsers::where('kelurahan_domisili', $data->id_kel)->where('status_kta', 1)->count() }}</a></td>
                            <!--<td>-->
                            <!--    <div class="d-flex">-->
                            <!--        <a  data-toggle="tooltip" data-placement="top" title="Edit Kelurahan" href="{{ "/dpp/kecamatan/$id_kec[0]/kelurahan/$data->id_kel/edit" }} "class="btn btn-sm mr-2 btn-warning" style="height:30px;"><i class="fa-solid fa-edit"></i></a>-->
                            <!--        <form method="post" action="{{ "/dpp/kecamatan/$id_kec[0]/kelurahan/$data->id_kel" }}">-->
                            <!--            @csrf-->
                            <!--            @method('delete')-->
                            <!--            <button   data-toggle="tooltip" data-placement="top" title="Hapus Kelurahan" style="height:30px;" type="submit" class="btn btn-danger btn-sm btn-secondary"><i class="fa-solid fa-trash"></i></button>-->
                            <!--        </form>-->
                            <!--  </div>-->
                            <!--</td>-->
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

        .btn.btn-default {
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
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-default',
                        title: 'Laporan Kecamatan',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-default',
                        title: 'Laporan Kecamatan ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-default',
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