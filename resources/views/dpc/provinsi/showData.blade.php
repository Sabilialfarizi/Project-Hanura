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
    Anggota Kabupaten : @php
        $name = \App\Kabupaten::getKab($detail->id_kab);
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
                            <td>{{$data->nik ??'-'}}</td>
                             <td>  @php
                                    $gender = \App\Gender::getGender($data->gender)
                                   
                                @endphp
                                {{ $gender->name  ??'-'}} </td>
                            <td>{{$data->birth_place  ??'-'}}</td>
                           <td>{{ Carbon\Carbon::parse($data->tgl_lahir)->isoFormat('D-M-Y') }}
                                                </td>
                             <td>  @php
                                    $nama = \App\MaritalStatus::getNikah($data->status_kawin)
                                   
                                @endphp
                                {{ $nama->nama  ??'-' }} </td>
                             
                          
                            <td>{{$data->alamat  ??'-' }}</td>
                           <td>  @php
                                    $kec = \App\Kabupaten::getKab($data->kabupaten_domisili)
                                   
                                @endphp
                                {{ $kec->name  ??'-' }} </td>
                            <td>   
                            <div class="d-flex justify-content-center">  <a href="/dpc/member/{{$data->id}}/cetak"  class="btn btn-sm btn-secondary"><i class="fa-solid fa-print"></i></a>
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
<style>
        .table.dataTable {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }

        .btn.btn-pdf {
            background-color: #D6A62C;
        }
       
    </style>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    

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
                        title: 'Laporan Kabupaten',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-pdf',
                        title: 'Laporan Kabupaten ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-pdf',
                        title: 'Laporan Kabupaten ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                     {
                      text: 'Lampiran 2 Model F2 Parpol',
                      action: function ( e, dt, button, config ) {
                            window.location = '/dpp/provinsi/export_parpol/{{ $detail->id_kab }}';
                      
                      }        
                     },
                     {
                      text: 'Lampiran 2 Model F2.HP-Parpol',
                      action: function ( e, dt, button, config ) {
                            window.location = '/dpp/provinsi/export_hp_parpol/{{ $detail->id_kab }}';
                      
                      }        
                     },
                ],
    });

</script>
@stop
