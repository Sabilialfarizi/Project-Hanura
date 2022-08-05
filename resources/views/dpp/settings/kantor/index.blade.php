@extends('layouts.master', ['title' => 'Provinsi'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h4 class="page-title">Kantor Pusat</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>
<style>
    .click-zoom input[type=checkbox] {
        display: none
    }

    .click-zoom img {
        transition: transform 0.25s ease;
        cursor: zoom-in
    }

    .click-zoom input[type=checkbox]:checked~img {
        transform: scale(3);
        cursor: zoom-out
    }

</style>
<x-alert></x-alert>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('cruds.information.title_singular') }} {{ trans('global.list') }} -->
                <!-- Informasi -->
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="report table table-bordered table-striped table-hover datatable" id="provinsi" width="100%">
                        <thead>
                            <tr style="font-size:16px;">
                                <th width="10">
                                    No.
                                </th>
                                <th>Alamat</th>
                                <th>Provinsi</th>
                                <th>Kab/Kota</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>RT/RW</th>
                                <th>Kode Pos</th>
                                <th>No. Telp</th>
                                <th>WhatsApp Kantor</th>
                                <th>Fax</th>
                                <th>Email</th>
                                <th>Koordinat</th>
                               <th>SK. Kemenkumham</th>
                                <th>Domisili</th>
                                <th>Surat Keterangan Kantor</th>
                                <th>Rekening Bank</th>
                                <th>Akta Pendirian</th>
                                <th>Cap Kantor</th>
                                <th>Status Kantor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($kantor == null)
                                <tr>
                                    <td colspan="19" class="text-center">Belum Ada Data</td>
                                    <td>
                                        <a href="{{ route('dpp.settings.kantor.create') }}" class="btn btn-sm btn-primary">Tambah</a>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>1</td>
                                    <td>{{ $kantor->alamat ?? '-' }}</td>
                                    <td>{{ $kantor->getProvinsi->name }}</td>
                                    <td>{{ $kantor->kabupaten->name }}</td>
                                    <td>{{ $kantor->kecamatan->name }}</td>
                                    <td>{{ $kantor->kelurahan->name }}</td>
                                    <td>{{ $kantor->rt_rw ?? '-' }}</td>
                                    <td>{{ $kantor->kode_pos ?? '-' }}</td>
                                    <td>{{ $kantor->no_telp ?? '-'}}</td>
                                    <td>{{ $kantor->wa_kantor ?? '-' }}</td>
                                    <td>{{ $kantor->fax ?? '-' }}</td>
                                    <td>{{ $kantor->email ?? '-' }}</td>
                                    <td>{{ $kantor->koordinat ?? '-' }}</td>
                                     <td>
                                    @if(!empty($kantor->no_sk))
                                    <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                         href="{{asset('/uploads/file/no_sk/'.$kantor->no_sk)}}"
                                       >Download SK.
                                        Kemenkumham</a>
                                    @else
                                    <a style="font-size:14px;">Belum Upload SK. Kemenkumham</a>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($kantor->domisili))
                                    <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                    href="{{asset('/uploads/file/domisili/'.$kantor->domisili)}}"
                                      >Download
                                        Domisili</a>
                                    @else
                                    <a style="font-size:14px;">Belum Upload Domisili</a>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($kantor->surat_keterangan_kantor))
                                    <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                    href="{{asset('/uploads/file/surat_keterangan_kantor/'.$kantor->surat_keterangan_kantor)}}"
                                        >Download Surat
                                        Keterangan Kantor</a>
                                    @else
                                    <a style="font-size:14px;">Belum Upload Surat Keterangan Kantor</a>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($kantor->rekening_bank))
                                    <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                    href="{{asset('/uploads/file/rekening_bank/'.$kantor->rekening_bank)}}"
                                        >Download
                                         Rekening Bank</a>
                                    @else
                                    <a style="font-size:14px;">Belum Upload Rekening Bank</a>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($kantor->akta_pendirian))
                                    <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                      href="{{asset('/uploads/file/akta_pendirian/'.$kantor->akta_pendirian)}}">Download
                                         Akta Pendirian</a>
                                    @else
                                    <a style="font-size:14px;">Belum Upload  Akta Pendirian</a>
                                    @endif
                                </td>
                                

                                <td>
                                    @if(!empty($kantor->cap_kantor))
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="{{ asset('uploads/img/cap_kantor/'.($kantor->cap_kantor)) }}"
                                                alt='noimage' width='50px' height='30px'>
                                        </label>
                                    </div>
                                    @else
                                    <a style="font-size:14px;">Belum Upload Cap Kantor</a>
                                    @endif
                                </td>
                                    <td>{{ $kantor->is_active === 1 ? 'Aktif' : 'Tidak Aktif'  }}</td>
                                    <td>
                                        <a  style="background-color:#D6A62C; color:#FFFF;" href="{{ route('dpp.settings.kantor.edit') }}" class="btn btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @endif
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
@stop
