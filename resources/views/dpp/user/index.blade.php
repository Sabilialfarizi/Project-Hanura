@extends('layouts.master', ['title' => 'User'])

@section('content')
<div class="row">
    <div class="col-md-4">
      <h4 class="page-title">List User</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a style="background-color:#D6A62C; color:#FFFF;" class="btn float-right"
            href="{{ route('dpp.user.create') }}">
            <i class="fa fa-plus"></i> Add User
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <!-- {{ trans('cruds.information.title_singular') }} {{ trans('global.list') }} -->
    <!-- Informasi -->
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="report table table-bordered table-striped table-hover datatable" id="user" width="100%">
                <thead>
                <tr style="font-size:12px;">
                        <th width="10">
                            No.
                        </th>
                            <th>No. KTA</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Tipe</th>
                            <th>Kabupaten / Kota</th>
                            <th>Provinsi</th>
                            <th>Phone</th>
                            <th>Action</th>
                           
                    </tr>
                </thead>
                <tbody>
                    
                    </tbody>
            </table>
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
    $(document).ready(function () {
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
        // $('#user thead tr')
        //     .clone(true)
        //     .addClass('filters')
        //     .appendTo('#user thead');
        load_data();


        function load_data(from = '', to = '') {
            var from = $('#from').val();
            var to = $('#to').val();

            var table = $('#user').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                fixedHeader: true,
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
                        title: 'Laporan user',
                      
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-pdf',
                        title: 'Laporan user ',
                    
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-pdf',
                        title: 'Laporan user ',
                     
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ],

                initComplete: function () {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title +
                                '" style="width:70%; text-align:center;" />');

                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('keyup change', function (e) {
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
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();

                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },

                ajax: {
                    url: '/dpp/ajax/ajax_user',
                    get: 'get',
                    data: {
                        from: from,
                        to: to
                    }

                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-left"
                    },
                    {
                        data: 'kode',
                        name: 'kode',
                        className: "text-left"
                    },
                    {
                        data: 'user',
                        name: 'user',
                        className: "text-left"
                    },
                    {
                        data: 'username',
                        name: 'username',
                        className: "text-left"
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: "text-left"
                    },
                    {
                        data: 'tipe',
                        name: 'tipe',
                        className: "text-left"
                    },
                    {
                        data: 'kabupaten',
                        name: 'kabupaten',
                        className: "text-left"
                    },
                    {
                        data: 'provinsi',
                        name: 'provinsi',
                        className: "text-left"
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        className: "text-left"
                    },
                        {
                            data: 'action',
                        name: 'action',
                        className: "text-center"
                    },
                    
                ],


            });
        }
        $('#filter').click(function () {
            var from = $('#from').val();
            var to = $('#to').val();
            if (from != '' && to != '') {
                $('#user').DataTable().destroy();
                load_data(from, to);
            } else {
                alert('Pilih Tanggal Terlebih Dahulu');
            }
        });
        $('#refresh').click(function () {
            $('#from').val('');
            $('#to').val('');
            $('#user').DataTable().destroy();
            load_data();
        });
    });

</script>
@stop