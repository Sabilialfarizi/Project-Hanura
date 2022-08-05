@extends('layouts.master', ['title' => 'Pengajian'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Penggajian</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">

        <a href="{{ route('hrd.gaji.create') }}" class="btn btn btn-primary btn-rounded float-right"><i
                class="fa fa-plus"></i> Add Penggajian</a>

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
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table report" id="gaji"style="width:125%;">
                <thead>
                    <tr >
                        <th style="width: 5%;">No</th>
                        <th style="width: 5%;">Pegawai </th>
                        <th style="width: 5%;">Tanggal</th>
                        <th style="width: 5%;">Bulan&Tahun</th>
                        <th style="width: 10%;">Gaji Pokok</th>
                        <th style="width: 10%;">Penerimaan</th>
                        <th style="width: 10%;">Potongan</th>
                        <th style="width: 10%;">Total</th>
                        <th style="width: 5%;">Jabatan</th>
                        <th style="width: 5%;">Divisi</th>
                        <th style="width: 5%;">Admin</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                @php
                $array_gaji_pokok = [];
                $array_penerimaan = [];
                $array_potongan = [];
                $array_total = [];
                @endphp
                <tbody>
                    @foreach($penggajians as $data)
                    <tr style="font-size: 12px">
                        <td>{{ $loop->iteration }}</td>
                        {{-- <td>
                            <div class="btn-group">
                                <a href="{{ route('hrd.gaji.print',$data->id) }}"
                        class="btn btn-sm btn-secondary">print</a>
                        <a href="{{ route('hrd.gaji.show',$data->id) }}" class="btn btn-sm btn-success">Rincian</a>
                        <a href="{{ route('hrd.gaji.edit',$data->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('hrd.gaji.destroy', $data->id) }}" class="delete-form" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger delete_confirm" type="submit">Delete</button>
                        </form>
        </div>
        </td> --}}
        </tr>
        @php
        array_push($array_gaji_pokok, $data->gaji_pokok);
        array_push($array_penerimaan, $data->penerimaan->sum('nominal') - $data->gaji_pokok);
        array_push($array_potongan, $data->potongan->sum('nominal'));
        array_push($array_total, $data->gaji_pokok + (($data->penerimaan->sum('nominal') -
        $data->gaji_pokok) - $data->potongan->sum('nominal')));
        @endphp
        @endforeach
        </tbody>
        <tfoot>
            <tr style="font-size: 12px">
                <th colspan="4">Total</th>
                <th>{{ number_format(array_sum($array_gaji_pokok)) }}</th>
                <th>{{ number_format(array_sum($array_penerimaan)) }}</th>
                <th>{{ number_format(array_sum($array_potongan)) }}</th>
                <th>{{ number_format(array_sum($array_total)) }}</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

        </tfoot>
        </table>

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
        $('#gaji thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#gaji thead');
        load_data();


        function load_data(from_date = '', to_date = '') {

            var table = $('#gaji').DataTable({
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
                        title: 'Laporan Penggajian ',
                        messageTop: 'Tanggal  {{ request("start") }} - {{ request("end") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Laporan Penggajian ',
                        messageTop: 'Tanggal {{ request("start") }} - {{ request("end") }}',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        title: 'Laporan Penggajian ',
                        messageTop: 'Tanggal {{ request("start") }} - {{ request("end") }}',
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
                            $(cell).html('<input type="text" placeholder="' + title + '"  style="width:100%;"/>');

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
                    url: '/admin/ajax/ajax_gaji',
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
                        data: 'pegawai',
                        name: 'pegawai'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'bulan_tahun',
                        name: 'bulan_tahun'
                    },
                    {
                        data: 'gaji_pokok',
                        name: 'gaji_pokok',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp.')
                    },
                    {
                        data: 'penerimaan',
                        name: 'penerimaan',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp.')
                    },
                    {
                        data: 'potongan',
                        name: 'potongan',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp.')
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp.')
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'divisi',
                        name: 'divisi'
                    }, {
                        data: 'admin',
                        name: 'admin'
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
                $('#gaji').DataTable().destroy();
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
