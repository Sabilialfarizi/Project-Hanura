@extends('layouts.master')
@section('content')

<!--<div class="card">-->
<!--    <div class="card-header">-->
<!--        Member Report-->
<!--    </div>-->
<!--    <div class="card-body">-->
<!--        <div class="row input-daterange">-->
<!--            <div class="col-sm-6 col-md-3">-->
<!--                <div class="form-group form-focus">-->
<!--                    <label class="focus-label">From</label>-->
<!--                    <div class="cal-icon">-->
<!--                        <input type="text" name="from" id="from" class="form-control" placeholder="From Date" />-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="col-sm-6 col-md-3">-->
<!--                <div class="form-group form-focus">-->
<!--                    <label class="focus-label">To</label>-->
<!--                    <div class="cal-icon">-->
<!--                        <input type="text" name="to" id="to" class="form-control" placeholder="To Date" />-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="col-sm-6 col-md-3">-->
<!--                <div style="margin-top:8px;">-->
<!--                    <button type="button" name="filter" id="filter" class="btn btn-primary"><i-->
<!--                            class="fa-solid fa-magnifying-glass"></i></button>-->
<!--                    <button type="button" name="refresh" id="refresh" class="btn btn-danger"><i-->
<!--                            class="fa-solid fa-arrows-rotate"></i></button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

<!--    </div>-->
<!--</div>-->


<div class="card">
    <div class="card-header">
        List Anggota Diperbaiki
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="report table table-bordered table-striped table-hover datatable" id="pembatalan" width="100%">
                <thead>
                    <tr>
                        <th width="10">
                            No.
                        </th>

                        <th>
                            No. KTA
                        </th>
                        <th>
                            NIK
                        </th>
                        <th>
                            Nama
                        </th>
                        <th>
                            Alamat
                        </th>
                        <th>
                            Alasan Perbaikan
                        </th>
                        <th>
                            Action
                        </th>
                   
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
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
        // $('#pembatalan thead tr')
        //     .clone(true)
        //     .addClass('filters')
        //     .appendTo('#pembatalan thead');
        load_data();


        function load_data(from = '', to = '') {
            var from = $('#from').val();
            var to = $('#to').val();

            var table = $('#pembatalan').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                fixedHeader: true,
                "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                        extend: 'copy',
                        className: 'btn-default',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-default',
                        title: 'Laporan Pembatalan Anggota',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Laporan Pembatalan Anggota ',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        title: 'Laporan Pembatalan Anggota ',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
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
                    url: '/dpd/ajax/ajax_repair',
                    get: 'get',
                    data: {
                        from: from,
                        to: to
                    }

                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                   
                    },
                    {
                        data: 'no_anggota',
                        name: 'no_anggota',
                    
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                      
                    },
                    {
                        data: 'name',
                        name: 'name',
                      
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                      
                    },
                    {
                        data: 'alasan',
                        name: 'alasan',
                      
                    },
                    {
                        data: 'action',
                        name: 'action',
                      
                    },
                   

                ],


            });
        }
        $('#filter').click(function () {
            var from = $('#from').val();
            var to = $('#to').val();
            if (from != '' && to != '') {
                $('#anggota').DataTable().destroy();
                load_data(from, to);
            } else {
                alert('Pilih Tanggal Terlebih Dahulu');
            }
        });
        $('#refresh').click(function () {
            $('#from').val('');
            $('#to').val('');
            $('#anggota').DataTable().destroy();
            load_data();
        });
    });

</script>
@stop
