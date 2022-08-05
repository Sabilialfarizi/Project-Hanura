@extends('layouts.master', ['title' => 'Kabupaten'])

@php
    $ketum;
    $sekjen;
    $bendahara;
    
    if($kepengurusan ?? ''){
        foreach ($kepengurusan ?? '' as $data) {
            if($data->jabatan == 1001) {
                $ketum = $data->nama;
            }
            
            if($data->jabatan == 1101) {
                $sekjen = $data->nama;
            }
    
            if($data->jabatan == 1201) {
                $bendahara = $data->nama;
            }
        }
    }
@endphp

@section('content')
<div class="row">
    <div class="col-md-4">
        <h4 class="page-title">Settings </h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover report" id="kabupaten" width="100%">
                        <thead>
                            <tr style="font-size:16px; text-align:center;">
                                <th width="10">
                                    No.
                                </th>
                                <th width="20">Ketua Umum</th>
                                <th width="20">Sekretaris Jendral</th>
                                <th width="20">Bendahara Umum</th>
                                <th width="20">Alamat</th>
                                <th width="20">No. Telepon</th>
                                <th width="20">Email</th>
                                <th width="20">Fax</th>
                                <th width="20">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td style="width: 20%">{{ $ketum ?? ''}}</td>
                                <td style="width: 20%">{{ $sekjen ?? '' }}</td>
                                <td style="width: 20%">{{ $bendahara ?? ''}}</td>
                                <td style="width: 20%">{{ $kantor->alamat ?? ''}}</td>
                                <td style="width: 20%">{{ $kantor->no_telp ?? ''}}</td>
                                <td style="width: 20%">{{ $kantor->email ?? ''}}</td>
                                <td style="width: 20%">{{ $kantor->fax ?? ''}}</td>
                                <td style="width: 20%">
                                    <div class="d-flex">
                                        <a data-toggle="tooltip" data-placement="top" title="Kantor Pusat" href="{{ "/dpp/settings/kantor" }}" class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-building"></i></a>
                                        <a data-toggle="tooltip" data-placement="top" title="Kepengurusan Pusat" href="{{ route('dpp.settings.kepengurusan.index') }}"class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-person"></i></a>
                                        <a data-toggle="tooltip" data-placement="top" title="Tentang Hanura" href="{{ route('dpp.about.index') }}"class="btn btn-sm btn-secondary"><i class="fa-solid fa-house"></i></a>
                                    </div>
                                </td>
                            </tr>
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
                        title: 'Laporan kabupaten',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Laporan kabupaten ',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        title: 'Laporan kabupaten ',
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

    });

</script>
@stop
