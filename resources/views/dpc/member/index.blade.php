@extends('layouts.master', ['title' => 'Kabupaten'])

@section('content')
@php
$hanura = \App\User::join('detail_users','detail_users.userid','=','users.id')
->join('model_has_roles','users.id','=','model_has_roles.model_id')
->where('detail_users.status_kpu', 1)
->where('detail_users.kabupaten_domisili', $detail)
->where('detail_users.status_kta', 1)
->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
->groupBy( 'detail_users.nik')
->get()
->count();

$target = DB::table('kantor')->where('id_daerah' , $detail)->first();
$total_target = $target->target_dpc ?? '0' ;

$kpu = \App\User::join('detail_users','detail_users.userid','=','users.id')
->join('model_has_roles','users.id','=','model_has_roles.model_id')
->where('detail_users.kabupaten_domisili', $detail)
->where('detail_users.status_kta', 1)
->where('detail_users.status_kpu', 3)
->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
->groupBy( 'detail_users.nik')
->get()
->count();
$recieved = \App\User::join('detail_users','detail_users.userid','=','users.id')
->join('model_has_roles','users.id','=','model_has_roles.model_id')
->where('detail_users.kabupaten_domisili', $detail)
->where('detail_users.status_kta', 1)
->where('detail_users.status_kpu', 2)
->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
->groupBy('detail_users.nik')
->get()
->count();
$fail = \App\User::join('detail_users','detail_users.userid','=','users.id')
->join('model_has_roles','users.id','=','model_has_roles.model_id')
->where('detail_users.kabupaten_domisili', $detail)
->where('detail_users.status_kta', 1)
->where('detail_users.status_kpu', 4)
->where('detail_users.status_kpu','!=' ,array(1,2,3))
->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
->groupBy('detail_users.nik')
->get()
->count();

$total_anggota = DB::table('detail_users')
->join('users','detail_users.userid','=','users.id')
->join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
->where('detail_users.status_kta',1)
->where('detail_users.kabupaten_domisili', $detail)
->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
->groupBy('detail_users.no_member')
->get()
->count();
$belum = \App\User::join('detail_users','detail_users.userid','=','users.id')
->join('model_has_roles','users.id','=','model_has_roles.model_id')
->where('detail_users.kabupaten_domisili', $detail)
->where('detail_users.status_kta', 1)
->where('detail_users.status_kpu', 5)
->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
->groupBy('detail_users.nik')
->get()
->count();

@endphp
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" style="color:#D6A62C; font-size:19px; font-weight:bold;" aria-current="page"
                href="{{ url('dpc/anggota/index') }}">Belum Ditransfer<span style="margin-left:52px;"
                    class="badge">{{ $hanura }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="color:#D6A62C; font-size:19px; font-weight:bold;"
                href="{{ url('dpc/anggota/sdh_transfer') }}">Sudah
                Ditransfer<span style="margin-left:52px;" class="badge">{{ $recieved }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="color:#D6A62C; font-size:19px; font-weight:bold;"
                href="{{ url('dpc/anggota/tdk_memenuhi') }}">Tidak Memenuhi
                Syarat<span style="margin-left:52px;" class="badge">{{ $fail }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="color:#D6A62C; font-size:19px; font-weight:bold;"
                href="{{ url('dpc/anggota/hasil_perbaikan') }}">Hasil
                Perbaikan<span style="margin-left:52px;" class="badge">{{ $belum }}</span></a>
        </li>
    </ul>
    <br>

    @include('sweetalert::alert')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-title">Daftar Anggota DPC {{ $status_belum->nama_status }} : {{ $kabupaten->name }}
                    </h4>
                </div>

                <div class="col-sm-8 text-right m-b-20">

                </div>
            </div>




            <!--<div class="row">-->
            <!--    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">-->
            <!--        <div class="panel panel-{{ $status_belum->warna_status }}">-->
            <!--            <div class="panel-heading" style="font-size:14px;">-->

            <!--                Anggota {{ $status_belum->nama_status }}-->

            <!--            </div>-->
            <!--            <div class="panel-body-index" style="text-align:center;"> {{ $hanura }}</div>-->
            <!--        </div>-->
            <!--    </div>-->


            <!--    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">-->
            <!--        <div class="panel panel-{{ $status_terkirim->warna_status }}">-->
            <!--            <div class="panel-heading" style="font-size:14px;">-->

            <!--                Anggota {{ $status_terkirim->nama_status }}-->

            <!--            </div>-->
            <!--            <div class="panel-body-index" style="text-align:center;"> {{ $recieved }}</div>-->
            <!--        </div>-->
            <!--    </div>-->

            <!--    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">-->
            <!--        <div class="panel panel-{{ $status_tidak_lolos->warna_status }}">-->
            <!--            <div class="panel-heading" style="font-size:14px;">-->

            <!--                Anggota {{ $status_tidak_lolos->nama_status }}-->


            <!--            </div>-->
            <!--            <div class="panel-body-index" style="text-align:center;"> {{ $fail }}</div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="row">-->
            <!--    <div class="col-md-3 col-sm-4 col-lg-4 col-xl-4">-->
            <!--        <div class="panel panel-{{ $hasil_perbaikan->warna_status }}">-->
            <!--            <div class="panel-heading" style="font-size:14px;">-->

            <!--                Anggota {{ $hasil_perbaikan->nama_status }}-->

            <!--            </div>-->
            <!--            <div class="panel-body-index" style="text-align:center;"> {{ $belum }}</div>-->
            <!--        </div>-->
            <!--    </div>-->

            <!--</div>-->
            <br>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                    <table cellspacing="5" cellpadding="5">
                        <tbody style="font-size: 14px; 	font-family: 'Rubik', sans-serif;">

                            <tr>
                                <td>Count : </td>
                                <td> <input readonly
                                        style="font-size:15px; font-weight:bold;  border-top-style: hidden;
                                  border-right-style: hidden;
                                  border-left-style: hidden;
                                  border-bottom-style: groove;
                                  background-color: #eee;  
                                  outline: none;"
                                        class="form-control " id="check"></td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped " id="kabupaten" width="100%">
                        <thead>

                            <tr style="font-size:11px;">
                                <th><input type="checkbox" name="select_all" value="1" id="kabupaten-select-all"></th>

                                <!--<th>Waktu</th>-->
                                <th>No. KTA</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Tanggal Pengesahan</th>
                                <!--<th>Status Perkawinan</th>-->
                                <!--<th>Status Pekerjaan</th>-->
                                <th>Alamat</th>
                                <!--<th>Status Anggota</th>-->
                                <th>Status KPU</th>
                                <!--<th>Action</th>-->

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                        @php
                            $target = $target->target_dpc ?? '0';
                            $total = $target - $total_anggota;
                        @endphp
                    </table>
                    @if ($total_target == 0)
                        <div class="row">
                            <div class="col-sm-6 col-sg-4 m-b-4">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <a style="font-weight:bold;"
                                        href="https://www.hanura.net/dpd/kabupaten/{{ $detail }}/kantor">BELUM
                                        MENGISI TARGET
                                        ANGGOTA DPC</a>
                                </div>
                            </div>

                        </div>
                    @elseif($total_target != 0)
                        <div style="margin-bottom: 10px;" class="row">
                            <div class="col-lg-12 col-md-12 col-xl-12">

                                <!--<button type="submit" onclick="print_all()"-->
                                <!--    style="background-color:#D6A62C; color:#FFFF;  margin-top:10px; margin-left:10px;" id="print_all"-->
                                <!--    disabled class="btn float-left">-->
                                <!--    Print KTA All-->
                                <!--</button>-->
                                <button type="submit" onclick="nonaktif()"
                                    style="background-color:#D6A62C; color:#FFFF;  margin-top:10px; margin-left:10px;"
                                    id="button_nonaktif" disabled class="btn float-left">
                                    Transfer data ke template kpu
                                </button>
                                <button type="submit" onclick="akftifstatus()"
                                    style="background-color:#D6A62C; color:#FFFF; margin-top:10px; margin-left:10px;"
                                    id="button_aktif" disabled class="btn float-left">
                                    Menghapus data dari template kpu
                                </button>

                                <!--
                        <button type="submit" onclick="receivedstatus()"
                            style="background-color:#D6A62C; color:#FFFF;  margin-left:10px;" id="button_received" disabled
                            class="btn float-left">
                            Terkirim KPU
                        </button>
                        -->

                                <button type="submit" onclick="failstatus()"
                                    style="background-color:#D6A62C; color:#FFFF; margin-top:10px; margin-left:10px;"
                                    id="button_fail" disabled class="btn float-left">
                                    Menghapus Data TMS (Tidak memenuhi syarat)
                                </button>
                            </div>
                            <div class="col-lg-12 col-md-12 col-xl-12">
                                <button type="submit" onclick="hasil()"
                                    style="background-color:#D6A62C; color:#FFFF; margin-top:10px;  margin-left:10px;"
                                    id="button_hasil" disabled class="btn float-left">
                                    Transfer Data Hasil Perbaikan
                                </button>

                            </div>

                        </div>
                    @endif
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
            color: white;
            background-color: #D6A62C;
        }
    </style>
    @section('footer')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>


        <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

        <script>
            $(document).ready(function() {
                let yangdicheck = 0;
                $('.input-daterange').datepicker({
                    todayBtn: 'linked',
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
                $.noConflict();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // $('#kabupaten thead tr')
                //     .clone(true)
                //     .addClass('filters')
                //     .appendTo('#kabupaten thead');
                load_data();


                function load_data(from = '', to = '') {
                    var from = $('#from').val();
                    var to = $('#to').val();

                    var table = $('#kabupaten').DataTable({
                        processing: true,

                        serverSide: true,
                        orderCellsTop: true,
                        fixedHeader: true,
                        "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-12'B><'col-sm-12'f>>" +
                            "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        buttons: [
                            // {
                            //     extend: 'copy',

                            //     exportOptions: {
                            //         columns: ':visible'
                            //     }
                            // },
                           /* {
                                extend: 'excel',

                                title: 'Laporan Anggota',

                                footer: true,
                                exportOptions: {
                                    columns: ':visible'
                                }
                            }, */
                            // {
                            //     extend: 'pdf',

                            //     title: 'Laporan Anggota ',

                            //     footer: true,
                            //     exportOptions: {
                            //         columns: ':visible'
                            //     }
                            // },
                            // {
                            //     extend: 'print',

                            //     title: 'Laporan Anggota ',

                            //     footer: true,
                            //     exportOptions: {
                            //         columns: ':visible'
                            //     }
                            // },
                            // {
                            //     extend: 'collection',
                            //     className: 'btn btn-pdf',
                            //     text: 'Daftar Anggota Template KPU',
                            //     buttons: [{
                            //             text: 'Daftar Anggota Template KPU',
                            //             action: function(e, dt, button, config) {
                            //                 window.location =
                            //                     '/dpc/kabupaten/export/{{ $detail }}';
                            //             }
                            //         },
                            //         {
                            //             text: 'Daftar Anggota Template KPU (HP)',
                            //             action: function(e, dt, button, config) {
                            //                 window.location =
                            //                     '/dpc/kabupaten/export_hp/{{ $detail }}';
                            //             }
                            //         }
                            //     ],
                            //     fade: true
                            // },
                        //     {
                        //     extend: 'collection',
                        //     className: 'btn btn-pdf',
                        //     text: 'KTA & KTP',
                        //     buttons: [{
                        //             text: 'KTA & KTP',
                        //             action: function (e, dt, button, config) {
                        //                 window.location =
                        //                     '/dpc/kabupaten/{{ $detail }}/showMember';

                        //             }
                        //         },
                        //         {
                        //             text: 'KTA & KTP (HP)',
                        //             action: function (e, dt, button, config) {
                        //                 window.location ='/dpc/kabupaten/{{ $detail }}/show_hp';

                        //             }
                        //         }
                        //     ],
                        //     fade: true
                        // },
                        // {
                        //     extend: 'collection',
                        //     className: 'btn btn-pdf',
                        //     text: 'KTA',
                        //     buttons: [{
                        //             text: 'KTA',
                        //             action: function (e, dt, button, config) {
                        //                 window.location ='/dpc/kabupaten/{{ $detail }}/showkta';

                        //             }
                        //         },
                        //         {
                        //             text: 'KTA (HP)',
                        //             action: function (e, dt, button, config) {
                        //                 window.location =
                        //                     '/dpc/kabupaten/{{ $detail }}/showkta_hp';

                        //             }
                        //         }
                        //     ],
                        //     fade: true
                        // },
                        // {
                        //     extend: 'collection',
                        //     className: 'btn btn-pdf',
                        //     text: 'L2-F2 Parpol',
                        //     buttons: [{
                        //             text: 'L2-F2 Parpol',
                        //             action: function (e, dt, button, config) {
                        //                 window.location =
                        //                     '/dpc/kabupaten/export_parpol/{{ $detail }}';

                        //             }
                        //         },
                        //         {
                        //             text: 'L2-F2 Parpol (HP)',
                        //             action: function (e, dt, button, config) {
                        //                 window.location =
                        //                     '/dpc/kabupaten/export_hp_parpol/{{ $detail }}';
                        //             }
                        //         }
                        //     ],
                        //     fade: true
                        // },
                            
                            /*
                            {
                                extend: "collection",
                                className: 'btn btn-pdf',
                                text: "FOLDER KTA & KTP (zip)",
                                action: function(e, dt, button, config) {
                                    window.open(
                                        '/dpc/kabupaten/export_parpol/{{ $detail }}',
                                        "_blank")

                                }
                            },
                            */

                        ],

                        initComplete: function() {
                            var api = this.api();

                            // For each column
                            api
                                .columns()
                                .eq(0)
                                .each(function(colIdx) {
                                    // Set the header cell to contain the input element
                                    var cell = $('.filters th').eq(
                                        $(api.column(colIdx).header()).index()
                                    );
                                    var title = $(cell).text();
                                    $(cell).html('<input type="text" placeholder="' + title +
                                        '" style="width:100%; text-align:center;" />');

                                    // On every keypress in this input
                                    $(
                                            'input',
                                            $('.filters th').eq($(api.column(colIdx).header())
                                                .index())
                                        )
                                        .off('keyup change')
                                        .on('keyup change', function(e) {
                                            e.stopPropagation();

                                            // Get the search value
                                            $(this).attr('title', $(this).val());
                                            var regexr =
                                                '({search})';
                                            // $(this).parents('th').find('select').val();

                                            var cursorPosition = this.selectionStart;
                                            // Search the column for that value
                                            api
                                                .column(colIdx)
                                                .search(
                                                    this.value != '' ?
                                                    regexr.replace('{search}', '(((' + this
                                                        .value +
                                                        ')))') :
                                                    '',
                                                    this.value != '',
                                                    this.value == ''
                                                )
                                                .draw();

                                            $(this)
                                                .focus()[0]
                                                .setSelectionRange(cursorPosition,
                                                    cursorPosition);
                                        });
                                });
                        },

                        ajax: {
                            url: '/dpc/ajax/ajax_member',
                            get: 'get',
                            data: {
                                from: from,
                                to: to
                            }

                        },
                        'columnDefs': [{
                                targets: '_all',
                                visible: true
                            },

                            {
                                'targets': 0,
                                'searchable': false,
                                'sortable': false,
                                'orderable': false,
                                'className': 'dt-body-center',
                                'render': function(data, type, meta, row) {
                                    return '<input type="checkbox" class="cb-child" value="' + $(
                                        '<div/>').text(data).html() + '">';
                                }
                            }
                        ],
                        // 'order': [
                        //     [1, 'desc']
                        // ],

                        columns: [{
                                data: 'id',
                                name: 'id',
                                className: "text-center"
                            },
                            // {
                            //     data: 'tanggal',
                            //     name: 'tanggal',

                            // },
                            {
                                data: 'no_anggota',
                                name: 'no_anggota',

                            },
                            {
                                data: 'name',
                                name: 'name',

                            },
                            {
                                data: 'nik',
                                name: 'nik',

                            },
                            {
                                data: 'gender',
                                name: 'gender',

                            },
                            {
                                data: 'tempat_lahir',
                                name: 'tempat_lahir',

                            },
                            {
                                data: 'tgl_lahir',
                                name: 'tgl_lahir',

                            },
                            {
                                data: 'tanggal_pengesahan',
                                name: 'tanggal_pengesahan'
                            },
                            // {
                            //     data: 'status',
                            //     name: 'status',

                            // },
                            // {
                            //     data: 'pekerjaan',
                            //     name: 'pekerjaan',

                            // },
                            {
                                data: 'alamat',
                                name: 'alamat',

                            },
                            // {
                            //     data: 'active',
                            //     name: 'active',

                            // },
                            {
                                data: 'status_kpu',
                                name: 'status_kpu',

                            },
                            // {
                            //     data: 'action',
                            //     name: 'action',

                            // },
                        ],


                    });
                }
                $('#filter').click(function() {
                    var from = $('#from').val();
                    var to = $('#to').val();
                    if (from != '' && to != '') {
                        $('#kabupaten').DataTable().destroy();
                        load_data(from, to);
                    } else {
                        alert('Pilih Tanggal Terlebih Dahulu');
                    }
                });
                $('#refresh').click(function() {
                    $('#from').val('');
                    $('#to').val('');
                    $('#kabupaten').DataTable().destroy();
                    load_data();
                });


                // Handle click on "Select all" control
                $('#kabupaten-select-all').on('click', function() {
                    var isChecked = $("#kabupaten-select-all").prop('checked')

                    var check = $(".cb-child").prop('checked', isChecked).length

                    document.getElementById('check').value = check;
                    $("#button_aktif").prop('disabled', !isChecked)
                    $("#button_nonaktif").prop('disabled', !isChecked)
                    // $("#button_received").prop('disabled', !isChecked)
                    // $("#button_fail").prop('disabled', !isChecked)
                    // $("#print_all").prop('disabled', !isChecked)
                    // $("#button_hasil").prop('disabled', !isChecked)

                });

                // Handle click on checkbox to set state of "Select all" control
                $('#kabupaten tbody').on('click', '.cb-child', function() {
                    if ($(this).prop('checked') != true) {
                        $("#kabupaten-select-all").prop('checked', false)


                    }

                    var check = $('.cb-child:checked').length
                    document.getElementById('check').value = check;

                    let all_checkbox = $("#kabupaten tbody .cb-child:checked ")

                    let button_aktif_status = (all_checkbox.length > 0)

                    $("#button_aktif").prop('disabled', !button_aktif_status)
                    // $("#print_all").prop('disabled', !button_aktif_status)
                    $("#button_nonaktif").prop('disabled', !button_aktif_status)
                    // $("#button_received").prop('disabled', !button_aktif_status)
                    // $("#button_fail").prop('disabled', !button_aktif_status)
                    // $("#button_hasil").prop('disabled', !button_aktif_status)

                });

            });
        </script>
        <script>
            function print_all() {

                let checkbox = $("#kabupaten tbody .cb-child:checked")
                let semua_id = []

                $.each(checkbox, function(index, elm) {

                    semua_id.push(elm.value)
                    //   console.log(semua_id)
                })

                $.ajax({
                    url: "{{ route('dpc.kabupaten.showmember') }}",
                    method: 'GET',
                    data: {
                        ids: semua_id
                    },
                    success: function(res) {

                        document.location.reload(null, false)


                        $("#button_aktif").prop('disabled', true)
                        $("#print_all").prop('disabled', true)
                        $("#button_nonaktif").prop('disabled', true)
                        $("#button_received").prop('disabled', true)
                        $("#button_fail").prop('disabled', true)
                        $("#button_hasil").prop('disabled', true)
                        $("#kabupaten-select-all").prop('checked', false)
                    }

                })
            }

            function receivedstatus() {

                let checkbox = $("#kabupaten tbody .cb-child:checked")
                let semua_id = []

                $.each(checkbox, function(index, elm) {

                    semua_id.push(elm.value)
                    //   console.log(semua_id)
                })

                $.ajax({
                    url: "{{ route('dpc.kabupaten.updatereceived') }}",
                    method: 'post',
                    data: {
                        ids: semua_id
                    },
                    success: function(res) {

                        document.location.reload(null, false)


                        $("#button_aktif").prop('disabled', true)
                        $("#button_nonaktif").prop('disabled', true)
                        $("#button_received").prop('disabled', true)
                        $("#button_fail").prop('disabled', true)
                        $("#button_hasil").prop('disabled', true)
                        $("#kabupaten-select-all").prop('checked', false)
                    }

                })
            }

            function failstatus() {

                let checkbox = $("#kabupaten tbody .cb-child:checked")
                let semua_id = []

                $.each(checkbox, function(index, elm) {

                    semua_id.push(elm.value)
                    // console.log(semua_id)
                })

                $.ajax({
                    url: "{{ route('dpc.kabupaten.updatefail') }}",
                    method: 'post',
                    data: {
                        ids: semua_id
                    },
                    success: function(res) {

                        document.location.reload(null, false)
                        $("#button_aktif").prop('disabled', true)
                        $("#button_nonaktif").prop('disabled', true)
                        $("#button_received").prop('disabled', true)
                        $("#button_fail").prop('disabled', true)
                        $("#button_hasil").prop('disabled', true)
                        $("#kabupaten-select-all").prop('checked', false)
                    }

                })
            }

            function akftifstatus() {

                let checkbox = $("#kabupaten tbody .cb-child:checked")
                let semua_id = []

                $.each(checkbox, function(index, elm) {

                    semua_id.push(elm.value)
                    //   console.log(semua_id)
                })

                $.ajax({
                    url: "{{ route('dpc.kabupaten.updatestatus') }}",
                    method: 'post',
                    data: {
                        ids: semua_id
                    },
                    success: function(res) {
                        document.location.reload(null, false)


                        $("#button_aktif").prop('disabled', true)
                        $("#button_nonaktif").prop('disabled', true)
                        $("#button_received").prop('disabled', true)
                        $("#button_fail").prop('disabled', true)
                        $("#button_hasil").prop('disabled', true)
                        $("#kabupaten-select-all").prop('checked', false)
                    }
                })
            }

            function nonaktif() {

                let checkbox = $("#kabupaten tbody .cb-child:checked")
                let semua_id = []

                $.each(checkbox, function(index, elm) {

                    semua_id.push(elm.value)
                    // console.log(semua_id)
                })

                $.ajax({
                    url: "{{ route('dpc.kabupaten.updatenonaktif') }}",
                    method: 'post',
                    data: {
                        ids: semua_id
                    },
                    success: function(res) {
                        document.location.reload(null, false)

                        $("#button_aktif").prop('disabled', true)
                        $("#button_nonaktif").prop('disabled', true)
                        $("#button_received").prop('disabled', true)
                        $("#button_fail").prop('disabled', true)
                        $("#button_hasil").prop('disabled', true)
                        $("#kabupaten-select-all").prop('checked', false)
                    }
                })
            }

            function hasil() {

                let checkbox = $("#kabupaten tbody .cb-child:checked")
                let semua_id = []

                $.each(checkbox, function(index, elm) {

                    semua_id.push(elm.value)
                    // console.log(semua_id)
                })

                $.ajax({
                    url: "{{ route('dpc.kabupaten.updatehasil') }}",
                    method: 'post',
                    data: {
                        ids: semua_id
                    },
                    success: function(res) {
                        document.location.reload(null, false)

                        $("#button_aktif").prop('disabled', true)
                        $("#button_nonaktif").prop('disabled', true)
                        $("#button_received").prop('disabled', true)
                        $("#button_fail").prop('disabled', true)
                        $("#button_hasil").prop('disabled', true)
                        $("#kabupaten-select-all").prop('checked', false)
                    }
                })
            }
        </script>


    @stop
