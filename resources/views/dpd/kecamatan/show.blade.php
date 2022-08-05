@extends('layouts.master', ['title' => 'Show Kecamatan'])

@section('content')
<div class="row">
    <div class="col-md-4">
      <h4 class="page-title">Kecamatan  @php
        $name = \App\Kecamatan::getKec($detail->id_kec);
        @endphp
        <a style="font-weight:bold;">{{ $name->name ?? '-'}}</a></h4>
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
            <table class=" report table table-bordered table-striped table-hover datatable">
                <thead>
                <tr style="font-size:12px;">
                    <th>No.</th>
                        <th width="10">
                            No.KTA
                        </th>
                            <th>Nama</th>
                            <th>No. Telp</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Status Perkawinan</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Action</th>
                            
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($kecamatan as $data)
                        <tr style="font-size:12px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <td>{{$data->no_member }}</td>
                            <td>{{$data->nickname }}</td>
                            <td>{{$data->no_hp ?? '-' }}</td>
                            <td>{{$data->nik ?? '-' }}</td>
                             <td>  @php
                                    $gender = \App\Gender::getGender($data->gender)
                                   
                                @endphp
                                {{ $gender->name }} </td>
                            <td>{{$data->birth_place ?? '-' }}</td>
                           <td>{{ Carbon\Carbon::parse($data->tgl_lahir)->Format('d-m-Y') }}
                                                </td>
                             <td>  @php
                                    $nama = \App\MaritalStatus::getNikah($data->status_kawin)
                                   
                                @endphp
                                {{ $nama->nama ?? '-' }} </td>
                             
                          
                            <td>{{$data->alamat ?? '-' }}</td>
                           <td>  @php
                                    $kec = \App\Kecamatan::getKec($data->kecamatan_domisili)
                                   
                                @endphp
                                {{ $kec->name ?? '-' }} </td>
                                  <td>
                                
                              <div class="d-flex flex-row">
                                  <div class="d-flex justify-content-center mr-3">  <a href="/dpp/kecamatan/cetak/{{$data->userid}}"   class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>
                                    </div>
                                    
                                  <div class="d-flex justify-content-center">  <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota"href="/dpp/kecamatan/cetaks/{{$data->userid}}"  class="btn btn-sm btn-secondary"><i class="fa-solid fa-users"></i></a>
                                    </div>
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

        .btn.btn-default {
            background-color: #D6A62C;
        }
       
    </style>
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
            }, /*
            {
                extend: 'excel',
                className: 'btn btn-default',
                title: 'Laporan Kecamatan ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            }, */
            {
                extend: 'pdf',
                className: 'btn btn-default',
                title: 'Laporan Kecamatan ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });

</script>
@stop
