@extends('layouts.doc', ['title' => 'Tabel Perawatan'])

@section('body')

<body onload="" class="A4">
    <section class="sheet padding-15mm">
        <div class="header-doc" style="display: flex; margin-top: -20px; margin-bottom: 30px;">
            <div class="img" style="margin-right: auto;">
                <img src="{{ asset('/storage/' . \App\Setting::find(1)->logo) }}" alt="" width="100px">
            </div>
            <div class="title" style="margin-right: auto;">
                <h3 align="center">TABEL PERAWATAN</h3>
            </div>
            <div class="box" style="border: 1px solid black; border-radius: 20px; height: 60px; width: 150px; text-align: center;">
                <h5>No. Rekam Medik : {{ $customer->rekam_medik }}</h5>
            </div>
        </div>

        <table style="display: inline-block;">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $customer->nama }}</td>
            </tr>
        </table>
        <table style="float: right;">
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $customer->jk }}</td>
            </tr>
        </table>
        <hr>

        <table border="1" width="100%" style="border-collapse: collapse; text-align: center;">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Anamnesa</th>
                    <th>Gigi</th>
                    <th>Kondisi</th>
                    <th>Kode</th>
                    <th>Perawatan</th>
                    <th>Paraf</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $ryt)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($ryt->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $ryt->keterangan }}</td>
                    <td>{{ $ryt->no_gigi }}</td>
                    <td>{{ $ryt->simbol->nama_simbol }}</td>
                    <td>{{ $ryt->simbol->singkatan }}</td>
                    <td>{{ $ryt->tindakan}}</td>
                    <td>{{ $ryt->user->name }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </section>
</body>
@stop