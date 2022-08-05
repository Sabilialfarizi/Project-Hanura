@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-4">
     
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>
<div class="card">
    <div class="card-header">
    Anggota Provinsi @php
        $name = \App\Provinsi::getProv($detail->id_prov);
        @endphp
        {{ $name->name ?? '-'}}
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
                            <th>Provinsi</th>
                            <th>Action</th>
                            
                           
                    </tr>
                </thead>
                <tbody>
                        @foreach($provinsi as $data)
                        <tr style="font-size:12px;">
                            <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                            <td>{{$data->no_member }}</td>
                            <td>{{$data->nickname }}</td>
                            <td>{{$data->no_hp  ??'-' }}</td>
                            <td>{{$data->nik  ??'-' }}</td>
                             <td>  @php
                                    $gender = \App\Gender::getGender($data->gender)
                                   
                                @endphp
                                {{ $gender->name  ??'-' }} </td>
                            <td>{{$data->birth_place  ??'-' }}</td>
                           <td>{{ Carbon\Carbon::parse($data->tgl_lahir)->Format('d-m-Y') }}
                                                </td>
                             <td>  @php
                                    $nama = \App\MaritalStatus::getNikah($data->status_kawin)
                                   
                                @endphp
                                {{ $nama->nama  ??'-' }} </td>
                             
                          
                            <td>{{$data->alamat  ??'-' }}</td>
                           <td>  @php
                                    $kec = \App\Provinsi::getProv($data->provinsi_domisili)
                                   
                                @endphp
                                {{ $kec->name  ??'-' }} </td>
                            <td>
                                
                          
                                  <div class="d-flex justify-content-center">  <a  data-toggle="tooltip" data-placement="top" title="Cetak KTA Anggota"href="/dpp/provinsi/cetak/{{$data->userid}}"  class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>
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
        dom: 'lBfrtip',
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
                title: 'Laporan Data Anggota ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-pdf',
                title: 'Laporan Data Anggota ',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });

</script>
@stop
