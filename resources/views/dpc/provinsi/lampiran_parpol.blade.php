<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hanura</title>
    <link href="styles/popcalendar.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('img/favicon.png')}}">
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
        @media screen {
            #screenarea {
                display: block;
            }

            #printarea {
                display: none;
            }
        }

        @media print {
            #screenarea {
                display: none;
            }

            #printarea {
                display: block;
            }
        }

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

        .table {
            border-collapse: collapse;
            width: 100%;
        }


        .table-border {
            border: 1px solid
        }

        .table-border td,
        .table-border th {
            border: 1px solid;
            font-size: 12px;
        }

        .table-border thead td,
        .table-border thead th {
            border-bottom-width: 2px font-size: 12px;
        }

        .table-borderless tbody+tbody,
        .table-borderless td,
        .table-borderless th,
        .table-borderless thead th {
            border: 0
        }
    </style>
</head>


<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <td style="padding-right: 240px;">

                        </td>
                        <td style="padding-right: 250px;">

                        </td>
                        <td>
                            <div class="panel panel-default">
                                <div class="panel-body" style="border:solid; width:100%; text-align:center;"> LAMPIRAN 1 MODEL F2 PARPOL</div>
                            </div>

                        </td>
                    </tr>
                </table>
                <center>
                    <div class="row">
                        <div class="col-md-12">
                            <p style="margin-bottom:-8px;"><span style="font-size: 15px; font-weight:bold;">REKAPITULASI
                                    JUMLAH ANGGOTA PARTAI POLITIK</span>
                            </p>
                        </div>



                        <div class="col-md-12 text-center">
                            <p style="margin-bottom:-8px;"><span
                                    style="font-size: 15px;  margin-bottom:20px; font-weight:bold;">PARTAI HATI NURANI
                                    RAKYAT
                                    (HANURA)</span>
                            </p>
                        </div>
                        <br>
                        <div class="col-md-12 text-center">
                            <div class="dashboard-logo">
                                <img width="180px;" src="{{ url('img/logo/logo_hanura.PNG') }}">
                            </div>

                        </div>
                    </div>
                </center>
                <br>
                <br>


                <table cellspacing="5" cellpadding="5">
                    <tbody style="font-size: 16px; 	font-family: 'Rubik', sans-serif;">
                        <tr>
                            <td>PROVINSI </td>
                            <td>:</td>
                            <td>{{$get_provinsi->name}}</td>
                        </tr>

                    </tbody>
                </table>


                <div class="table-responsive">
                    <table class="table table-striped table-border " width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>KABUPATEN/KOTA </th>
                                <th>JUMLAH</th>
                                <th>KETERANGAN</th>
                            </tr>

                        </thead>
                        <tbody>

                            @if(count($get_user) == 0)
                            <tr>
                                <td colspan="4" style="text-align:center">Belum Ada Data</td>

                            </tr>
                            @else
                            @foreach($get_user as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->name}}</td>
                                <td style="text-align:center;">{{ \App\DetailUsers::where('detail_users.kabupaten_domisili', $data->id_kab)
                            ->where('detail_users.status_kta', 1)
                            ->where('detail_users.status_kpu', 2)
                            ->count() }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            @endif

                        </tbody>

                    </table>
                </div>
                <div class="col-md-12">

                    <table class="table table-borderless">
                        <tr>
                            <td style="padding-right: 200px;">
                                <table>

                                </table>
                            </td>

                            <td style="padding-right: 100px;">

                            </td>
                            <td>
                                <table>
                                    <thead>
                                        <tr>

                                            <p><span style="font-size: 13px; font-weight:bold;">Jakarta,
                                                    {{Carbon\carbon::now()->isoFormat('D MMMM YYYY')}}</span>
                                            </p>

                                        </tr>

                                    </thead>

                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <center>

                    <div class="row">


                        <div class="col-md-12">
                            <p style="margin-bottom:-8px;"><span style="font-size: 13px; font-weight:bold;">DEWAN
                                    PIMPINAN PUSAT</span>
                            </p>
                        </div>

                        <div class="col-md-12 text-center">
                            <p style="margin-bottom:-8px;"><span style="font-size: 13px;font-weight:bold;">PARTAI HATI
                                    NURANI
                                    RAKYAT
                                    (HANURA)</span>
                            </p>
                        </div>
                    </div>
                </center>
                <br>
                <div class="col-md-12">
                    <br>
                    <br>
                    <table class="table table-borderless">
                        <tr>
                            <td style="padding-right: 50px;">
                                <table cellspacing="5" cellpadding="5">

                                </table>
                            </td>
                            <td>
                                <table cellspacing="5" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <h2 style="font-size: 14px; text-align:center;">Ketua,</h2>
                                            <h2 style="font-size: 18px"> @if($ketua == null)
                                                <img id="ttdKetua" src="" width="100" height="25" border="0"
                                                    alt="ttd ketua">
                                                @else

                                                <img id="ttdKetua"
                                                    src="{{asset('/uploads/img/ttd_kta/' . $ketua->ttd ) ? : '-' }}"
                                                    width="100" height="25" border="0" alt="ttd ketua">
                                                @endif</h2>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <h2 style="font-size: 14px;  text-align:center;">
                                            ({{$ketua->name ??  'Nama Ketua Umum'}})
                                            </h4>
                                    </tfoot>
                                </table>
                            </td>
                            <td style="padding-right: 100px;">
                                <table cellspacing="5" cellpadding="5">
                                     <thead>
                                        <tr>
                                            <h2 style="font-size: 18px"> 
                                            @if($ketua == null)
                                                <img id="cap_kantor" src="" width="100" height="25" border="0"
                                                    alt="cap kantor">
                                                @else

                                                <img id="cap_kantor"
                                                    src="{{asset('/uploads/img/cap_kantor/' . $kantor->cap_kantor ) ? : '-' }}"
                                                    width="100" style="margin-left:120px;" height="85" border="0" alt="cap_kantor">
                                                @endif
                                                </h2>
                                        </tr>
                                    </thead>
                                </table>
                            </td>
                            <td>
                                <table cellspacing="5" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <h2 style="font-size: 14px; text-align:center;">Sekretaris,</h2>

                                            <h2 style="font-size: 18px"> @if($ketua == null)
                                                <img id="ttdKetua" src="" width="100" height="25" border="0"
                                                    alt="ttd ketua">
                                                @else

                                                <img id="ttdKetua"
                                                    src="{{asset('/uploads/img/ttd_kta/' . $sekretaris->ttd ) ? : '-' }}"
                                                    width="100" height="25" border="0" alt="ttd ketua">
                                                @endif</h2>
                                        </tr>

                                    </thead>

                                    <tfoot>
                                        <h2 style="font-size: 14px;  text-align:center;">
                                            ({{$sekretaris->name ??  'Nama Sekretaris Jenderal'}})
                                        </h2>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>


            </div>
        </div>
    </div>

</body>

</html>