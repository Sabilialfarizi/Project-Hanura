@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-4">
        <h4 class="page-title">Kantor PAC Kecamatan {{ $daerah->name }}</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>
<style>
    .click-zoom input[type=checkbox] {
        display: none
    }

    .click-zoom img {
        transition: transform 0.25s ease;
        cursor: zoom-in
    }

    .click-zoom input[type=checkbox]:checked~img {
        transform: scale(3);
        cursor: zoom-out
    }

</style>
<x-alert></x-alert>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('cruds.information.title_singular') }} {{ trans('global.list') }} -->
                <!-- Informasi -->
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="report table table-bordered table-striped table-hover" id="provinsi" width="100%">
                        <thead>
                            <tr style="font-size:16px;">
                                <th width="10">
                                    No.
                                </th>
                                <th>Alamat</th>
                                <th>Provinsi</th>
                                <th>Kab/Kota</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>RT/RW</th>
                                <th>Kode Pos</th>
                            
                                <th>WhatsApp Kantor</th>
                                <th>No. Telp</th>
                                <th>Fax</th>
                                <th>Email</th>
                                <!--<th>Koordinat</th>-->
                                <th>Tanggal Pengesahan SK</th>
                                <th>SK. Kepengurusan</th>
                                <th>Domisili</th>
                                <th>Cap Kantor</th>
                                <th>Status Kantor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($kantor !== null)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $kantor->alamat  ?? '-' }}</td>
                                    <td>{{ $kantor->getProvinsi->name  ?? '-' }}</td>
                                    <td>{{ $kantor->kabupaten->name  ?? '-' }}</td>
                                    <td>{{ $kantor->kecamatan->name  ?? '-' }}</td>
                                    <td>{{ $kantor->kelurahan->name  ?? '-' }}</td>
                                    <td>{{ $kantor->rt_rw ?? '-' }}</td>
                         
                                    <td>{{ $kantor->kode_pos ?? '-' }}</td>
                                    <td>{{ $kantor->wa_kantor ?? '-' }}</td>
                                    <td>{{ $kantor->no_telp ?? '-'}}</td>
                                    <td>{{ $kantor->fax ?? '-'}}</td>
                                    <td>{{ $kantor->email ?? '-' }}</td>
                                     <td>
                                    @if($kantor->tanggal_pengesahan_sk == null)
                                    <a>-</a>
                                    @else
                                     {{ Carbon\carbon::parse($kantor->tanggal_pengesahan_sk)->Format('d-m-Y') }}
                                     @endif
                                    </td>
                                    <td> 
                                    @if(!empty($kantor->no_sk))
                                     <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;" href="{{asset('/uploads/file/no_sk/'.$kantor->no_sk)}}"
                                     >Download SK. Kepengurusan</a>
                                     @else
                                       <a style="font-size:12px;">Belum Upload SK. Kepengurusan</a>
                                     @endif
                                     </td>
                                    <td>  
                                    @if(!empty($kantor->domisili))
                                     <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;" href="{{asset('/uploads/file/domisili/'.$kantor->domisili)}}" 
                                     >Download Domisili</a>
                                     @else
                                       <a style="font-size:12x;">Belum Upload Domisili</a>
                                     @endif
                                     </td>
                                     <td>
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="{{ asset('uploads/img/cap_kantor/'.($kantor->cap_kantor)) }}"
                                                alt='noimage' width='50px' height='30px'>
                                        </label>
                                    </div>

                                </td>
                                     <td>
                                       @if($kantor->status_kantor == 1)
                                       <a>Milik Sendiri</a>
                                       @elseif($kantor->status_kantor == 2)
                                        <a>Sewa, Hingga {{ Carbon\carbon::parse($kantor->tgl_selesai)->Format('d-m-Y') ?? '' }}</a>
                                        @else
                                         <a>Pinjam Pakai, Hingga {{ Carbon\carbon::parse($kantor->tgl_selesai)->Format('d-m-Y') ?? '' }}</a>
                                        @endif
                                   
                                    </td>
                                    <td>
                                        <a  style="background-color:#D6A62C; color:#FFFF;"   href="{{ "/dpp/kecamatan/$daerah->id_kec/kantor/$kantor->id_kantor/edit" }}" class="btn btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="17" class="text-center">Belum Ada Data</td>
                                    <td>
                                        <a  style="background-color:#D6A62C; color:#FFFF;" href="{{ route('dpp.kantor.create', $daerah->id_kec) }}" class="btn btn-sm">Tambah</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script>
    // $(document).ready(function () {
    //     $('.input-daterange').datepicker({
    //         todayBtn: 'linked',
    //         format: 'yyyy-mm-dd',
    //         autoclose: true
    //     });
    //     $.noConflict();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $('#provinsi thead tr')
    //         .clone(true)
    //         .addClass('filters')
    //         .appendTo('#provinsi thead');
    //     load_data();


    //     function load_data(from = '', to = '') {
    //         var from = $('#from').val();
    //         var to = $('#to').val();

    //         var table = $('#provinsi').DataTable({
    //             processing: true,
    //             serverSide: true,
    //             orderCellsTop: true,
    //             fixedHeader: true,
    //             "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
    //                 "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    //             buttons: [{
    //                     extend: 'copy',
    //                     className: 'btn-default',
    //                     exportOptions: {
    //                         columns: ':visible'
    //                     }
    //                 },
    //                 {
    //                     extend: 'excel',
    //                     className: 'btn-default',
    //                     title: 'Laporan provinsi',
    //                     messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
    //                     footer: true,
    //                     exportOptions: {
    //                         columns: ':visible'
    //                     }
    //                 },
    //                 {
    //                     extend: 'pdf',
    //                     className: 'btn-default',
    //                     title: 'Laporan provinsi ',
    //                     messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
    //                     footer: true,
    //                     exportOptions: {
    //                         columns: ':visible'
    //                     }
    //                 },
    //                 {
    //                     extend: 'print',
    //                     className: 'btn-default',
    //                     title: 'Laporan provinsi ',
    //                     messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
    //                     footer: true,
    //                     exportOptions: {
    //                         columns: ':visible'
    //                     }
    //                 },
    //             ],

    //             initComplete: function () {
    //                 var api = this.api();

    //                 // For each column
    //                 api
    //                     .columns()
    //                     .eq(0)
    //                     .each(function (colIdx) {
    //                         // Set the header cell to contain the input element
    //                         var cell = $('.filters th').eq(
    //                             $(api.column(colIdx).header()).index()
    //                         );
    //                         var title = $(cell).text();
    //                         $(cell).html('<input type="text" placeholder="' + title +
    //                             '" style="width:70%; text-align:center;" />');

    //                         // On every keypress in this input
    //                         $(
    //                                 'input',
    //                                 $('.filters th').eq($(api.column(colIdx).header()).index())
    //                             )
    //                             .off('keyup change')
    //                             .on('keyup change', function (e) {
    //                                 e.stopPropagation();

    //                                 // Get the search value
    //                                 $(this).attr('title', $(this).val());
    //                                 var regexr =
    //                                     '({search})';
    //                                 // $(this).parents('th').find('select').val();

    //                                 var cursorPosition = this.selectionStart;
    //                                 // Search the column for that value
    //                                 api
    //                                     .column(colIdx)
    //                                     .search(
    //                                         this.value != '' ?
    //                                         regexr.replace('{search}', '(((' + this.value +
    //                                             ')))') :
    //                                         '',
    //                                         this.value != '',
    //                                         this.value == ''
    //                                     )
    //                                     .draw();

    //                                 $(this)
    //                                     .focus()[0]
    //                                     .setSelectionRange(cursorPosition, cursorPosition);
    //                             });
    //                     });
    //             },

    //             ajax: {
    //                 url: '/dpp/ajax/ajax_provinsi',
    //                 get: 'get',
    //                 data: {
    //                     from: from,
    //                     to: to
    //                 }

    //             },

    //             columns: [{
    //                     data: 'DT_RowIndex',
    //                     name: 'DT_RowIndex',
    //                     className: "text-center"
    //                 },
    //                 {
    //                     data: 'kode',
    //                     name: 'kode',
    //                     className: "text-center"
    //                 },
    //                 {
    //                     data: 'provinsi',
    //                     name: 'provinsi',
    //                     className: "text-left"
    //                 },
    //                 {
    //                     data: 'ketua',
    //                     name: 'provinsi',
    //                     className: "text-left"
    //                 },
    //                 {
    //                     data: 'sekjen',
    //                     name: 'provinsi',
    //                     className: "text-left"
    //                 },
    //                 {
    //                     data: 'bendahara',
    //                     name: 'bendahara',
    //                     className: "text-left"
    //                 },
    //                 {
    //                     data: 'total_kabupaten',
    //                     name: 'total_kabupaten',
    //                     className: "text-center"
    //                 },
    //                 {
    //                     data: 'total',
    //                     name: 'total',
    //                     className: "text-center"
    //                 },
    //                 {
    //                     data: 'action',
    //                     name: 'action',
    //                     className: "text-center"
    //                 },
                    
    //             ],


    //         });
    //     }
    //     $('#filter').click(function () {
    //         var from = $('#from').val();
    //         var to = $('#to').val();
    //         if (from != '' && to != '') {
    //             $('#provinsi').DataTable().destroy();
    //             load_data(from, to);
    //         } else {
    //             alert('Pilih Tanggal Terlebih Dahulu');
    //         }
    //     });
    //     $('#refresh').click(function () {
    //         $('#from').val('');
    //         $('#to').val('');
    //         $('#provinsi').DataTable().destroy();
    //         load_data();
    //     });
    // });

</script>
@stop
