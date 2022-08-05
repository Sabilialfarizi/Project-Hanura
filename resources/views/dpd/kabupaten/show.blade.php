@extends('layouts.master', ['title' => 'Show Kecamatan'])

@section('content')
<div class="row">
    <div class="col-md-6">
      <h4 class="page-title">Kabupaten / Kota :  @php
        $name = \App\Kabupaten::getKab($detail->id_kab);
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
                            <th>Kabupaten</th>
                            <th>Action</th>
                            
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($kabupaten as $data)
                        <tr style="font-size:12px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <td>{{$data->no_member }}</td>
                            <td>{{$data->nickname }}</td>
                            <td>{{$data->no_hp ?? '-' }}</td>
                            <td>{{$data->nik ?? '-' }}</td>
                             <td>  @php
                                    $gender = \App\Gender::getGender($data->gender)
                                   
                                @endphp
                                {{ $gender->name ?? '-' }} </td>
                            <td>{{$data->birth_place ?? '-' }}</td>
                           <td>{{ Carbon\Carbon::parse($data->tgl_lahir)->Format('d-m-Y') }}
                                                </td>
                             <td>  @php
                                    $nama = \App\MaritalStatus::getNikah($data->status_kawin)
                                   
                                @endphp
                                {{ $nama->nama  ?? '-' }} </td>
                             
                          
                            <td>{{$data->alamat ?? '-' }}</td>
                           <td>  @php
                                    $kec = \App\Kabupaten::getKab($data->kabupaten_domisili)
                                   
                                @endphp
                                {{ $kec->name ?? '-' }} </td>
                                  <td>
                                
                          
                                  <div class="d-flex justify-content-center">  <a href="/dpp/kabupaten/cetak/{{$data->userid}}" class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>
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
            },/*
            {
                extend: 'excel',
                className: 'btn-default',
                title: 'Laporan Kabupaten ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            }, */
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
