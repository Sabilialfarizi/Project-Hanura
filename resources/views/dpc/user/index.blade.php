@extends('layouts.master')

@section('content')
<style>
    .click-zoom input[type=checkbox] {
        display: none
    }

    .click-zoom img {
        transition: transform 0.25s ease;
        cursor: zoom-in
    }

    .click-zoom input[type=checkbox]:checked~img {
        transform: scale(2);
        cursor: zoom-out
    }
</style>
<div class="row justify-content-center">

    <div class="col-sm-11 col-lg-11 text-right m-b-20">
        <a style="color:#FFFF; background-color:#D6A62C; font-weight:bold; margin-left:10px;"
            href="/dpd/kabupaten/{{$detail->kabupaten_domisili}}/kantor" class="btn btn-lg  float-right"><i
                class="fa fa-plus"></i> Input / Edit kantor DPC</a>

        <a style="color:#FFFF; background-color:#D6A62C; font-weight:bold;"
            href="/dpd/kabupaten/{{ $detail->kabupaten_domisili}}/kepengurusan" class="btn btn-lg float-right"><i
                class="fa fa-plus"></i> Input / Edit Kepengurusan DPC</a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-sm-8 col-sg-8 col-md-11">
        <div class="card">
            <div class="card-header">
                <h4 class="page-title" style="font-weight:bold;">
                    @php
                    $name = \App\Kabupaten::getKab($detail->kabupaten_domisili ?? '');
                    @endphp

                    Profil DPC : {{$name->name ?? ''}}</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="panel panel-default">
                        <div class="panel-heading"
                            style="background-color:#D6A62C; font-size:20px; color:#FFFF; font-weight:bold;">
                            Informasi DPC (Dewan Pemimpin Cabang) </div>
                        <div class="panel-body">
                            <table width="315" border="0px" cellpadding="0px" cellspacing="0px"
                                class="table table-striped table-borderless bold">

                                <tbody>
                                    @if(!empty($kabupaten))


                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Alamat</td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> {{$kabupaten->alamat ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Provinsi
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> @php $name_prov =
                                            \App\Provinsi::getProv($kabupaten->provinsi);
                                            @endphp {{ $name_prov->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Kabupaten /
                                            Kota
                                        </td>
                                        <td class="font-kartu">:</td>

                                        <td class="font-kartu"> @php
                                            $namo = \App\Kabupaten::getKab($kabupaten->id_daerah);
                                            @endphp {{ $namo->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Kecamatan
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">@php $nama_kec =
                                            \App\Kecamatan::getKec($kabupaten->kec);
                                            @endphp
                                            {{ $nama_kec->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Kelurahan /
                                            Desa
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> @php
                                            $nama_kel = \App\Kelurahan::getKel($kabupaten->kel);
                                            @endphp
                                            {{ $nama_kel->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">WhatsApp Kantor
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">{{$kabupaten->wa_kantor ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">No Telepon
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> {{$kabupaten->no_telp ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">RT / RW
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">{{$kabupaten->rt_rw ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Kode Pos
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">{{$kabupaten->kode_pos ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Fax</td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">{{$kabupaten->fax ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Email
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> {{$kabupaten->email ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Nama Bank
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> @php
                                        $nama_bank= \App\Bank::getbank($kabupaten->nama_bank);
                                        @endphp

                                      {{ $nama_bank->nama_bank ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Nomor Rekening Bank
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> {{$kabupaten->nomor_rekening_bank ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Status Keterangan Kantor
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">   @if($kabupaten->status_kantor == 1)
                                       <a>Milik Sendiri</a>
                                       @elseif($kabupaten->status_kantor == 2)
                                        <a>Sewa, Hingga {{ Carbon\carbon::parse($kabupaten->tgl_selesai)->Format('d-m-Y') ?? '-' }}</a>
                                        @else
                                         <a>Pinjam Pakai, Hingga {{ Carbon\carbon::parse($kabupaten->tgl_selesai)->Format('d-m-Y') ?? '-' }}</a>
                                        @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Target Anggota
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">   {{$kabupaten->target_dpc ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Tanggal
                                            Pengesahan SK
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> @if($kabupaten->tanggal_pengesahan_sk == null)
                                            <a>-</a>
                                            @else
                                            {{ Carbon\carbon::parse($kabupaten->tanggal_pengesahan_sk)->Format('d-m-Y') }}
                                            @endif</td>
                                    </tr>
                                    <!--<tr>-->
                                    <!--    <td style="font-weight:bold; font-size:14px;" class="font-kartu">Koordinat-->
                                    <!--    </td>-->
                                    <!--    <td class="font-kartu">:</td>-->
                                    <!--    <td class="font-kartu"> {{$kabupaten->koordinat}}</td>-->
                                    <!--</tr>-->
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">SK.
                                            Kepengurusan
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td>
                                            @if(!empty($kabupaten->no_sk))
                                            <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                                 href="{{asset('/uploads/file/no_sk/'.$kabupaten->no_sk)}}"
                                              >Download
                                                SK. Kepengurusan</a>
                                            @else
                                            <a style="font-size:14px;">Belum Upload SK. Kepengurusan</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Domisili
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td>
                                            @if(!empty($kabupaten->domisili))
                                            <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                            href="{{asset('/uploads/file/domisili/'.$kabupaten->domisili)}}">Download
                                                Domisili</a>
                                            @else
                                            <a style="font-size:14px;">Belum Upload Domisili</a>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Surat
                                            Keterangan Kantor
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td>
                                            @if(!empty($kabupaten->surat_keterangan_kantor))
                                            <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                               href="{{asset('/uploads/file/surat_keterangan_kantor/'.$kabupaten->surat_keterangan_kantor)}}">Download
                                                Surat Keterangan Kantor</a>
                                            @else
                                            <a style="font-size:14px;">Belum Upload Surat Keterangan Kantor</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Rekening Bank
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td>
                                            @if(!empty($kabupaten->rekening_bank))
                                            <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                            href="{{asset('/uploads/file/rekening_bank/'.$kabupaten->rekening_bank)}}">Download
                                                Rekening Bank</a>
                                            @else
                                            <a style="font-size:14px;">Belum Upload Rekening Bank</a>
                                            @endif
                                        </td>

                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Cap Kantor
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td>
                                            @if(!empty($kabupaten->cap_kantor))
                                            <div class='click-zoom'>
                                                <label> <input type='checkbox'><img
                                                        src="{{asset('uploads/img/cap_kantor/'.$kabupaten->cap_kantor ?? '')}}"
                                                        alt='noimage' width='130px' height='80px'>
                                                </label>
                                            </div>
                                            @else
                                            <a style="font-size:14px;">Belum Upload Cap Kantor</a>
                                            @endif
                                        </td>
                                    </tr>

                                    @else

                                    <a style="font-weight:bold; text-align:center; font-size:14px;"
                                        class="text-center">Data Belum Ada</a>


                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="panel panel-default">
                        <div class="panel-heading"
                            style="background-color:#D6A62C;  font-size:15px; color:#FFFF; font-weight:bold;">
                            Pengurus DPC {{$name->name ?? ''}}</div>
                        <div class="panel-body">
                            @if(count($pengurus) != 0)
                            @foreach($pengurus as $data)
                            <div style=" display: inline-block; margin-top:40px; margin-left:10px;">
                                <div class="col-sm-8 col-sg-8 col-md-10">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap">
                                            <div class='click-zoom'>
                                                <label>
                                                    <input type='checkbox'>
                                                    <img src="{{asset('uploads/img/foto_kepengurusan/'.$data->foto)}}"
                                                        alt='noimage' width='80px' height='80px'>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="profile-basic">
                                            <h3 class="user-name m-t-0 mb-2">{{ $data->nama }}</h3>
                                            <table width="315" border="0px" cellpadding="0px" cellspacing="0px"
                                                class="bold">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">Nama</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->name}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">No. Anggota</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->kta}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">NIK</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->nik}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">TTD</td>
                                                        <td class="font-kartu">:</td>
                                                        <td>
                                                            <div class='click-zoom'>
                                                                <label>
                                                                    <input type='checkbox'>
                                                                    <img src="{{asset('uploads/img/ttd_kta/'.$data->ttd)}}"
                                                                        alt='noimage' width='80px' height='80px'>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else

                            <a style="font-weight:bold; text-align:center; font-size:14px;" class="text-center">Data
                                Belum Ada</a>


                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop