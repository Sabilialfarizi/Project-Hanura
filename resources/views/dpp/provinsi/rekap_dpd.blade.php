@extends('layouts.master', ['title' => 'Show Kabupaten'])

@section('content')
    <div class="row">
        <div class="col-md-4">
            <h4 class="page-title">Daftar DPD</h4>
        </div>

        <div class="col-sm-8 text-right m-b-20">

        </div>
    </div>

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>DPD Eksis</h5>
                    <h2>{{ $sk_yes }} DPD</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>DPD Non Eksis</h5>
                    <h2>{{ $sk_no }} DPD</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Total DPD</h5>
                    <h2>{{ $count }} DPD</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">

            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable report">
                    <thead>
                        <tr style="font-size:12px;">
                            <th width="10">
                                No.
                            </th>
                            <th>Provinsi</th>
                            <th>Nomor SK</th>
                            <th>Alamat</th>
                            <th>DPC Non Eksis</th>
                            <th>DPC Eksis</th>
                            <th>Total DPC</th>
                            <th>Total Pengurus</th>
                            <th>Keterwakilan Perempuan</th>
                            <th>Status Kantor</th>
                            <th>Batas Sewa</th>
                            <th>Nomor Rekening</th>
                            <th style="text-align:center;">Download SK</th>
                            <th style="text-align:center;">Download Domisili</th>
                            <th style="text-align:center;">Download Surat Ket Kantor</th>
                            <th style="text-align:center;">Download Rekening Bank</th>
                            <th style="text-align:center;">Download All</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dpd as $data)
                            <tr style="font-size:13px;">
                                <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                                <td>
                                    {{ $data->name }}
                                </td>
                                <td>
                                    {{ is_null($data->no_sk) ? '-' : $data->no_sk }}
                                </td>
                                <td>
                                    {{ is_null($data->alamat) ? '-' : $data->alamat }}
                                </td>

                                <td>
                                    <a style="color:#D6A62C; font-weight:bold;"
                                        href="{{ route('dpp.rekap.dpc.type', ['id' => $data->id_prov, 'type' => 0]) }}">{{ $data->jml_kab - $data->jml }}</a>
                                </td>
                                <td>
                                    <a style="color:#D6A62C; font-weight:bold;"
                                        href="{{ route('dpp.rekap.dpc.type', ['id' => $data->id_prov, 'type' => 1]) }}">{{ is_null($data->jml) ? 0 : $data->jml }}</a>
                                </td>
                                <td>
                                    <a style="color:#D6A62C; font-weight:bold;"
                                        href="{{ route('dpp.rekap.dpc', $data->id_prov) }}">{{ is_null($data->jml_kab) ? 0 : $data->jml_kab }}</a>
                                </td>
                                <td>
                                    {{ $data->jml_pengurus > 0 ? $data->jml_pengurus : 0 }}
                                </td>
                                <td>
                                    {{ $data->jml_pengurus > 0 ? number_format(($data->jml_perempuan / $data->jml_pengurus) * 100, 2, ',', '') : '0,00' }}%
                                </td>
                                <td>
                                    @if ($data->status_kantor == 1)
                                        Milik Sendiri
                                    @elseif($data->status_kantor == 2)
                                        Sewa
                                    @elseif($data->status_kantor == 3)
                                        Pinjam Pakai
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    {{ $data->status_kantor != 2 && !is_null($data->tgl_selesai) ? Carbon\carbon::parse($data->tgl_selesai)->Format('d-m-Y') : '-' }}
                                </td>
                                <td>{{ $data->nomor_rekening ?? '-' }}</td>
                                @php $stat = false; @endphp
                                <td>
                                    @if (is_null($data->file_sk) || $data->file_sk == '')
                                        -
                                    @else
                                        <a class="btn btn-sm" style="background-color:#D6A62C; color:#ffff;"
                                            @php $stat = true; @endphp href="{{ route('dpp.download.sk', $data->id_kantor) }}"
                                            target="_blank">Download
                                            SK</a>
                                    @endif
                                </td>
                                <td>
                                    @if (is_null($data->domisili) || $data->domisili == '')
                                        -
                                    @else
                                        <a class="btn btn-sm" style="background-color:#D6A62C; color:#ffff;"
                                            @php $stat = true; @endphp
                                            href="{{ route('dpp.download.domisili', $data->id_kantor) }}"
                                            target="_blank">Download
                                            Domisili</a>
                                    @endif
                                </td>
                                <td>
                                    @if (is_null($data->skk) || $data->skk == '')
                                        -
                                    @else
                                        <a class="btn btn-sm" style="background-color:#D6A62C; color:#ffff;"
                                            @php $stat = true; @endphp href="{{ route('dpp.download.skk', $data->id_kantor) }}"
                                            target="_blank">Download
                                            Surat Keterangan Kantor</a>
                                    @endif
                                </td>
                                <td>
                                    @if (is_null($data->rekening_bank) || $data->rekening_bank == '')
                                        -
                                    @else
                                        <a class="btn btn-sm" style="background-color:#D6A62C; color:#ffff;"
                                            @php $stat = true; @endphp
                                            href="{{ route('dpp.download.rekening_bank', $data->id_kantor) }}"
                                            target="_blank">Download
                                            Rek Bank</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($stat)
                                        <a class="btn btn-sm" style="background-color:#D6A62C; color:#ffff;"
                                            href="{{ route('dpp.download.all', $data->id_kantor) }}"
                                            target="_blank">Download All</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <!-- anggota per provinsi -->
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
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        $('.report').DataTable({
            "dom": "<'row'<'col-sm-4' l><'col-sm-4'B><'col-sm-4'f>>" +
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
