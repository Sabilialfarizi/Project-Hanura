@extends('layouts.master', ['title' => 'Pengajuan Dana'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Pengajuan Dana</h1>
    </div>
    @can('pengajuan-create')
    <div class="col-sm-8 text-right m-b-20">
        <a href="{{ route('hrd.pengajuan.create') }}" class="btn btn btn-primary btn-rounded float-right"><i
                class="fa fa-plus"></i> Add Pengajuan</a>
    </div>
    @endcan
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
            <table class="table table-bordered table-striped custom-table report" id="pengajuan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="width: 20%;">No Pengajuan</th>
                        <th style="width: 20%;">Perusahaan</th>
                        <th >Tanggal</th>
                        <th >Divisi</th>
                        <th >Nama</th>
                        <th >Total Item</th>
                        <th style="width: 20%;">Total Pembelian</th>
                        <th >Status</th>
                        <th >Action</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <td>Total : </td>
                        <td colspan="5"></td>
                        <td>{{ request('from') && request('to') ? \App\Pengajuan::whereBetween('tanggal_pengajuan', [Carbon\Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d'), Carbon\Carbon::createFromFormat('d/m/Y', request('to'))->format('Y-m-d')])->where('id_user',auth()->user()->id)->get()->count() : \App\Pengajuan::where('id_user',auth()->user()->id)->get()->count() }}
                        </td>
                        <td>@currency( request('from') && request('to') ?
                            DB::table('rincian_pengajuans')->whereBetween('tanggal_pengajuan',
                            [Carbon\Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d'),
                            Carbon\Carbon::createFromFormat('d/m/Y',
                            request('to'))->format('Y-m-d')])->where('id_user',auth()->user()->id)->groupBy('nomor_pengajuan')->get()->sum('grandtotal')
                            :
                            DB::table('rincian_pengajuans')->where('id_user',auth()->user()->id)->groupBy('nomor_pengajuan')->get()->sum('grandtotal')
                            )</td>
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
    $('.delete-form').on('click', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Delete this data ?',
            text: "Are you sure you want to delete this data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                return form.submit();
            }
        })
    });
</script>
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
        $('#pengajuan thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#pengajuan thead');
        load_data();



        function load_data(from_date = '', to_date = '') {
            var table = $('#pengajuan').DataTable({
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
                        title: 'Laporan Pengajuan',
                        messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Laporan Pengajuan ',
                        messageTop: 'Tanggal {{ request("from") }} - {{ request("to") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        title: 'Laporan Pengajuan ',
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
                    url: '/admin/ajax/ajax_pengajuan',
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
                        data: 'no_pengajuan',
                        name: 'no_pengajuan'
                    },
                    {
                        data: 'perusahaan',
                        name: 'perusahaan'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'divisi',
                        name: 'divisi'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },


                ],


            });
        }
        $('#filter').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $('#pengajuan').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                alert('Pilih Tanggal Terlebih Dahulu');
            }
        });
        $('#refresh').click(function () {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#pengajuan').DataTable().destroy();
            load_data();
        });

    });

</script>
@stop
