<!DOCTYPE html>
<html>

<head>
    <title>Export</title>
    <style>
        .str {
            mso-number-format: \@ !important;
        }
    </style>
    <?php
    header('Content-type: application/vnd-ms-excel');
    header('Content-Disposition: attachment; filename=Data Pegawai.xls');
    ?>
</head>

<body>
    <table>
        <thead>

            <tr>
                <th>No</th>
                <th>No. KTA</th>
                <th>Penerbit KTA</th>
                <th>Nama</th>
                <th>NIK <br>(16 digit)</th>
                <th>Jenis Kelamin</th>
                <th>Tempat lahir</th>
                <th>Tanggal lahir <br>(dd-mm-yyyy)</th>
                <th>Status Perkawinan <br>S= Sudah, B=Belum, P=Pernah</th>
                <th>Status Pekerjaan</th>
                <th>Alamat</th>
                <th>Id Kelurahan KPU <br>
                    (Bisa dilihat di <br>
                    Download ID Wilayah)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $data)
                @php
                    $nik = '' . $data->nik;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td> {{ $data->no_member ?? '-' }} </td>
                    <td> @php
                        $nama_penerbit = \App\Kabupaten::getKab($data->kabupaten_domisili);
                    @endphp
                        {{ $nama_penerbit->name ?? '-' }}</td>
                    <td>{{ ucwords(strtolower($data->nickname ?? '-')) }}</td>
                    <td style="mso-number-format: \@;">{!! number_format($data->nik, 0, ' ', '') !!}</td>
                    <td>{{ $data->gender == 'Laki-Laki' ? 'L' : 'P' }}</td>
                    <td>{{ $data->birth_place ?? '-' }}</td>
                    <td style="mso-number-format: \@;">{!! date('d-m-Y', strtotime($data->tgl_lahir)) !!}</td>
                    @if ($data->nama == 'Belum Kawin')
                        <td>{{ $data->nama ? 'B' : '-' }}</td>
                    @elseif($data->nama == 'Pernah')
                        <td>{{ $data->nama ? 'P' : '-' }}</td>
                    @elseif($data->nama == 'Sudah')
                        <td>{{ $data->nama ? 'S' : '-' }}</td>
                    @else
                        <td>-</td>
                    @endif
                    @if ($data->name != 'Kepolisisan' && $data->name != 'Pegawai Negeri Sipil' && $data->name != 'Tentara Nasional Indonesia')
                        <td>LAINNYA</td>
                    @else
                        <td>{{ $data->name ?? '-' }}</td>
                    @endif
                    <td>{{ $data->alamat ?? '-' }}</td>
                    <td>{{ $data->id_kpu == 0 ? $data->kelurahan_domisili : $data->id_kpu }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
