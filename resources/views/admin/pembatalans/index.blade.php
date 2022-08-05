@extends('layouts.master', ['title' => 'Pembatalan Unit'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Pembatalan Unit</h1>
    </div>
</div>

<x-alert></x-alert>

<div class="row input-daterange">
    <div class="col-sm-6 col-md-3">
        <div class="form-group form-focus">
            <label class="focus-label">From</label>
            <div class="cal-icon">
                <input type="text" name="from" id="from" class="form-control" placeholder="From Date" />
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="form-group form-focus">
            <label class="focus-label">To</label>
            <div class="cal-icon">
                <input type="text" name="to" id="to" class="form-control" placeholder="To Date" />
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <button type="button" name="filter" id="filter" class="btn btn-primary">Search</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table" id="pembatalans" width="100%">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>No Pembatalan</th>
                        <th>Tanggal</th>
                        <th>Type</th>
                        <th>Spr</th>
                        <th>Total Beli</th>
                        <th>Konsumen</th>
                        <th>Sales</th>
                        <th>Booking Fee</th>
                        <th>DP</th>
                        <th>Diajukan</th>
                        <th>Status</th>
                        <th>Refund</th>
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
        $('#pembatalans thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#pembatalans thead');

        load_data();


        function load_data(from = '', to = '') {
            var from = $('#from').val();
            console.log(from)
         
            // var to = $('#to').val();


            var table = $('#pembatalans').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                fixedHeader: true,
                dom: 'Bfrtip',
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
                        title: 'Laporan Pembatalan',
                        messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Laporan Pembatalan',
                        messageTop: 'Tanggal {{ request("from") }} - {{ request("to") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        
                        extend: 'print',
                        className: 'btn-default',
                        title: 'Laporan Pembatalan',
                        messageTop: 'Tanggal {{ request("from")}} - {{ request("to") }}',
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
                            $(cell).html('<input type="text" placeholder="' + title + '" style="width:70%;" />');

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
                                        '({search})'; //$(this).parents('th').find('select').val();

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
                    url: '/admin/ajax/ajax_pembatalan',
                    get: 'get',
                    data: {
                        from: from,
                        to: to
                    }

                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'no_pembatalan',
                        name: 'no_pembatalan'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'spr',
                        name: 'spr'
                    },
                    {
                        data: 'total_beli',
                        name: 'total_beli',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp.')
                    },
                    {
                        data: 'konsumen',
                        name: 'konsumen'
                    },
                    {
                        data: 'sales',
                        name: 'sales'
                    },
                    {
                        data: 'booking_fee',
                        name: 'booking_fee'
                    },
                    {
                        data: 'dp',
                        name: 'dp'
                    },
                    {
                        data: 'diajukan',
                        name: 'diajukan'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'refund',
                        name: 'refund'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },


                ],


            });
        }
        $('#filter').click(function () {
            var from = $('#from').val();
            var to = $('#to').val();
            if (from != '' && to != '') {
                $('#pembatalans').DataTable().destroy();
                load_data(from, to);
            } else {
                alert('Pilih Tanggal Terlebih Dahulu');
            }
        });
        $('#refresh').click(function () {
            $('#from').val('');
            $('#to').val('');
            $('#pembatalans').DataTable().destroy();
            load_data();
        });
    });

</script>
@stop
