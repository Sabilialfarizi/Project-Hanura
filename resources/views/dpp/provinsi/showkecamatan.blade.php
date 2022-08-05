@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h4 class="page-title">

                Provinsi : <span style="font-weight:bold;">{{ $provinsi->name }}</span> <br>Kabupaten / Kota : <span
                    style="font-weight:bold;">{{ $detail->name }}</span></h4>
        </div>

        <div class="col-sm-8 text-right m-b-20">

        </div>
    </div>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a style="background-color:#D6A62C; color:#ffff; font-weight:bold;" class="btn float-right"
                href="{{ "/dpp/kecamatan/$detail->id_kab/create" }}">
                <i class="fa fa-plus"></i> Add Kecamatan
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable report">
                    <thead>
                        <tr style="font-size:12px;">
                            <th width="10">
                                No.
                            </th>
                            <th>Kode</th>
                            <th>Kecamatan</th>
                            <th>Total Kelurahan / Desa</th>
                            <th>Total Anggota</th>
                            <th style="text-align:center;">BT</th>
                            <th style="text-align:center;">ST</th>
                            <th style="text-align:center;">HP</th>
                            <th style="text-align:center;">TMS</th>
                            <th style="text-align:center;">Generate KTA</th>
                            <!--<th>Total Pengurus</th>-->
                            <th style="text-align:center;">Download</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kecamatan as $data)
                            <tr style="font-size:12px;">
                                <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                                <td><a style="color:#D6A62C; font-weight:bold;"
                                        href="/dpp/provinsi/{{ $data->id_kec }}/kecamatan/data">{{ $data->id_kec }}</a>
                                </td>
                                <td> @php
                                    $name = \App\Kecamatan::getKec($data->id_kec);
                                @endphp
                                    {{ $name->name ?? '' }}</td>
                                <td>
                                    <a style="color:#D6A62C; font-weight:bold;"
                                        href="/dpp/provinsi/{{ $data->id_kec }}/kelurahan">{{ \App\Kelurahan::where('id_kec', $data->id_kec)->groupBy('id')->get()->count() }}</a>
                                </td>
                                <td>
                                    @php
                                        $anggota = \App\DetailUsers::where('detail_users.kecamatan_domisili', $data->id_kec)
                                            ->where('detail_users.status_kta', 1)
                                            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                                            ->groupBy('detail_users.nik');
                                        $siap = $anggota->get()->count();
                                     @endphp
                                    {{ $siap }}
                                </td>
                                <td>
                                    @php
                                    $belum = \App\DetailUsers::where('detail_users.kecamatan_domisili', $data->id_kec)
                                        ->where('detail_users.status_kta', 1)
                                        ->where('detail_users.status_kpu', 1)
                                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                                        ->groupBy('detail_users.nik')
                                        ->get()
                                        ->count();
                                    $sudah = \App\DetailUsers::where('detail_users.kecamatan_domisili', $data->id_kec)
                                        ->where('detail_users.status_kta', 1)
                                        ->where('detail_users.status_kpu', 2)
                                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                                        ->groupBy('detail_users.nik')
                                        ->get()
                                        ->count();
                                    $hs = \App\DetailUsers::where('detail_users.kecamatan_domisili', $data->id_kec)
                                        ->where('detail_users.status_kta', 1)
                                        ->where('detail_users.status_kpu', 4)
                                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                                        ->groupBy('detail_users.nik')
                                        ->get()
                                        ->count();
                                    $tms = \App\DetailUsers::where('detail_users.kecamatan_domisili', $data->id_kec)
                                        ->where('detail_users.status_kta', 1)
                                        ->where('detail_users.status_kpu', 5)
                                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                                        ->groupBy('detail_users.nik')
                                        ->get()
                                        ->count();
                                    $generate = \App\DetailUsers::where('detail_users.kecamatan_domisili', $data->id_kec)
                                        ->where('detail_users.status_kta', 1)
                                        ->where('detail_users.status_generate', 2)
                                        ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                                        ->groupBy('detail_users.nik')
                                        ->get()
                                        ->count();
                                    @endphp
                                     <div class="d-flex justify-content-center">
                                        <a>{{$belum}}</a>
                                     </div>
                                </td>
                                
                                     
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a>{{$sudah}}</a>
                                     </div>
                                    
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a>{{$hs}}</a>
                                     </div>
                                    
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a>{{$tms}}</a>
                                     </div>
                                    
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a style="color:#D6A62C; font-weight:bold;"
                                        href="/dpp/provinsi/{{ $data->id_kab }}/kecamatan/{{$data->id_kec}}/generated">{{ $generate }}</a>
                                        
                                     </div>
                                    
                                </td>
                                        
                                <!--<td>-->
                                <!--    {{ \App\Kepengurusan::where('id_daerah', $data->id_kec)->where('deleted_at', null)->get()->count() }}-->
                                <!--</td>-->
                                <td>
                                    <div class="d-flex justify-content-center">
                                        
                                        
                                        <!--<a href="{{ $siap > 0 ? '/dpp/kecamatan/zip/' . $data->id_kec : 'javascript:void(0)' }}"-->
                                        <!--    {{ $siap > 0 ? 'target="_blank"' : 'disabled' }} class="btn"-->
                                        <!--    style="background-color:#D6A62C; color:#ffff;">FOLDER KTA & KTP (ZIP)</a>-->
                                            
                                     
										<button data-id="{{$data->id_kec}}" class="btn export_kec_kta_ktp" style="background-color:#D6A62C; color:#ffff;">FOLDER KTA & KTP (ZIP)</button>
                                        
                                             @if (!file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/ktp-kta-zip/'. $data->id_prov . '_' . $data->id_kab . '_' . $data->id_kec . '_' . strtoupper($data->name) . '.zip'))
                                        <a 
                                            target="_blank" class="btn" disabled
                                            style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download All
                                            (ZIP) A
                                        </a>
                                        @else
                                        <a 
                                            href="{{ route('dpp.kelurahan.cetak.zip', ['id' => $data->id_kab, 'id_kec' => $data->id_kec]) }}"
                                            target="_blank" class="btn"
                                            style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download All
                                            (ZIP) A
                                        </a>
                                        @endif
                                        @if (!file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/ktp-kta-zip/'. $data->id_prov . '_' . $data->id_kab . '_' . $data->id_kec . '_' . strtoupper($data->name) . '.zip'))
                                        <a 
                                            target="_blank" class="btn" disabled
                                            style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download
                                            (ZIP) M
                                        </a>
                                        @else
                                        <a  href="{{ route('dpp.manual.cetak.zip', ['id' => $data->id_kab, 'id_kec' => $data->id_kec]) }}"
                                            target="_blank" class="btn"
                                            style="margin-left: 2px;background-color:#D6A62C; color:#ffff;">Download
                                            (ZIP) M
                                        </a>
                                        @endif
                                       
                                    </div>
                                    
                                      
                                    <!--<div class="dropdown">-->
                                    <!--        <button class="btn  dropdown-toggle"-->
                                    <!--            style="margin-left:2px; background-color:#D6A62C; color:white;"-->
                                    <!--            type="button" id="dropdownMenuButton" data-toggle="dropdown"-->
                                    <!--            aria-haspopup="true" aria-expanded="false">-->
                                    <!--            Template kpu - Kecamatan-->
                                    <!--        </button>-->
                                    <!--        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
                                    <!--            <a class="dropdown-item"-->
                                    <!--                href="/dpp/kecamatan/export_parpol/{{ $data->id_kec }}">Template kpu-->
                                    <!--                --->
                                    <!--                Kecamatan</a>-->
                                    <!--            <a class="dropdown-item"-->
                                    <!--                href="/dpp/kecamatan/export_hp_parpol/{{ $data->id_kec }}">Template-->
                                    <!--                kpu-->
                                    <!--                --->
                                    <!--                Kecamatan HP</a>-->

                                    <!--        </div>-->
                                    <!--    </div>-->
                                        
                                       
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kecamatan"
                                            href="/dpp/kecamatan/{{ $data->id }}/edit" class="btn btn-sm btn-warning"
                                            style="margin-left:2px; height:30px;"><i class="fa-solid fa-pen"></i></a>
                                        <form action="{{ route('dpp.kecamatan.destroy', $data->id) }}"
                                            class="delete-form" style="display: inline-block;" method="post">
                                            @csrf
                                            @method('delete')
                                            <button data-toggle="tooltip" data-placement="top"
                                                style="margin-left:2px; height:30px;" title="Hapus Kecamatan"type="submit"
                                                class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>

                                        <a data-toggle="tooltip" data-placement="top" style="margin-left:2px; height:30px;"
                                            title="Kantor PAC" href="/dpp/kecamatan/{{ $data->id_kec }}/kantor"
                                            class="btn btn-sm btn-secondary"><i class="fa-solid fa-building"></i></a>
                                        <a data-toggle="tooltip" data-placement="top"
                                            style="margin-left:2px; height:30px;"title="Kepengurusan PAC"
                                            href="/dpp/kecamatan/{{ $data->id_kec }}/kepengurusan"
                                            class="btn btn-sm btn-secondary"><i class="fa-solid fa-person"></i></a>
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
                    title: 'Laporan Kecamatan',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-pdf',
                    title: 'Laporan Kecamatan ',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-pdf',
                    title: 'Laporan Kecamatan ',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
            ],
        });
    $('.report tbody').on('click', '.export_kec_kta_ktp', function () {
        $.ajax({
            url: '{{route('dpp.exports.store')}}',
            method: 'POST',
            dataType: 'json',
            data: {district_id:$(this).attr("data-id")},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.errors == undefined) {
                    alert(response.message);
                    if(response.status == true){
                        window.location.href = '{{route('dpp.exports.index')}}';
                    }
                } else {
                    alert(response.errors.join(','));
                }
            },
        });
    });
    </script>
@stop
