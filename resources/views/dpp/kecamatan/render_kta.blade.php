<html>

<head>
    <title>Hanura</title>
    <style type="text/css">
        @page {
            width: 230mm;
            height: 947mm;

        }

        @media screen {

            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12;
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm auto;
                display: block;
            }

            .wrapper-page {
                page-break-after: always;
            }

            .wrapper-page:last-child {
                page-break-after: avoid;
            }
        }

        .italic {
            font-style: italic;
        }

        .oblique {
            font-style: oblique;
        }

        .bold {
            font-weight: bold;
        }

        .page-break-after {
            page-break-after: always;
        }

        .font-kartu {
            font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
            font-size: 8px;
            font-weight: bold;
            color: #000000;
        }

        .font-kartu1 {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 10px;
            text-align: center;
            color: #FFFFFF;
        }

        .font-kartu2 {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #00000;
        }

        .ttd-kartu {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #00000;
            padding-right: 2px;
            padding-left: -32px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;

        }


        .table-bordered {
            border: 1px solid #dee2e6
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px
        }

        .table-borderless tbody+tbody,
        .table-borderless td,
        .table-borderless th,
        .table-borderless thead th {
            border: 0
        }


        #menu {
            display: none;
        }

        #wrapper,
        #content {
            width: 864px;
            border: 0;
            margin: 30 1%;
            padding: 0;
            padding-bottom: 50px;
            margin-left: 2%;
            float: none !important;
        }
    </style>
</head>

<body>
    <?php
    $ttd_ketua = $ketua->ttd ?? '';
    $ttd_sekre = $sekre->ttd ?? '';
    $cap = $kantor->cap_kantor ?? '';
    $avatar = $detail->avatar ?? '';
    $ktp = $detail->foto_ktp ?? '';
    
    $fot_ktp = 'https://siap.partaihanura.or.id/uploads/img/foto_ktp/' . str_replace(' ', '%20', $ktp);
    
    $fotolama = 'https://siap.partaihanura.or.id/uploads/img/cap_kantor/' . str_replace(' ', '%20', $cap);
    $avatar = 'https://siap.partaihanura.or.id/uploads/img/users/' . str_replace(' ', '%20', $avatar);
    $ketua_ttd = 'https://siap.partaihanura.or.id/uploads/img/ttd_kta/' . str_replace(' ', '%20', $ttd_ketua);
    $sekre_ttd = 'https://siap.partaihanura.or.id/uploads/img/ttd_kta/' . str_replace(' ', '%20', $ttd_sekre);
    
    ?>

    <table class="table table-borderless">
        <tr>
            <td style="padding-right: 35px;">
                <table cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td>
                                @if (!empty($detail->foto_ktp))
                                    <img alt="Foto Ktp" class="responsive" src="<?php echo $fot_ktp; ?>" width="250"
                                        height="150">
                                @else
                                    <img alt="Foto Ktp" class="responsive" src="{{ asset('/uploads/img/ektp.png') }}"
                                        width="250" height="150">
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </td>
            <td>
                <table width="250" border="0px" cellpadding="0px" cellspacing="0px" class="bold">
                    <tbody>
                        <tr>
                            @if (!empty($detail->avatar))
                                <td width="65" rowspan="12" colspan="2" align="center" border="0px"
                                    valign="top" style="border-collapse: collapse;">
                                    <img id="blah" class="responsive" src="<?php echo $avatar; ?>" width="68"
                                        height="98" style="border-collapse: collapse;" border="0px"
                                        alt="Foto Profil">
                                </td>
                            @else
                                <td width="65" rowspan="12" align="center" border="0px" valign="top"
                                    style="border-collapse: collapse;">
                                    <img id="blah" class="responsive"
                                        src="{{ asset('/uploads/img/profile.png') }}" width="68" height="98"
                                        style="border-collapse: collapse;" border="0px" alt="Foto Profil">
                                </td>
                            @endif


                            <td class="font-kartu" width="70">No. KTA</td>
                            <td class="font-kartu">:</td>
                            <td class="font-kartu">{{ $detail->no_member }}</td>
                        </tr>
                        <tr>
                            <td class="font-kartu">Nama</td>
                            <td class="font-kartu">:</td>
                            <td class="font-kartu">{{ ucwords(strtolower($detail->nickname)) }}</td>
                        </tr>
                        <tr>
                            <td class="font-kartu" width="25">Tempat/Tgl Lahir </td>
                            <td class="font-kartu">:</td>
                            <td class="font-kartu">{{ ucwords(strtolower($detail->birth_place)) }}
                                , {{ Carbon\Carbon::parse($detail->tgl_lahir)->Format('d-m-Y') }}
                            </td>

                        </tr>
                        <tr>
                            <td class="font-kartu">Alamat</td>
                            <td class="font-kartu">:</td>
                            <td class="font-kartu">{{ ucwords(strtolower($detail->alamat)) }}</td>
                        </tr>
                        <tr>
                            <td class="font-kartu">RT/RW</td>
                            <td class="font-kartu">:</td>
                            <td class="font-kartu"> {{ $detail->rt_rw }} </td>
                        </tr>

                        <tr>
                            <td class="font-kartu" width="25">Kel./Desa</td>
                            <td class="font-kartu" width="10">:</td>
                            <td class="font-kartu"> @php
                                $nama_kel = \App\Kelurahan::getKel($detail->kelurahan_domisili);
                            @endphp
                                {{ ucwords(strtolower($nama_kel->name ?? '-')) }}</td>
                        </tr>
                        <tr>
                            <td class="font-kartu" width="28">Kec.</td>
                            <td class="font-kartu" width="10">:</td>
                            <td class="font-kartu"> @php
                                $nama_kec = \App\Kecamatan::getKec($detail->kecamatan_domisili);
                            @endphp
                                {{ ucwords(strtolower($nama_kec->name ?? '-')) }}</td>
                        </tr>
                        <tr>
                            <td class="font-kartu">Kab./Kota</td>
                            <td class="font-kartu">:</td>
                            <td class="font-kartu"> @php
                                $namo = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                            @endphp {{ ucwords(strtolower($namo->name ?? '-')) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-kartu">Provinsi</td>
                            <td class="font-kartu">:</td>
                            <td class="font-kartu">@php
                                $name = \App\Provinsi::getProv($detail->provinsi_domisili);
                            @endphp
                                {{ ucwords(strtolower($name->name ?? '-')) }}</td>
                        </tr>
                        <tr>
                            <td class="font-kartu">Diterbitkan</td>
                            <td class="font-kartu">:</td>
                            <td class="font-kartu">
                                {{ Carbon\Carbon::parse($detail->created_at)->Format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-kartu" colspan="3">&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="font-kartu" nowrap=""></td>
                            <td class="font-kartu"></td>
                            <td class="font-kartu"></td>
                        </tr>
                        <tr>
                            <td class="font-kartu1" colspan="5" width="180">
                                <div style="font-size:9spx; color:black; font-weight:bold; text-align:center">
                                    DPC @php
                                        $namo = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                                    @endphp {{ ucwords(strtolower($namo->name ?? '-')) }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="padding: 0">
                                <table width="100%" style="padding: 0">
                                    <tr>
                                        <td style="text-align: center; width: 33.333%" class="font-kartu">Ketua</td>
                                        @if ($kantor == null)
                                            <td style="width:33.3333%" rowspan="3"></td>
                                        @else
                                            <td style="width:33.3333%" rowspan="3" align="center">
                                                <img src="<?php echo $fotolama; ?>" alt="cap kantor notfound"
                                                    width="48" height="24">
                                            </td>
                                        @endif
                                        <td style="text-align: center; width: 33.333%" class="font-kartu">Sekretaris
                                        </td>
                                    </tr>
                                    <tr>
                                        @if ($ketua == null)
                                            <td class="ttd-kartu"></td>
                                        @else
                                            <td style="font-weight:bold;" class="ttd-kartu" align="center"><img
                                                    id="ttdKetua" src="<?php echo $ketua_ttd; ?>" width="40"
                                                    height="15" border="0" alt="ttd ketua">
                                            </td>
                                        @endif
                                        @if ($sekre == null)
                                            <td class="ttd-kartu"></td>
                                        @else
                                            <td style="font-weight:bold;" class="ttd-kartu" align="center"><img
                                                    id="ttdSekre" src="<?php echo $sekre_ttd; ?>" width="40"
                                                    height="10" border="0" alt="ttd sekre"></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="font-kartu" align="center">@php
                                            $name_ketua = \App\DetailUsers::getName($kecamatan->id_ketua_dpc);
                                        @endphp
                                            {{ ucwords(strtolower($ketua->nama ?? 'nama ketua')) }}</td>
                                        <td class="font-kartu" align="center">@php
                                            $name = \App\DetailUsers::getName($kecamatan->id_sekre_dpc);
                                        @endphp
                                            {{ ucwords(strtolower($sekre->nama ?? 'nama sekre')) }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </td>

        </tr>
    </table>
</body>

</html>
