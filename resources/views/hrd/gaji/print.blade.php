<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Penggajian Karyawan</title>
    <style>
        @page {
            width: 230mm;
            height: 947mm;
            margin-top: 90px;
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

    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="border border-3">
                <div class="dashboard-logo">
                    <img style="width:180px;" src="{{url('/img/logo/yazfi.png ')}}" alt="Image" />
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <table cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>:</th>
                                    <th>{{ $gaji->pegawai->no_ktp }}</th>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <th>:</th>
                                    <th>{{ $gaji->pegawai->name }}</th>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <th>:</th>
                                    <th>{{ $gaji->jabatan }}</th>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>:</th>
                                    <th>{{ Carbon\Carbon::parse($gaji->tanggal)->isoFormat('dddd, D MMMM Y') }}</th>
                                </tr>
                                <tr>
                                    <th>Bulan dan Tahun </th>
                                    <th>:</th>
                                    <th>{{ Carbon\Carbon::parse($gaji->bulan_tahun)->isoFormat('MMMM, Y') }}</th>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <br>

                    <hr>
                    <table class="table table-borderless">
                        <tr>
                            <td style="padding-right: 100px;">
                                <table cellspacing="5" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th>Penerimaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gaji->penerimaan as $data)
                                        <tr>
                                            <td>{{ $data->nama }}</td>
                                            <td>:</td>
                                            <td>{{ number_format($data->nominal) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Total Penerimaan</th>
                                            <th>:</th>
                                            <th>{{ number_format($gaji->penerimaan->sum('nominal')) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                            <td>
                                <table cellspacing="5" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th>Potongan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gaji->potongan as $data)
                                        <tr>
                                            <td>{{ $data->nama }}</td>
                                            <td>:</td>
                                            <td>{{ number_format($data->nominal) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total Potongan</th>
                                            <th>:</th>
                                            <th>{{ number_format($gaji->potongan->sum('nominal')) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <hr>

                    <div class="col-md-6">
                        <table cellspacing="5" cellpadding="5">
                            <thead>
                                <tr>
                                    <th>THP</th>
                                    <th>:</th>
                                    <th>
                                        {{ number_format($gaji->penerimaan->sum('nominal') - $gaji->potongan->sum('nominal')) }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <br>
                        <br>

                        <table class="table table-borderless">
                            <tr>
                                <td style="padding-right: 100px;">
                                    <table cellspacing="5" cellpadding="5">
                                        <thead>
                                            <tr>
                                                <h2 style="font-size: 18px">PayRoll</h2>
                                            </tr>
                                        </thead>
                                        <br>
                                        <br>

                                        <tfoot>
                                            <h2 style="font-size: 18px">
                                                <hr style="border : 2px solid black;">
                                                </h4>
                                        </tfoot>
                                    </table>
                                </td>
                                <td style="padding-right: 100px;">
                                    <table cellspacing="5" cellpadding="5">
                                    
                                    </table>
                                </td>
                                <td>
                                    <table cellspacing="5" cellpadding="5">
                                        <thead>
                                            <tr>
                                                <h2 style="font-size: 18px">DiTerima Oleh</h2>
                                                <br>
                                                <br>
                                                <h2 style="font-size: 18px">{{ $gaji->pegawai->name }}</h4>
                                            </tr>
                                        </thead>
                                    </table>
                                </td>
                            </tr>
                        </table>

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
