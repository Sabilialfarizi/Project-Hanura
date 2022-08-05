@extends('layouts.master', ['title' => 'Provinsi'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="page-title">Rekapitulasi Jumlah Anggota Partai Politik


        </h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a style="background-color:#D6A62C; color:#ffff; font-weight:bold;" class="btn float-right"
            href="{{ '/dpp/provinsi/create' }}">
            <i class="fa fa-plus"></i> Add Provinsi
        </a>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('cruds.information.title_singular') }} {{ trans('global.list') }} -->
                <!-- Informasi -->
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="report table table-bordered table-striped table-hover " id="provinsi" width="100%">
                        <thead>
                            <tr style="font-size:12px; text-align:center;">
                                <th width="10">
                                    No.
                                </th>
                                <th>Kode</th>
                                <th>Provinsi</th>
                                <th>Total Kabupaten / Kota</th>
                                <th>Total Anggota</th>
                                <th>Target Anggota</th>
                                <th>Presentase Sisa Anggota</th>
                                <th>Presentase Pencapaian Anggota</th>
                                <th>Download</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($provinsi as $data)
                            <tr style="font-size:12px;">
                                <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                                <td>
                                    <a style="color:#D6A62C; font-weight:bold;"
                                        href="/dpp/provinsi/{{ $data->id_prov }}/showprovinsi">{{ $data->id_prov }}</a>
                                </td>
                                <td> @php
                                    $name = \App\Provinsi::getProv($data->id_prov);
                                    @endphp
                                    {{ $name->name ?? '' }}</td>
                                  <td style="text-align:center">
                                    <a style="color:#D6A62C; font-weight:bold;"
                                        href="{{ route('dpp.provinsi.show', $data->id_prov) }}">{{ \App\Kabupaten::where('id_prov', $data->id_prov)->where('deleted_at', null)->groupBy('id')->get()->count() }}</a>

                                </td>
                                @php
                                $total = \App\DetailUsers::where('detail_users.provinsi_domisili', $data->id_prov)
                                        ->where('detail_users.status_kta', 1)
                                        ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
                                        ->groupBy('detail_users.nik') 
                                        ->get()
                                        ->count();
                                $kantor = \App\Kantor::selectRaw('CAST(target_dpc AS UNSIGNED) AS
                                           target_dpc')->where('provinsi', $data->id_prov)->where('deleted_at',
                                           null)->pluck('target_dpc')->sum();
                                $total_target = $kantor - $total;
                                @endphp
                                <td style="text-align:center">
                                    {{$total}}
                                </td>
                                <td style="text-align:center">
                                    {{ \App\Kantor::selectRaw('CAST(target_dpc AS UNSIGNED) AS target_dpc')->where('provinsi', $data->id_prov)->where('deleted_at', null)->pluck('target_dpc')->sum() }}
                                   
                                </td>
                                <td style="text-align:center; font-size:12px;">
                                    @if($total_target < 0)
                                        0%
                                    @elseif (!empty($kantor))
                                    {{ round( $total_target * 120 / $kantor ) }}%
                                    @else
                                         0%
                                    @endif
                                </td>
                                 <td style="text-align:center; font-size:12px;">
                                     @if($total_target < 0)
                                    100%
                                    @elseif (!empty($kantor))
                                    {{ round( $total * 100 / $kantor ) }}%
                                    @else
                                    0%
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="dropdown">
                                            <button class="btn  dropdown-toggle"
                                                style="margin-left:2px; background-color:#D6A62C; color:white;"
                                                type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                L1-F2 PARPOL
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                    href="/dpp/provinsi/lampiran_parpol/{{ $data->id_prov }}"
                                                    target="_blank">Lampiran 1 Model F2 Parpol</a>
                                                <a class="dropdown-item"
                                                    href="/dpp/provinsi/lampiran_hp_parpol/{{ $data->id_prov }}"
                                                    target="_blank">Lampiran 1 Model F2 HP-Parpol</a>

                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a data-toggle="tooltip" data-placement="top" title="Perbaiki Provinsi"
                                            href="/dpp/provinsi/{{ $data->id }}/edit" class="btn btn-sm btn-warning"
                                            style="margin-left:2px; height:30px;"><i class="fa-solid fa-pen"></i></a>
                                        <form method="post" action="route('dpp.provinsi.destroy', $data->id)">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="'.csrf_token().'">
                                            <button data-toggle="tooltip" data-placement="top" title="Hapus Provinsi"
                                                type="submit" class="btn btn-danger btn-sm"
                                                style="margin-left:2px; height:30px;"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                        <a data-toggle="tooltip" data-placement="top" title="Kantor DPD"
                                            href="/dpp/provinsi/{{ $data->id_prov }}/kantor"
                                            class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i
                                                class="fa-solid fa-building"></i></a>
                                        <a data-toggle="tooltip" data-placement="top" title="Kepengurusan DPD"
                                            href="/dpp/provinsi/{{ $data->id_prov }}/kepengurusan"
                                            class="btn btn-sm btn-secondary" style="margin-left:2px; height:30px;"><i
                                                class="fa-solid fa-person"></i></a>


                                    </div>
                                </td>
                                <!-- anggota per provinsi -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
<style>
    .table.dataTable {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 13px;
    }

    .btn.btn-pdf {
        background-color: #D6A62C;
    }
</style>
@section('footer')
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
        ],
    });
</script>
@stop