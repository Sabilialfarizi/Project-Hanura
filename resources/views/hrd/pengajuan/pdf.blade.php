<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="yoriadiatma">
    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Pengajuan Dana</title>
    <style>
        @page {
            width: 230mm;
            height: 987mm;
            margin-top: 90px;
        }

        @media screen {

            body {

                font-family: 'Rubik', sans-serif;
                font-size: 0.875rem;
                color: #666;
                background-color: #fafafa;
                overflow-x: hidden;
                height: 100%;
            }


            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm auto;
                display: block;
            }
        }

        .bg-success,
        .badge-success {
            background-color: #5559ce !important;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }

        table.table td h2 {
            display: inline-block;
            font-size: inherit;
            font-weight: 400;
            margin: 0;
            padding: 0;
            vertical-align: middle;
        }

        table.table td h2 a {
            color: #757575;
        }

        table.table td h2 a:hover {
            color: #009efb;
        }

        table.table td h2 span {
            color: #9e9e9e;
            display: block;
            font-size: 12px;
            margin-top: 3px;
        }

    </style>
</head>

<body>
    @foreach ($pengajuan as $peng)

    @endforeach

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-1 body-main">

                <table class="table table-borderless">
                    <tr>
                        <td style="padding-right: 100px;">
                            <table cellspacing="5" cellpadding="5">

                                <tbody>

                                    <div class="dashboard-logo">
                                        <img style="width:180px;" src="{{url('/img/logo/yazfi.png ')}}" alt="Image" />
                                    </div>


                                </tbody>
                            </table>
                        </td>
                        <td style="padding-right: 150px;">

                        </td>
                        <td>
                            <table cellspacing="5" cellpadding="5">

                                <tbody>

                                    <tr>
                                        <h6><span
                                                style="font-size: 15px; color:white; background-color:blue;">{{$peng->nomor_pengajuan}}</span>
                                        </h6>
                                    </tr>


                                </tbody>

                            </table>
                        </td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2><span style="color:blue; text-decoration: underline; font-size: 20px">Pengajuan
                                Dana</span>
                        </h2>
                    </div>
                </div>
                <br>
                <br>
                <table class="table table-borderless">
                    <tr>
                        <td style="padding-right: 100px;">
                            <table cellspacing="5" cellpadding="5">

                                <tbody style="font-size: 16px; 	font-family: 'Rubik', sans-serif;">

                                    <tr>
                                        <td>Nama </td>
                                        <td>:</td>
                                        <td>{{ $peng->admin->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan </td>
                                        <td>:</td>
                                        <td>{{ $jabatan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Divisi </td>
                                        <td>:</td>
                                        <td>{{ $peng->roles->name }}</td>
                                    </tr>


                                </tbody>
                            </table>
                        </td>
                        <td style="padding-right: 150px;">

                        </td>
                        <td>
                            <table cellspacing="5" cellpadding="5">

                                <tbody style="font-size: 16px; 	font-family: 'Rubik', sans-serif;">

                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>{{ Carbon\Carbon::parse($peng->tanggal_pengajuan)->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lampiran</td>
                                        <td>:</td>
                                        <td>{{ $peng->file }}</td>
                                    </tr>

                                </tbody>

                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr class="bg-success" style="font-size: 14px">
                                <th class="text-light">No.</th>
                                <th class="text-light">Keterangan</th>
                                <th class="text-light">Harga Satuan</th>
                                <th class="text-light">Kwitansi</th>
                                <th style="width:5%;" class="text-light">Qty</th>
                                <th style="width:5%;" class="text-light">Unit</th>
                                <th style="width:5%;" class="text-light">Deskripsi</th>
                                <th class="text-light">Jumlah</th>
                            </tr>
                            <tbody>

                                @php
                                $total = 0
                                @endphp
                                @foreach(App\RincianPengajuan::where('nomor_pengajuan',
                                $peng->nomor_pengajuan)->get() as $barang)
                                <tr style="font-size: 14px">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $barang->barang_id }}</td>
                                    <td>@currency($barang->harga_beli)</td>
                                    <td>{{$barang->no_kwitansi}}</td>
                                    <td>{{$barang->qty}}</td>
                                    <td>{{$barang->unit}}</td>
                                    <td>{{ $barang->keterangan }}</td>
                                    <td>@currency($barang->total)</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7"><strong>Total<strong> </td>
                                    <td colspan="2"><b>@currency($barang->grandtotal)</b></td>
                                </tr>
                                <tr>
                                    <td colspan="8" rowspan="1">Cat :</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p class="text-center">Diajukan Oleh,</p>
                                    </td>
                                    <td colspan="2">
                                        <p class="text-center">DiPeriksa,</p>
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="text-left">Manager</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="text-left">Keuangan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="3">
                                        <p class="text-center">DiSetujui,</p>
                                        <br>
                                        <br>
                                        <p class="text-center">Direktur</p>
                                    </td>
                                    <td colspan="2">
                                        <p class="text-center">DiKetahui,</p>
                                        <br>
                                        <br>
                                        <p class="text-center">Komisaris</p>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
        window.print()

    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>
