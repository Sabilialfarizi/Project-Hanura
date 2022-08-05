@extends('layouts.master', ['title' => 'Show Kabupaten'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-title">Rekap Anggota dan Organisasi</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable report w-100">
                    <thead>
                        <tr style="font-size:12px;">
                            <th rowspan="2" width="10">
                                No.
                            </th>
                            <th rowspan="2">
                                Provinsi
                            </th>
                            <th rowspan="2">Kabupaten</th>
                            <th rowspan="2">Nomor SK</th>
                            <th rowspan="2">Total Anggota</th>
                            <th colspan="3">Kondisi PAC</th>
                            <th rowspan="2">Total Pengurus</th>
                            <th rowspan="2">Keterwakilan Perempuan</th>
                        </tr>
                        <tr>
                            <th>Non Eksis</th>
                            <th>Eksis</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $num = 0;
                            $tmp = 0;
                        @endphp
                        @foreach ($dpc as $val)
                            <tr class="bg-{{ $val->status }}">
                                <td>{{ ++$num }}</td>
                                <td>{{ $val->prov }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->no_sk }}</td>
                                <td>{{ $val->jml_ang }}</td>
                                <td>{{ $val->jml_kab - $val->jml }}</td>
                                <td>{{ $val->jml ?? 0 }}</td>
                                <td>{{ $val->jml_kab }}</td>
                                <td>{{ $val->jml_pengurus }}</td>
                                <td>
                                    {{ $val->jml_pengurus > 0 ? number_format(($val->jml_perempuan / $val->jml_pengurus) * 100, 2, ',', '') : '0,00' }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <style>
        .table.dataTable {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }

        .btn.btn-pdf {
            background-color: #D6A62C;
        }

        .bg-warning,
        .bg-danger {
            color: white !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        $('.report').DataTable({
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
                    title: 'Laporan Provinsi',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-pdf',
                    title: 'Laporan Provinsi ',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-pdf',
                    title: 'Laporan Provinsi ',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },

            ]
        });
    </script>
@stop
