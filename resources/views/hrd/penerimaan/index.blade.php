@extends('layouts.master', ['title' => 'Reinburst'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Acc Reinburst</h1>
    </div>

</div>
<x-alert></x-alert>
<br />
<div class="row input-daterange">
    <div class="col-sm-6 col-md-3">
        <div class="form-group form-focus">
            <label class="focus-label">From</label>
            <div class="cal-icon">
                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date"
                     />
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="form-group form-focus">
            <label class="focus-label">To</label>
            <div class="cal-icon">
                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date"  />
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="form-group form-focus">
            <button type="button" name="filter" id="filter" class="btn btn-primary">Search</button>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table report" id="accreinburst" width="100%">
                <thead>
                    <tr class="text-left">
                        <th >No</th>
                        <th style="width: 20%;">Nomor Reinburst</th>
                        <th style="width: 20%;">Tanggal Reinburst</th>
                        <th  style="width: 5%;">Total Item</th>
                        <th style="width: 20%;">Total Pembelian</th>
                        <th style="width: 20%;">Status Hrd</th>
                        <th style="width: 15%;">Status Pembayaran</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- <tr>
                        <td>{{ $loop->iteration }}</td>
                    <td><a
                            href="{{ route('hrd.penerimaan.show', $reinburst->id) }}">{{ $reinburst->nomor_reinburst }}</a>
                    </td>
                    <td>{{ Carbon\Carbon::parse($reinburst->tanggal_reinburst)->format("d/m/Y") }}</td>
                    <td>{{ \App\Reinburst::where('nomor_reinburst', $reinburst->nomor_reinburst)->count() }}</td>
                    <td>@currency(\App\RincianReinburst::where('nomor_reinburst',
                        $reinburst->nomor_reinburst)->sum('total'))</td>
                    <td>
                        <div class="d-flex justify-content-center mt-2">
                            @if($reinburst->status_hrd == 'pending')
                            <span class="custom-badge status-red">pending</span>
                            @endif
                            @if($reinburst->status_hrd == 'completed')
                            <span class="custom-badge status-green">completed</span>
                            @endif
                            @if($reinburst->status_hrd == 'review')
                            <span class="custom-badge status-orange">review</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center mt-2">
                            @if($reinburst->status_pembayaran == 'pending')
                            <span class="custom-badge status-red">pending</span>
                            @endif
                            @if($reinburst->status_pembayaran == 'completed')
                            <span class="custom-badge status-green">completed</span>
                            @endif
                            @if($reinburst->status_pembayaran == 'review')
                            <span class="custom-badge status-orange">review</span>
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <form action="{{ route('hrd.penerimaan.update', $reinburst->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning">Review</button>
                            </form>
                            <form action="{{ route('hrd.penerimaan.statuscompleted', $reinburst->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Completed</button>
                            </form>
                        </div>

                    </td>
                    </tr> --}}
                </tbody>

                <tfoot>
                    <tr>
                        <td>Total : </td>
                        <td colspan="2"></td>
                        <td>{{ request('from') && request('to') ? \App\Reinburst::whereBetween('tanggal_reinburst', [Carbon\Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d'), Carbon\Carbon::createFromFormat('d/m/Y', request('to'))->format('Y-m-d')])->where('status_hrd','!=','completed')->get()->count() : \App\Reinburst::where('status_hrd','!=','completed')->get()->count() }}
                        </td>
                        <td>@currency( request('from') && request('to') ?
                            DB::table('rincian_reinbursts')->leftjoin('reinbursts','rincian_reinbursts.nomor_reinburst','=','reinbursts.nomor_reinburst')->whereBetween('reinbursts.tanggal_reinburst',
                            [Carbon\Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d'),
                            Carbon\Carbon::createFromFormat('d/m/Y',
                            request('to'))->format('Y-m-d')])->where('reinbursts.status_hrd','!=','completed')->sum('rincian_reinbursts.total')
                            :
                            DB::table('rincian_reinbursts')->leftjoin('reinbursts','rincian_reinbursts.nomor_reinburst','=','reinbursts.nomor_reinburst')->where('reinbursts.status_hrd','!=','completed')->sum('rincian_reinbursts.total')
                            )</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </tfoot>
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
        $('#accreinburst thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#accreinburst thead');

        load_data();


        function load_data(from_date = '', to_date = '') {
            var table = $('#accreinburst').DataTable({
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
                        title: 'Laporan Acc Reinburst ',
                        messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Laporan Acc Reinburst ',
                        messageTop: 'Tanggal {{ request("from") }} - {{ request("to") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        title: 'Laporan Acc Reinburst ',
                        messageTop: 'Tanggal {{ request("from") }} - {{ request("to") }}',
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
                            $(cell).html('<input type="text" placeholder="' + title + '"  style="width:70%;"/>');

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
                    url: '/admin/ajax/ajax_acc_reinburst',
                    get: 'get',
                    data: {
                        from_date: from_date,
                        to_date: to_date
                    }

                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'no_reinburst',
                        name: 'no_reinburst'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'pembelian',
                        name: 'pembelian',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp.')
                    },

                    {
                        data: 'status_hrd',
                        name: 'status_hrd'
                    }, {
                        data: 'status_pembayaran',
                        name: 'status_pembayaran'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }

                ],


            });
        }
        $('#filter').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $('#accreinburst').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                alert('Pilih Tanggal Terlebih Dahulu');
            }
        });
        $('#refresh').click(function () {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#order_table').DataTable().destroy();
            load_data();
        });
    });

</script>
@stop