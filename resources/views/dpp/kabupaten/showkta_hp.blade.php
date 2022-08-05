<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hanura</title>
    <link href="styles/popcalendar.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}img/favicon.png">
    <title>{{ \App\Setting::find(1)->web_name }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/kartuqs.css">



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
        #content {
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 1;
        }

        #plugin {
            display: block;
            height: 100%;
            position: absolute;
            width: 100%;
        }

        #sizer {
            position: absolute;
            z-index: 0;
        }

        [hidden],
        :host([hidden]) {
            display: none !important;
        }

        :host {
            --viewer-pdf-sidenav-width: 300px;
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
        }

        viewer-pdf-sidenav,
        viewer-toolbar {
            --pdf-toolbar-text-color: rgb(241, 241, 241);
        }

        viewer-toolbar {
            --active-button-bg: rgba(255, 255, 255, 0.24);
            z-index: 1;
        }

        @media(max-width: 200px),
        (max-height: 250px) {
            viewer-toolbar {
                display: none;
            }

        }

        #sidenav-container {
            overflow: hidden;
            transition: transform 250ms cubic-bezier(.6, 0, 0, 1), visibility 250ms;
            visibility: visible;
            width: var(--viewer-pdf-sidenav-width);
        }

        #sidenav-container.floating {
            bottom: 0;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        #sidenav-container[closed] {
            transform: translateX(-100%);
            transition: transform 200ms cubic-bezier(.6, 0, 0, 1),
                visibility 200ms, width 0ms 200ms;
            visibility: hidden;
            width: 0;
        }

        :host-context([dir='rtl']) #sidenav-container[closed] {
            transform: translateX(100%);
        }

        @media(max-width: 500px),
        (max-height: 250px) {
            #sidenav-container {
                display: none;
            }

        }

        #content-focus-rectangle {
            border: 2px solid var(--google-grey-500);
            border-radius: 2px;
            box-sizing: border-box;
            height: 100%;
            pointer-events: none;
            position: absolute;
            top: 0;
            width: 100%;
        }

        viewer-ink-host {
            height: 100%;
            position: absolute;
            width: 100%;
        }

        #container {
            display: flex;
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        #plugin {
            position: initial;
        }

        #content {
            height: 100%;
            left: 0;
            position: sticky;
            top: 0;
            z-index: initial;
        }

        #sizer {
            top: 0;
            width: 100%;
            z-index: initial;
        }

        #main {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        #scroller {
            direction: ltr;
            height: 100%;
            overflow: auto;
            position: relative;
        }

        #scroller:fullscreen {
            overflow: hidden;
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


    @foreach($detail as $details)
    <?php 
                     $ttd_ketua = $ketua->ttd ?? '';
                    $ttd_sekre = $sekre->ttd ?? '';
                    $cap = $kantor->cap_kantor ?? '';
                    $avatar = $details->image ?? '';
    
                              
                 $ketua_ttd = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/'.$ttd_ketua) && !empty($ketua->ttd)?
                '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/'.$ttd_ketua : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/noimage.jpg';
               
                $sekre_ttd = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/'.$ttd_sekre) && !empty($sekre->ttd)?
                '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/'.$ttd_sekre :'/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/noimage.jpg';
              
                $fotolama = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/'.$cap) && !empty($kantor->cap_kantor)?
                '/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/'.$cap : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/cap.jpg';
                
                // $avatar = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$avatar) && !empty($details->image)?
                // '/www/wwwroot/siap.partaihanura.or.id/uploads/img/'.$avatar : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/profile.png';
                $avatar = $details->avatar ==  'profile.png' ?  '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$details->image : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/'.$details->avatar || !empty($details->image) ? '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$details->image : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/profile.png';
                        
                        $type_avatar = pathinfo($avatar, PATHINFO_EXTENSION);
                        $data_avatar = file_get_contents($avatar);
                        $pic_avatar = 'data:image/' . $type_avatar . ';base64,' .base64_encode($data_avatar);
                        
                        $type = pathinfo($fotolama, PATHINFO_EXTENSION);
                        $data = file_get_contents($fotolama);
                        $pic = 'data:image/' . $type . ';base64,' .base64_encode($data);
                        
                        $type_ketua = pathinfo($ketua_ttd, PATHINFO_EXTENSION);
                        $data_ketua = file_get_contents($ketua_ttd);
                        $pic_ketua = 'data:image/' . $type_ketua . ';base64,' .base64_encode($data_ketua);
                        
                        $type_sekre = pathinfo($sekre_ttd, PATHINFO_EXTENSION);
                        $data_sekre = file_get_contents($sekre_ttd);
                        $pic_sekre = 'data:image/' . $type_sekre . ';base64,' .base64_encode($data_sekre);
                        
                        $type = pathinfo($fotolama, PATHINFO_EXTENSION);
                        $data = file_get_contents($fotolama);
                        $pic = 'data:image/' . $type . ';base64,' .base64_encode($data);
                    ?>
    <div
        style="margin-top:40px; transform: translate(30px,0px); margin-left:-5px;  display: inline-block; width: 330px;">
        <table class="table table-borderless" border="0px" cellpadding="0px" cellspacing="0px" class="bold">
            <tbody>
                <tr>
                    <!--td class="foto-kartu" width="107" rowspan="12" align="center"-->
                    @if(!empty($details->avatar))
                    <td width="65" rowspan="12" align="center" border="0px" valign="top"
                        style="border-collapse: collapse;">
                        <img id="blah" class="responsive" src="<?php echo $pic_avatar ?>" width="68" height="98"
                            style="border-collapse: collapse;" border="0px" alt="Foto Profil">
                    </td>
                    @else
                    <td width="65" rowspan="12" align="center" border="0px" valign="top"
                        style="border-collapse: collapse;">
                        <img id="blah" class="responsive" src="{{asset('/uploads/img/profile.png') }}" width="68"
                            height="98" style="border-collapse: collapse;" border="0px" alt="Foto Profil">
                    </td>
                    @endif


                    <td class="font-kartu" width="60">No. Anggota</td>
                    <td class="font-kartu">:</td>
                    <td class="font-kartu">{{$details->no_member}}</td>
                </tr>
                <tr>
                    <td class="font-kartu">Nama</td>
                    <td class="font-kartu">:</td>
                    <td class="font-kartu">{{ ucwords(strtolower($details->nickname))}}</td>
                </tr>
                <tr>
                    <td class="font-kartu" width="25">Tempat/Tgl Lahir </td>
                    <td class="font-kartu">:</td>
                    <td class="font-kartu">{{ucwords(strtolower($details->birth_place))}}, {{ Carbon\Carbon::parse($details->tgl_lahir)->Format('d-m-Y') }}
                    </td>

                </tr>
                <tr>
                    <td class="font-kartu">Alamat</td>
                    <td class="font-kartu">:</td>
                    <td class="font-kartu">{{ ucwords(strtolower($details->alamat))}}</td>
                </tr>
                <tr>
                    <td class="font-kartu">RT/RW</td>
                    <td class="font-kartu">:</td>
                    <td class="font-kartu"> {{$details->rt_rw}} </td>
                </tr>

                <tr>
                    <td class="font-kartu" width="25">Kel./Desa</td>
                    <td class="font-kartu" width="10">:</td>
                    <td class="font-kartu"> @php
                        $nama_kel = \App\Kelurahan::getKel( $details->kelurahan_domisili);
                        @endphp
                        {{  ucwords(strtolower($nama_kel->name ?? '-')) }}</td>
                </tr>
                <tr>
                    <td class="font-kartu" width="28">Kec.</td>
                    <td class="font-kartu" width="10">:</td>
                    <td class="font-kartu"> @php
                        $nama_kec = \App\Kecamatan::getKec( $details->kecamatan_domisili);
                        @endphp
                        {{  ucwords(strtolower($nama_kec->name ?? '-')) }}</td>
                </tr>
                <tr>
                    <td class="font-kartu">Kab./Kota</td>
                    <td class="font-kartu">:</td>
                    <td class="font-kartu"> @php
                        $namo = \App\Kabupaten::getKab( $details->kabupaten_domisili);
                        @endphp {{ ucwords(strtolower($namo->name ?? '-')) }}</td>
                </tr>
                <tr>
                    <td class="font-kartu">Provinsi</td>
                    <td class="font-kartu">:</td>
                    <td class="font-kartu">@php
                        $name = \App\Provinsi::getProv( $details->provinsi_domisili);
                        @endphp
                        {{  ucwords(strtolower($name->name ?? '-')) }}</td>
                </tr>
                <tr>
                    <td class="font-kartu">Diterbitkan</td>
                    <td class="font-kartu">:</td>
                    <td class="font-kartu">
                        {{Carbon\Carbon::parse($details->created_at)->Format('d-m-Y')}}</td>
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

                     <td class="font-kartu1" colspan="4" width="180">
                    <div
                        style="margin-left:40px; margin-top:-15px; font-size:9spx; width:235px;height: 15px; color:black; font-weight:bold;">
                        DPC @php
                        $namo = \App\Kabupaten::getKab($details->kabupaten_domisili);
                        @endphp {{ ucwords(strtolower($namo->name ?? '-')) }} </div>
                </td>


                </tr>
                <tr>

                    <td class="font-kartu" colspan="4">
                        <div style=" margin-top:5px; width:360px; margin-left:-90px; height:50px;">
                            <div style="float:left;">
                                <table width="310" border="0" cellpadding="0" cellspacing="0" class="bold">

                                    <tbody>
                                        <tr>
                                            <td width="70" rowspan="4">
                                                <?php $master=$details->no_member; $slave=$details->nickname;?>
                                                <!--<img style="margin-left:62px;"-->
                                                <!--    src="data:image/png;base64, {!! base64_encode(QrCode::size(50)->generate($master . ',' .$slave))!!}">-->
                                            </td>


                                        </tr>

                                        <tr>

                                            <td class="font-kartu" align="center" width="90">Ketua</td>
                                            <td class="font-kartu" align="center" width="120">Sekretaris</td>

                                        </tr>
                                        <tr>
                                            @if($ketua == null)
                                            <td align="center" class="ttd-kartu"><img id="ttdKetua" src="" width="90"
                                                    height="10" border="0" alt="ttd ketua"></td>
                                            @else

                                            <td align="center" style="font-weight:bold;" class="ttd-kartu"
                                                align="center"><img id="ttdKetua" src="<?php echo $pic_ketua ?>"
                                                    width="40" height="15" border="0" alt="ttd ketua"></td>
                                            @endif


                                            @if($sekre == null)
                                            <td align="center" class="ttd-kartu"><img id="ttdKetua" src="" width="90"
                                                    height="10" border="0" alt="ttd sekre"></td>
                                            @else
                                            <td align="center" style="font-weight:bold;" class="ttd-kartu"><img
                                                    id="ttdSekre" src="<?php echo $pic_sekre ?>" width="40" height="10"
                                                    border="0" alt="ttd sekre"></td>
                                            @endif


                                        </tr>
                                        <tr>
                                            <td class="font-kartu" align="center">@php
                                                $name_ketua =
                                                \App\DetailUsers::getName($kabupaten->id_ketua_dpc);
                                                @endphp
                                                {{ $ketua->nama ?? 'nama ketua'}}</td>
                                            <td class="font-kartu" align="center">@php
                                                $name = \App\DetailUsers::getName($kabupaten->id_sekre_dpc);
                                                @endphp
                                                {{ $sekre->nama ?? 'nama sekre'}}</td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                          @if($kantor == null)
                            <div align="center"><img alt="cap kantor notfound" width="40"></div>
                            @else
                            <div style="float:left; margin-left:225px; margin-top:-5px;">
                                <img src="<?php echo $pic ?>" alt="cap kantor notfound" width="50" height="32">
                            </div>
                            @endif
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @endforeach

</body>

</html>
