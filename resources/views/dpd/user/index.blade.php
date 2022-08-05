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

    <div class="col-sm-11 text-right m-b-20">

        <a style="color:#FFFF; background-color:#D6A62C; font-weight:bold; margin-left:10px;"
            href="/dpp/provinsi/{{$detail->provinsi_domisili}}/kantor" class="btn btn-lg float-right"><i
                class="fa fa-plus"></i> Input / Edit Informasi Kantor DPD</a>

        <a style="color:#FFFF; background-color:#D6A62C; font-weight:bold;"
            href="/dpp/provinsi/{{$detail->provinsi_domisili}}/kepengurusan" class="btn btn-lg float-right"><i
                class="fa fa-plus"></i> Input / Edit kepengurusan DPD</a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-sm-8 col-sg-8 col-md-11">
        <div class="card">
            <div class="card-header">
                <h4 class="page-title" style="font-weight:bold;">
                    @php
                    $name = \App\Provinsi::getProv($detail->provinsi_domisili);
                    @endphp

                    Profile DPD Provinsi : {{$name->name ?? ''}}</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="panel panel-default">
                        <div class="panel-heading"
                            style="background-color:#D6A62C; font-size:20px; color:#FFFF; font-weight:bold;">
                            Informasi DPD (Dewan Pimpinan Daerah) </div>
                        <div class="panel-body">
                            <table width="315" border="0px" cellpadding="0px" cellspacing="0px"
                                class="table table-striped table-borderless bold">
                                @if(!empty($provinsi))

                                <tbody>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Alamat</td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> {{$provinsi->alamat ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Provinsi
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> @php $name_prov =
                                            \App\Provinsi::getProv($provinsi->provinsi);
                                            @endphp {{ $name_prov->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Kabupaten /
                                            Kota
                                        </td>
                                        <td class="font-kartu">:</td>

                                        <td class="font-kartu"> @php
                                            $namo = \App\Kabupaten::getKab($provinsi->kab_kota);
                                            @endphp {{ $namo->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Kecamatan
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">@php $nama_kec =
                                            \App\Kecamatan::getKec($provinsi->kec);
                                            @endphp
                                            {{ $nama_kec->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Kelurahan /
                                            Desa
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> @php
                                            $nama_kel = \App\Kelurahan::getKel($provinsi->kel);
                                            @endphp
                                            {{ $nama_kel->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">No Telepon
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> {{$provinsi->no_telp  ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">RT / RW
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">{{$provinsi->rt_rw  ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Kode Pos
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">{{$provinsi->kode_pos  ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Fax</td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">{{$provinsi->fax ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Email
                                            
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> {{$provinsi->email  ?? '-'}}</td>
                                    </tr>
                                    <!--<tr>-->
                                    <!--    <td style="font-weight:bold; font-size:14px;" class="font-kartu">-->
                                    <!--        Koordinat-->
                                    <!--    </td>-->
                                    <!--    <td class="font-kartu">:</td>-->
                                    <!--    <td class="font-kartu"> {{$provinsi->koordinat}}</td>-->
                                    <!--</tr>-->
                                     <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Nama Bank
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> @php
                                        $nama_bank= \App\Bank::getbank($provinsi->nama_bank);
                                        @endphp

                                      {{ $nama_bank->nama_bank ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Nomor Rekening Bank
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> {{$provinsi->nomor_rekening_bank  ?? '-'}}</td>
                                    </tr>
                                     <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Status Keterangan Kantor
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu">   @if($provinsi->status_kantor == 1)
                                       <a>Milik Sendiri</a>
                                       @elseif($provinsi->status_kantor == 2)
                                        <a>Sewa, Hingga {{ Carbon\carbon::parse($provinsi->tgl_selesai)->Format('d-m-Y') ?? '' }}</a>
                                        @else
                                         <a>Pinjam Pakai, Hingga {{ Carbon\carbon::parse($provinsi->tgl_selesai)->Format('d-m-Y') ?? '' }}</a>
                                        @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Tanggal
                                            Pengesahan SK
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td class="font-kartu"> @if($provinsi->tanggal_pengesahan_sk == null)
                                            <a>-</a>
                                            @else
                                            {{ Carbon\carbon::parse($provinsi->tanggal_pengesahan_sk)->Format('d-m-Y') }}
                                            @endif</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">SK.
                                            Kepengurusan
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td>
                                            @if(!empty($provinsi->no_sk))
                                            <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                              href="{{asset('/uploads/file/no_sk/'.$provinsi->no_sk)}}">Download
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
                                            @if(!empty($provinsi->domisili))
                                            <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                            href="{{asset('/uploads/file/domisili/'.$provinsi->domisili)}}"
                                               >Download
                                                Domisili</a>
                                            @else
                                            <a style="font-size:14px;">Belum Upload Domisili</a>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Surat
                                            Keterangan Status Kantor
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td>
                                            @if(!empty($provinsi->surat_keterangan_kantor))
                                            <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                                  href="{{asset('/uploads/file/surat_keterangan_kantor/'.$provinsi->surat_keterangan_kantor)}}">Download
                                                Surat Keterangan Kantor</a>
                                            @else
                                            <a style="font-size:14px;">Belum Upload Surat Keterangan Status Kantor</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; font-size:14px;" class="font-kartu">Rekening Bank
                                        </td>
                                        <td class="font-kartu">:</td>
                                        <td>
                                            @if(!empty($provinsi->rekening_bank))
                                            <a class="btn btn-sm" style="font-size:12px; background-color:#D6A62C; color:#FFFF;"
                                                 href="{{asset('/uploads/file/rekening_bank/'.$provinsi->rekening_bank)}}">Download
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
                                            @if(!empty($provinsi->cap_kantor))
                                            <div class='click-zoom'>
                                                <label> <input type='checkbox'><img
                                                        src="{{asset('uploads/img/cap_kantor/'.$provinsi->cap_kantor ?? '')}}"
                                                        alt='noimage' width='80px' height='80px'>
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
                            Pengurus DPD {{$name->name ?? ''}}</div>
                        <div class="panel-body">
                            @if(count($pengurusDPD) != 0)
                            @foreach($pengurusDPD as $data)
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