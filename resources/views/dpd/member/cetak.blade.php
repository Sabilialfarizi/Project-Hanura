<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Hanura</title>
    <link href="styles/popcalendar.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}img/favicon.png">
    <title>{{ \App\Setting::find(1)->web_name }}</title>
      <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/kartuqs.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script language="JavaScript">
        function printPage() {
            if (window.print) {
                agree = confirm('Tekan tombol OK untuk mencetak kartu.');
                if (agree) window.print();
            }
        }
        printPage();

    </script>
    <script src="js/readurl.js" type="text/javascript"></script>
    <script src="js/imageshow.js" type="text/javascript"></script>
    <style type="text/css">
        .italic {
            font-style: italic;
        }

        .oblique {
            font-style: oblique;
        }

        .bold {
            font-weight: bold;
        }

    </style>
</head>

<body bgcolor="#FFFFFF" data-new-gr-c-s-check-loaded="14.1058.0" data-gr-ext-installed="">
    <table width="315" border="0px" cellpadding="0px" cellspacing="0px" class="bold">
        <tbody>
            <tr>
                <!--td class="foto-kartu" width="107" rowspan="12" align="center"-->
                @if(!empty($detail->avatar))
                <td width="85" rowspan="12" align="center" border="0px" valign="top" style="border-collapse: collapse;">
                   <img id="blah" class="responsive"
                    src="{{asset('/uploads/img/users/' . $detail->avatar ) }}" width="70"
                    height="78" style="border-collapse: collapse;" border="0px" alt="Foto Profil">
                </td>
                @else
                 <td width="85" rowspan="12" align="center" border="0px" valign="top" style="border-collapse: collapse;">
                   <img id="blah" class="responsive"
                    src="{{asset('/uploads/img/profile.png' ) }}" width="70"
                    height="78" style="border-collapse: collapse;" border="0px" alt="Foto Profil">
                </td>
                @endif
                  
                <td class="font-kartu" width="90">No Anggota </td>
                <td class="font-kartu" width="5">:</td>
                <td class="font-kartu" width="auto">{{$detail->no_member}}</td>
            </tr>
            <tr>
                <td class="font-kartu">Nama</td>
                <td class="font-kartu">:</td>
                <td class="font-kartu">{{$detail->nickname}}</td>
            </tr>
            <tr>
                <td class="font-kartu">Tmp/Tgl Lahir </td>
                <td class="font-kartu">:</td>
                <td class="font-kartu">{{$detail->birth_place}} /{{ Carbon\Carbon::parse($detail->tgl_lahir)->isoFormat('dddd, D MMMM Y') }} </td>

            </tr>
            <tr>
                <td class="font-kartu">Alamat</td>
                <td class="font-kartu">:</td>
                <td class="font-kartu">{{$detail->alamat}}</td>
            </tr>
            <tr>
                <td class="font-kartu">RT/RW</td>
                <td class="font-kartu">:</td>
                <td class="font-kartu"> {{$detail->rt_rw}} </td>
            </tr>
            <!--/table>
    <table width="349" border="0" cellpadding="0" cellspacing="0"-->
            <tr>
                <td class="font-kartu" width="25">Kel./Desa</td>
                <td class="font-kartu" width="10">:</td>
                <td class="font-kartu"> @php
                                            $nama_kel = \App\Kelurahan::getKel($detail->kelurahan_domisili);
                                            @endphp
                                            {{ $nama_kel->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="font-kartu" width="28">Kec.</td>
                <td class="font-kartu" width="10">:</td>
                <td class="font-kartu"> @php
                                            $nama_kec = \App\Kecamatan::getKec($detail->kecamatan_domisili);
                                            @endphp
                                            {{ $nama_kec->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="font-kartu">Kab./Kota</td>
                <td class="font-kartu">:</td>
                <td class="font-kartu"> @php
                                            $namo = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                                            @endphp {{ $namo->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="font-kartu">Provinsi</td>
                <td class="font-kartu">:</td>
                <td class="font-kartu">@php
                                            $name = \App\Provinsi::getProv($detail->provinsi_domisili);
                                            @endphp
                                            {{ $name->name ?? '-' }}</td>
            </tr>
             <tr>
                                <td class="font-kartu">Diterbitkan Tgl</td>
                                <td class="font-kartu">:</td>
                                <td class="font-kartu">
                                    {{Carbon\Carbon::parse($detail->created_at)->isoFormat(' D-M-Y')}}</td>
            </tr>
            <tr>
                <td class="font-kartu" colspan="3">&nbsp;</td>
            </tr>
            <!--   <tr>
        <td class="font-kartu" nowrap>Dikeluarkan Sejak</td>
        <td class="font-kartu">:</td>
        <td class="font-kartu">1 Januari 2017</td>
      </tr> -->
            <tr>
                <td class="font-kartu" nowrap=""></td>
                <td class="font-kartu"></td>
                <td class="font-kartu"></td>
            </tr>
        
                                  <tr>
                                        
                                        <td class="font-kartu1"  colspan="4" width="180">
                                            <div
                                                style="margin-left:79px; width: 236px;height: 15px;background: #554646;mix-blend-mode: normal;border-radius: 200px 0px 0px 0px;">
                                                DPC @php
                                                $namo = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                                                @endphp {{ $namo->name ?? '-' }} </div>
                                        </td>


                                    </tr>
        </tbody>
    </table>
 <div style= "width: 315px;height: 83px;background: #D6A62C;border-radius: 200px 0px 0px 0px;">
                        <div style="float:left;">

        <table width="310" border="0" cellpadding="0" cellspacing="0" class="bold">
            <!--tr>
        <td class="font-kartu" width="97">Tgl Cetak</td>
        <td class="font-kartu" width="10">:</td>
        <td class="font-kartu" width="243"></td>
      </tr-->
            <tbody>
              <tr>
                    <td width="80" rowspan="5" align="center">
                       {{$qrcode}} </td>
                    
                </tr>
                <tr>
                    <td class="font-kartu" align="center" width="117">Ketua</td>
                    <td class="font-kartu" align="center" width="125">Sekretaris</td>
                </tr>
                <tr>
                    <td class="ttd-kartu" align="center"><img id="ttdKetua"  src="{{asset('/uploads/img/ttd_kta/' . $ketua->ttd ) }}" width="70"
                            height="25" border="0" alt="ttd ketua"></td>
                    <td class="ttd-kartu" align="center"><img id="ttdSekre"  src="{{asset('/uploads/img/ttd_kta/' . $sekre->ttd) }}" width="70"
                            height="25" border="0" alt="ttd sekre"></td>
                </tr>
                <tr>
                    <td class="font-kartu" align="center">@php
                                            $name_ketua = \App\DetailUsers::getName($kabupaten->id_ketua_dpc);
                                            @endphp
                                            {{ $ketua->nama}}</td>
                    <td class="font-kartu" align="center">@php
                                            $name = \App\DetailUsers::getName($kabupaten->id_sekre_dpc);
                                            @endphp
                                            {{ $sekre->nama }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="float:left; margin-left:-160px; margin-top:10px;"><img src="{{ asset('/') }}img/logo/cap.png" width="80"></div>
    </div>




</body>

</html>
