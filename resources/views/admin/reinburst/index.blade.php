@extends('layouts.master', ['title' => 'Reinburst'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Reinburst</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        <a href="{{ route('purchasing.reinburst.create') }}" class="btn btn btn-primary btn-rounded float-right"><i
                class="fa fa-plus"></i> Add Reinburst</a>
    </div>
</div>
<x-alert></x-alert>
<br />
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
        <div class="form-group form-focus">
        <button type="button" name="filter" id="filter" class="btn btn-primary">Search</button>
    </div>
   
</div>
<br />
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table report" id="reinburst" width="100%">
                <thead>
                    <tr>
                        <th  style="width:5%;">No</th>
                        <th style="width:10%;">Nomor Reinburst</th>
                        <th style="width:10%;">Tanggal Reinburst</th>
                        <th style="width:5%;">Total Item</th>
                        <th style="width:5%;">Total Pembelian</th>
                        <th style="width:10%;">Status Hrd</th>
                        <th style="width:10%;">Status Pembayaran</th>
                        <th style="width:10%;">Action</th>
                    </tr>
                </thead>
                {{-- @foreach($reinbursts as $reinburst)
                <tbody>
                  
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                <td><a
                        href="{{ route('purchasing.reinburst.show', $reinburst->id) }}">{{ $reinburst->nomor_reinburst }}</a>
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

                    <a href="{{ route('purchasing.reinburst.edit', $reinburst->id) }}" class="btn btn-sm btn-info"><i
                            class="fa fa-edit"></i></a>

                    <form action="{{ route('purchasing.reinburst.destroy', $reinburst->id) }}" method="post"
                        style="display: inline;" class="delete-form">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
                </tr>
                @endforeach
                </tbody>--}}
                <tfoot>
                    <tr>
                        <td>Total : </td>
                        <td colspan="2"></td>
                        <td>{{ request('from') && request('to') ? \App\Reinburst::whereBetween('tanggal_reinburst', [Carbon\Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d'), Carbon\Carbon::createFromFormat('d/m/Y', request('to'))->format('Y-m-d')])->where('id_user',auth()->user()->id)->get()->count() : \App\Reinburst::where('id_user', auth()->user()->id)->get()->count() }}
                        </td>
                        <td>@currency( request('from') && request('to') ?
                            \App\RincianReinburst::whereBetween('created_at',
                            [Carbon\Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d'),
                            Carbon\Carbon::createFromFormat('d/m/Y',
                            request('to'))->format('Y-m-d')])->where('id_user',auth()->user()->id)->sum('harga_beli')
                            : \App\RincianReinburst::where('id_user',auth()->user()->id)->get()->sum('harga_beli'))
                        </td>
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
        $('#reinburst thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#reinburst thead');

        load_data();


        function load_data(from = '', to = '') {

            var table = $('#reinburst').DataTable({
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
                        title: 'Laporan Reinburst',
                        messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Laporan Reinburst',
                        messageTop: 'Tanggal {{ request("from") }} - {{ request("to") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        title: 'Laporan Reinburst',
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
                            $(cell).html('<input type="text" placeholder="' + title +
                                '" style="width:70%;" />');

                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header())
                                        .index())
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
                    url: '/admin/ajax/ajax_reinburst',
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
                    },
                    {
                        data: 'status_pembayaran',
                        name: 'status_pembayaran'
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
                $('#reinburst').DataTable().destroy();
                load_data(from, to);
            } else {
                alert('Pilih Tanggal Terlebih Dahulu');
            }
        });
        $('#refresh').click(function () {
            $('#from').val('');
            $('#to').val('');
            $('#reinburst').DataTable().destroy();
            load_data();
        });
    });

</script>
@stop
