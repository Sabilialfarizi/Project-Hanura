@extends('layouts.master', ['title' => 'Kabupaten'])

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h4 class="page-title">Daftar Anggota Internal DPC : {{ $kabupaten->name }} </h4>
        </div>

        <div class="col-sm-8 text-right m-b-20">

        </div>
    </div>
    <div style="margin-bottom: 10px;" class="row">

        <div class="col-lg-6">
            <div class="alert alert-dark" role="alert">
                DPC Dapat menambahkan anggota baru, menghapus anggota, memperbaiki anggota .
            </div>
        </div>


        <div class="col-lg-6">
            <a style="background-color:#D6A62C; color:#FFFF;" class="btn float-right btn-lg"
                href="{{ route('dpc.member.create') }}">
                <i class="fa fa-plus"></i> Add Anggota
            </a>
        </div>
    </div>



    <div class="card">
        <div class="card-header">

            <!--<div class="row">-->
            <!--    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">-->
            <!--        <table cellspacing="5" cellpadding="5">-->
            <!--            <tbody style="font-size: 14px; 	font-family: 'Rubik', sans-serif;">-->

            <!--                <tr>-->
            <!--                    <td>Count : </td>-->
            <!--                    <td> <input readonly-->
            <!--                            style="font-size:15px; font-weight:bold;  border-top-style: hidden;-->
            <!--                      border-right-style: hidden;-->
            <!--                      border-left-style: hidden;-->
            <!--                      border-bottom-style: groove;-->
            <!--                      background-color: #eee;  -->
            <!--                      outline: none;"-->
            <!--                            class="form-control " id="check"></td>-->

            <!--                </tr>-->

            <!--            </tbody>-->
            <!--        </table>-->
            <!--    </div>-->
            <!--</div>-->


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped " id="kabupaten" width="100%">
                        <thead>

                            <tr style="font-size:12px;">
                                <th>No.</th>

                                <th>Waktu</th>
                                <th>No. KTA</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <!--<th>Status Perkawinan</th>-->
                                <!--<th>Status Pekerjaan</th>-->
                                <th>Alamat</th>
                                <!--<th>Kecamatan</th>-->
                                <!--<th>Kelurahan</th>-->
                                <!--<th>Status Anggota</th>-->
                                <!--<th>Status KTP</th>-->
                                <!--<th>Created By</th>-->
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <!--<div style="margin-bottom: 10px;" class="row">-->
                    <!--    <div class="col-lg-12 col-md-12 col-xl-12">-->
                    <!--        <button type="submit" onclick="transfer()"-->
                    <!--            style="background-color:#D6A62C; color:#FFFF;  margin-top:10px; margin-left:10px;"-->
                    <!--            id="transfer" disabled class="btn float-left">-->
                    <!--            Transfer data-->
                    <!--        </button>-->

                    <!--    </div>-->

                    <!--</div>-->

                </div>
            </div>
        </div>
    @stop
    <style>
        .table.dataTable {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12px;
        }

        .btn.btn-pdf {
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
                       'processing': true,
                        serverSide: true,
                        orderCellsTop: true,
                        fixedHeader: true,
                        "lengthMenu": [10, 25, 50, 75, 100],
                        "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                            "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                        buttons: [{
                                extend: 'copy',

                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: "collection",
                                className: 'btn btn-default',
                                text: "Excel",
                                action: function(e, dt, button, config) {
                                    window.location =
                                        '/dpc/kabupaten/{{ $detail }}/kabupatenall_export';

                                }
                            },
                            {
                                extend: 'pdf',

                                title: 'Laporan Anggota ',

                                footer: true,
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'print',

                                title: 'Laporan Anggota ',

                                footer: true,
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            // {
                            //     extend: 'collection',
                            //     className: 'btn btn-pdf',
                            //     text: 'Daftar Anggota Template KPU',
                            //     buttons: [{
                            //             text: 'Daftar Anggota Template KPU',
                            //             action: function (e, dt, button, config) {
                            //                 window.location =
                            //                     '/dpc/kabupaten/export/{{ $detail }}';
                            //             }
                            //         },
                            //         {
                            //             text: 'Daftar Anggota Template KPU (HP)',
                            //             action: function (e, dt, button, config) {
                            //                 window.location =
                            //                     '/dpc/kabupaten/export_hp/{{ $detail }}';
                            //             }
                            //         }
                            //     ],
                            //     fade: true
                            // },
                            // {
                            //     extend: 'collection',
                            //     className: 'btn btn-pdf',
                            //     text: 'KTA & KTP',
                            //     buttons: [{
                            //             text: 'KTA & KTP',
                            //             action: function (e, dt, button, config) {
                            //                 window.open(
                            //                     '/dpc/kabupaten/{{ $detail }}/showMember',
                            //                     "_blank")

                            //             }
                            //         },
                            //         {
                            //             text: 'KTA & KTP (HP)',
                            //             action: function (e, dt, button, config) {
                            //                 window.open('/dpc/kabupaten/{{ $detail }}/show_hp',
                            //                     "_blank")

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
                            //                 window.open('/dpc/kabupaten/{{ $detail }}/showkta',
                            //                     "_blank")

                            //             }
                            //         },
                            //         {
                            //             text: 'KTA (HP)',
                            //             action: function (e, dt, button, config) {
                            //                 window.open(
                            //                     '/dpc/kabupaten/{{ $detail }}/showkta_hp',
                            //                     "_blank")

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
                            //                 window.open(
                            //                     '/dpc/kabupaten/export_parpol/{{ $detail }}',
                            //                     "_blank")

                            //             }
                            //         },
                            //         {
                            //             text: 'L2-F2 Parpol (HP)',
                            //             action: function (e, dt, button, config) {
                            //                 window.open(
                            //                     '/dpc/kabupaten/export_hp_parpol/{{ $detail }}',
                            //                     "_blank")
                            //             }
                            //         }
                            //     ],
                            //     fade: true
                            // },


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
                            url: '/dpc/ajax/ajax_kabupaten',
                            get: 'get',
                            data: {
                                from: from,
                                to: to
                            }

                        },
                        // 'columnDefs': [{
                        //         targets: '_all',
                        //         visible: true
                        //     },

                        //     {
                        //         'targets': 0,
                        //         'searchable': false,
                        //         'sortable': false,
                        //         'orderable': false,
                        //         'className': 'dt-body-center',
                        //         'render': function(data, type, meta, row) {
                        //             return '<input type="checkbox" class="cb-child" value="' + $(
                        //                 '<div/>').text(data).html() + '">';
                        //         }
                        //     }
                        // ],
                        // 'order': [
                        //     [0, 'desc']
                        // ],

                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                className: "text-center"
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal',

                            },
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
                            //     data: 'kecamatan',
                            //     name: 'kecamatan',

                            // },
                            // {
                            //     data: 'kelurahan',
                            //     name: 'kelurahan',

                            // },
                            // {
                            //     data: 'active',
                            //     name: 'active',

                            // },
                            // {
                            //     data: 'foto_ktp',
                            //     render: function(data, type, full, meta) {
                            //         if (data != null) {
                            //             return 'Y';
                            //         }
                            //         return 'T';
                            //     }
                            // },
                            // {
                            //     data: 'oleh'
                            // },
                            {
                                data: 'action',
                                name: 'action',

                            },
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
                    $("#transfer").prop('disabled', !isChecked)


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

                    $("#transfer").prop('disabled', !button_aktif_status)


                });


            });
        </script>
        <script>
            function transfer() {

                let checkbox = $("#kabupaten tbody .cb-child:checked")
                let semua_id = []

                $.each(checkbox, function(index, elm) {

                    semua_id.push(elm.value)
                    //   console.log(semua_id)
                })

                $.ajax({
                    url: "{{ route('dpc.member.transfer') }}",
                    method: 'post',
                    data: {
                        ids: semua_id
                    },
                    success: function(res) {

                        document.location.reload(null, false)

                        $("#transfer").prop('disabled', true)
                        $("#kabupaten-select-all").prop('checked', false)
                    }

                })
            }
        </script>

    @stop
