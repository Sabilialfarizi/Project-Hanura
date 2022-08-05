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
            font-size: 7px;
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
        #watermark {
            position: fixed;
            bottom:   0px;
            top: 5px;
            left:     300px;
           
            width:    90.6mm;
            height:   53.98mm;
            z-index:  -1000;
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
    
    $fot_ktp = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/foto_ktp/'.$ktp) && !empty($detail->foto_ktp)?
                '/www/wwwroot/siap.partaihanura.or.id/uploads/img/foto_ktp/'.$ktp : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ektp.png';
                
   
    
    $type_ktp = pathinfo($fot_ktp, PATHINFO_EXTENSION);
    
     if (file_exists($fot_ktp)){
         $data_ktp =  file_get_contents($fot_ktp);
    } else {
         $data_ktp = file_get_contents('/www/wwwroot/siap.partaihanura.or.id/uploads/img/ektp.png');
    }
    
    $pic_ktp = 'data:image/' . $type_ktp . ';base64,' .base64_encode($data_ktp);

    
  
    
    $fotolama = 'https://siap.partaihanura.or.id/uploads/img/cap_kantor/' . str_replace(' ', '%20', $cap);
    // $avatar = $detail->avatar ==  'profile.png' ?  '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'. str_replace(' ', '%20',$detail->image) : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'. str_replace(' ','%20',$detail->avatar);
    // $avatar = 'https://siap.partaihanura.or.id/uploads/img/users/' . str_replace(' ', '%20', $avatar);
    $ketua_ttd = 'https://siap.partaihanura.or.id/uploads/img/ttd_kta/' . str_replace(' ', '%20', $ttd_ketua);
    $sekre_ttd = 'https://siap.partaihanura.or.id/uploads/img/ttd_kta/' . str_replace(' ', '%20', $ttd_sekre);
    
    //  $avatar = $detail->avatar ==  'profile.png' ?  '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$detail->image : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/'.$detail->avatar;
    
    $avatar = $detail->avatar ==  'profile.png' ?  '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$detail->image : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$detail->avatar || !empty($detail->image) ? '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$detail->image : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/profile.png';
     
    $type_avatar = pathinfo($avatar, PATHINFO_EXTENSION);
    
    if (file_exists($avatar)) {
       $data_avatar = file_get_contents($avatar);
    } else {
     $data_avatar = file_get_contents('/www/wwwroot/siap.partaihanura.or.id/uploads/img/profile.png');
    }

    $pic_avatar = 'data:image/' . $type_avatar . ';base64,' .base64_encode($data_avatar);
    ?>

    <table class="table table-borderless">
        <tr>
            <td style="padding-right: 35px;">
                <table cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td>
                                @if (!empty($fot_ktp))
                                    <img alt="Foto Ktp" class="responsive" src="<?php echo $pic_ktp; ?>" width="270"
                                        height="190">
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
                  <div id="watermark">
                     <img  src="{{asset('/uploads/img/KTA Belakang.jpg' ) }}"  height="95%" width="100%" />
                 </div>
                 <main>
                     <table  class="table-borderless" border="0px" cellpadding="0px" cellspacing="0px" width="250" style="margin-bottom:-15px;" class="bold">
                        <tbody>
                            <tr>
                                <!--td class="foto-kartu" width="107" rowspan="12" align="center"-->
                               @if(empty($member->avatar))
                                <td width="75" rowspan="12" border="0px" valign="top" style="border-collapse: collapse;">
                                    <img id="blah" class="responsive" src="<?php echo $pic_avatar ?>" width="90" height="105"
                                        style="border-collapse: collapse;" border="0px" alt="Foto Profil">
                                </td>
                                @else
                                <td width="75" rowspan="12" border="0px" valign="top" style="border-collapse: collapse; margin-left:20px;">
                                    <img id="blah" class="responsive" src="{{asset('/uploads/img/profile.png' ) }}" width="90"
                                        height="105" style="border-collapse: collapse;" border="0px" alt="Foto Profil">
                                </td>
                                @endif
    
    
                                <td class="font-kartu" width="52">No. KTA</td>
                                <td class="font-kartu" align="center">:</td>
                                <td class="font-kartu">{{$detail->no_member}}</td>
                            </tr>
                            <tr>
                                <td class="font-kartu">Nama</td>
                                <td class="font-kartu" align="center">:</td>
                                <td class="font-kartu">{{ ucwords(strtolower($detail->nickname))}}</td>
                            </tr>
                            <tr>
                                <td class="font-kartu" width="25">Tempat/Tgl Lahir </td>
                                <td class="font-kartu" align="center">:</td>
                                <td class="font-kartu">{{ucwords(strtolower($detail->birth_place))}}
                                    , {{ Carbon\Carbon::parse($detail->tgl_lahir)->Format('d-m-Y') }}
                                </td>
    
                            </tr>
                            <tr>
                                <td class="font-kartu">Alamat</td>
                                <td class="font-kartu" align="center">:</td>
                               <td style="font-size:6px; font-weight:bold;  font-family: Verdana, Arial, Helvetica, sans-serif;">{{ $detail->alamat}}</td>
                            </tr>
                            <tr>
                                <td class="font-kartu">RT/RW</td>
                                <td class="font-kartu" align="center">:</td>
                                <td class="font-kartu"> {{$detail->rt_rw}} </td>
                            </tr>
    
                            <tr>
                                <td class="font-kartu" width="25">Kel./Desa</td>
                                <td class="font-kartu" width="10"  align="center">:</td>
                                <td class="font-kartu"> @php
                                    $nama_kel = \App\Kelurahan::getKel( $detail->kelurahan_domisili);
                                    @endphp
                                    {{  ucwords(strtolower($nama_kel->name ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <td class="font-kartu" width="28">Kec.</td>
                                <td class="font-kartu" width="10"  align="center">:</td>
                                <td class="font-kartu"> @php
                                    $nama_kec = \App\Kecamatan::getKec( $detail->kecamatan_domisili);
                                    @endphp
                                    {{  ucwords(strtolower($nama_kec->name ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <td class="font-kartu">Kab./Kota</td>
                                <td class="font-kartu" align="center">:</td>
                                <td class="font-kartu"> @php
                                    $namo = \App\Kabupaten::getKab( $detail->kabupaten_domisili);
                                    @endphp {{ ucwords(strtolower($namo->name ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <td class="font-kartu">Provinsi</td>
                                <td class="font-kartu" align="center">:</td>
                                <td class="font-kartu">@php
                                    $name = \App\Provinsi::getProv( $detail->provinsi_domisili);
                                    @endphp
                                    {{  ucwords(strtolower($name->name ?? '-')) }}</td>
                            </tr>
                            <tr>
                                <td class="font-kartu">Diterbitkan</td>
                                <td class="font-kartu" align="center">:</td>
                                <td class="font-kartu">
                                    {{Carbon\Carbon::parse($detail->created_at)->Format('d-m-Y')}}</td>
                            </tr>
                            <tr>
                                <td class="font-kartu" colspan="3">&nbsp;</td>
                            </tr>
    
                            <!--<tr>-->
                            <!--    <td class="font-kartu" nowrap=""></td>-->
                            <!--    <td class="font-kartu"></td>-->
                            <!--    <td class="font-kartu"></td>-->
                            <!--</tr>-->
                            <tr>
                                <td class="font-kartu1" colspan="4" width="140">
                                    <div style="font-size:9spx; color:black; font-weight:bold; margin-left:-70px;">
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
    
                                            <td class="font-kartu" align="center" width="100">Ketua</td>
                                            @if ($kantor == null)-->
                                            <td style="width:40.3333%" rowspan="3"></td>
                                            @else
                                            <td style="width:40.3333%" rowspan="3" align="center">
                                                <img src="<?php echo $fotolama; ?>" alt="cap kantor notfound" width="50"
                                                    height="36">
                                            </td>
                                            @endif
                                            <td class="font-kartu" align="center" width="110">Sekretaris</td>
    
                                        </tr>
                                        <tr>
                                            @if($ketua == null)
                                            <td align="center" class="ttd-kartu"><img id="ttdKetua" src="" width="40"
                                                    height="10" border="0" alt="ttd ketua"></td>
                                            @else
    
                                            <td align="center" style="font-weight:bold;" class="ttd-kartu" align="center">
                                                <img id="ttdKetua" src="<?php echo $ketua_ttd ?>" width="45" height="15"
                                                    border="0" alt="ttd ketua"></td>
                                            @endif
    
    
                                            @if($sekre == null)
                                            <td align="center" class="ttd-kartu"><img id="ttdKetua" src="" width="40"
                                                    height="10" border="0" alt="ttd sekre"></td>
                                            @else
                                            <td align="center" style="font-weight:bold;" class="ttd-kartu"><img
                                                    id="ttdSekre" src="<?php echo $sekre_ttd ?>" width="45" height="15"
                                                    border="0" alt="ttd sekre"></td>
                                            @endif
    
    
                                        </tr>
                                        <tr>
                                            <td class="font-kartu" align="center">@php
                                                $name_ketua =
                                                \App\DetailUsers::getName($kecamatan->id_ketua_dpc);
                                                @endphp
                                                {{ $ketua->nama ?? 'nama ketua'}}</td>
                                            <td class="font-kartu" align="center">@php
                                                $name = \App\DetailUsers::getName($kecamatan->id_sekre_dpc);
                                                @endphp
                                                {{ $sekre->nama ?? 'nama sekre'}}</td>
                                        </tr>
    
    
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </main>

            </td>

        </tr>
    </table>
</body>

</html>
