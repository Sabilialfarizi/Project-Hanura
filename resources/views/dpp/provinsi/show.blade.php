@extends('layouts.master', ['title' => 'Show Kabupaten'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h4 class="page-title">Provinsi {{$kabupaten->name}}</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a style="background-color:#D6A62C; color:#ffff; font-weight:bold;" class="btn float-right"
             href="{{ "/dpp/kabupaten/$kabupaten->id_prov/create" }}">
            <i class="fa fa-plus"></i> Add Kabupaten/Kota
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
                        <th>Kabupaten / Kota</th>
                        <th>Total Kecamatan</th>
                        <th>Total Anggota</th>
                        <th>Target Anggota</th>
                        <th>Presentase Sisa Anggota</th>
                        <th>Presentase Pencapaian Anggota</th>
                        <!--<th style="text-align:center;">Download</th>-->
                        <th style="text-align:center;">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($provinsi as $data)
                    <tr style="font-size:12px;">
                        <td style="width: 5%; text-align:center">{{ $loop->iteration }}</td>
                        <td><a style="color:#D6A62C; font-weight:bold;"
                                href="/dpp/provinsi/{{$data->id_kab}}/data">{{$data->id_kab}}</a></td>
                        <td> @php
                            $name = \App\Kabupaten::getKab($data->id_kab)
                            @endphp
                            {{ $name->name ?? '' }}</td>
                        <td><a style="color:#D6A62C; font-weight:bold;"
                                href="/dpp/provinsi/{{$data->id_kab}}/kecamatan">{{ 
                           \App\Kecamatan::where('id_kab', $data->id_kab)->where('deleted_at',null)->groupBy('id')->get()->count()
                           }}</a></td>

                        <td>
                            @php
                            $anggota = DB::table('detail_users')
                                ->where('kabupaten_domisili', $data->id_kab)
                                ->where('status_kta',1)
                                ->where(DB::raw('LENGTH(no_member)'),'>',[18,20])
                                ->groupBy('nik') 
                                ->get()
                                ->count();
                            $kantor = \App\Kantor::where('id_daerah', $data->id_kab)->where('deleted_at',null)->value('target_dpc');
                            $total_target = $kantor - $anggota;
                            @endphp
                            {{$anggota}}
                        </td>
                        
                        <td>
                            
                            {{$kantor ?? '0'}}
                            
                             
                        </td>
                          <td style="text-align:center; font-size:12px;">
                                    @if($total_target < 0)
                                        0%
                                    @elseif (!empty($kantor))
                                    {{ round( $total_target * 100 / $kantor ) }}%
                                    @else
                                         0%
                                    @endif
                        </td>
                        <td style="text-align:center; font-size:12px;">
                                     @if($total_target < 0)
                                    100%
                                    @elseif (!empty($kantor))
                                    {{ round( $anggota * 120 / $kantor ) }}%
                                    @else
                                    0%
                                    @endif
                             </td>
                        
                        <!--<td>-->
                            
                            <!--

                            <div class="d-flex justify-content-center">
                                
                                <a href="{{($anggota > 0) ? '/dpp/kabupaten/zip/' . $data->id_kab : 'javascript:void(0)'}}" {{($anggota > 0) ? 'target="_blank"' : 'disabled'}} class="btn" style="background-color:#D6A62C; color:#ffff;">FOLDER KTA & KTP (ZIP)</a>
                             
                                
                                   <a href="{{($anggota > 0) ? '/dpp/kabupaten/zip/showkta/' . $data->id_kab : 'javascript:void(0)'}}" {{($anggota > 0) ? 'target="_blank"' : 'disabled'}} class="btn" style="background-color:#D6A62C; color:#ffff;">FOLDER KTA & KTP (ZIP)</a>
                                
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle"
                                        style="margin-left:2px; background-color:#D6A62C; color:white;" type=" button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        L2-F2 PARPOL
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/dpp/provinsi/export_parpol/{{$data->id_kab}}"
                                            target="_blank">Lampiran 2 Model F2 Parpol</a>
                                        <a class="dropdown-item" href="/dpp/provinsi/export_hp_parpol/{{$data->id_kab}}"
                                            target="_blank">Lampiran 2 Model F2 HP-Parpol</a>

                                    </div>
                                </div>
                                
                                <div class="dropdown">
                                    <button class="btn  dropdown-toggle"
                                        style="margin-left:2px; background-color:#D6A62C; color:white;" type=" button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Daftar Anggota Template KPU
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/dpp/kabupaten/export/{{$data->id_kab}}">Daftar
                                            Anggota Template KPU</a>
                                        <a class="dropdown-item"
                                            href="/dpp/kabupaten/export_hp/{{$data->id_kab}}">Daftar
                                            Anggota Template KPU (HP)</a>

                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn  dropdown-toggle"
                                        style="margin-left:2px; background-color:#D6A62C; color:white;" type=" button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        KTA & KTP
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/dpp/kabupaten/{{$data->id_kab}}/show"
                                            target="_blank">KTA & KTP</a>
                                        <a class="dropdown-item" href="/dpp/kabupaten/{{$data->id_kab}}/show_hp"
                                            target="_blank">KTA & KTP (HP)</a>

                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn  dropdown-toggle"
                                        style="margin-left:2px; background-color:#D6A62C; color:white;" type=" button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        KTA
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/dpp/kabupaten/{{$data->id_kab}}/showkta" 
                                            target="_blank">KTA</a>
                                        <a class="dropdown-item" href="/dpp/kabupaten/{{$data->id_kab}}/showkta_hp" 
                                            target="_blank">KTA (HP)</a>
                                    </div>
                                </div>
                            </div>
                            
                            -->
                        <!--</td>-->
                        <td>
                            <div class="d-flex justify-content-center">
                                 <a data-toggle="tooltip" data-placement="top" title="Perbaiki Kabupaten"href="/dpp/kabupaten/{{$data->id}}/edit" class="btn btn-sm btn-warning"  style="margin-left:2px; height:30px;"><i class="fa-solid fa-pen"></i></a>
                                 <form action="{{ route('dpp.kabupaten.destroy', $data->id) }}"
                                        class="delete-form"  style="display: inline-block;" method="post">
                                        @csrf
                                        @method('delete')
                                        <button data-toggle="tooltip" data-placement="top"   style="margin-left:2px; height:30px;" title="Hapus Kabupaten"type="submit" class="btn btn-sm btn-danger mr-2"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                 
                                                <a data-toggle="tooltip" data-placement="top" title="Kantor DPC"
                                    href="/dpd/kabupaten/{{$data->id_kab}}/kantor"
                                    class="btn btn-sm btn-secondary mr-2"><i class="fa-solid fa-building"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="Kepengurusan DPC"
                                    href="/dpd/kabupaten/{{$data->id_kab}}/kepengurusan"
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
            // {
            //     text: 'Lampiran 1 Model F2 Parpol',
            //     action: function (e, dt, button, config) {
            //         window.open('/dpp/provinsi/lampiran_parpol/{{ $kabupaten->id_prov }}', "_blank")

            //     }
            // },
            // {
            //     text: 'Lampiran 1 Model F2.HP-Parpol',
            //     action: function (e, dt, button, config) {
            //         window.open('/dpp/provinsi/lampiran_hp_parpol/{{ $kabupaten->id_prov }}', "_blank")


            //     }
            // },
        ],
    });
</script>
@stop