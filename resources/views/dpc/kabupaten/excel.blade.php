<html>

<head>

    <style>
        .str{ mso-number-format:\@; }
        .br {
               display: block;
               margin: -24px 0;
            }
    </style>
</head>

<body>
    <table class="tb">
        <thead>
            <tr >
                <th style="text-align:center;">No.</th>
                <th style="text-align:center;">Waktu</th>
                <th style="text-align:center;">No. KTA</th>
                <th style="text-align:center;">Nama</th>
                <th style="text-align:center;">NIK</th>
                <th style="text-align:center;">Jenis Kelamin</th>
                <th style="text-align:center;">Tempat Lahir</th>
                <th style="text-align:center;">Tanggal Lahir</th>
                <th style="text-align:center;">Status Perkawinan </th>
                <th style="text-align:center;">Status Pekerjaan</th>
                <th style="text-align:center;">Alamat</th>
                <th style="text-align:center;">Kode Kecamatan</th>
                <th style="text-align:center;">Nama Kecamatan</th>
                <th style="text-align:center;">Kode Kelurahan</th>
                <th style="text-align:center;">Nama Kelurahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $data)
        
            <tr>
                <td>{{$loop->iteration}}</td>
                <td> {{ $data->created_at ?? '-' }} </td>
                <td> {{ $data->no_member ?? '-' }} </td>
                <td>{{$data->nickname ?? '-'}}</td>
                <td >{{$data->nik}}</td>
                 <td>{{$data->gender == 'Laki-Laki' ? 'L' : 'P' }}</td>
                <td>{{$data->birth_place ?? '-'}}</td>
                <td>{{ Carbon\Carbon::parse($data->tgl_lahir)->isoFormat('DD-MM-YYYY') }} </td>
                @if($data->nama == 'Belum Kawin')
                <td>{{$data->nama ? 'Belum Kawin' : '-'}}</td>
                @elseif($data->nama == 'Pernah')
                <td>{{$data->nama ? 'Pernah' : '-'}}</td>
                @elseif($data->nama == 'Sudah')
                  <td>{{$data->nama ? 'Sudah' : '-'}}</td>
                @else
                 <td>-</td>
                @endif
                  @if($data->name != 'Kepolisisan' && $data->name != 'Pegawai Negeri Sipil' && $data->name != 'Tentara Nasional Indonesia')
                <td>LAINNYA</td>
                @else
                <td>{{$data->name ?? '-'}}</td>
                @endif
                <td>{{$data->alamat ?? '-'}}</td>
                <td>{{$data->kecamatan_domisili ?? '-'}}</td>
               @php
                 $nama_kec= \App\Kecamatan::getKec($data->kecamatan_domisili);
               @endphp
                <td>{{$nama_kec->name ?? '-'}}</td>
                <td>{{$data->kelurahan_domisili ?? '-'}}</td>
                @php
                 $nama_kel= \App\Kelurahan::getKel($data->kelurahan_domisili);
               @endphp
                <td>{{$nama_kel->name ?? '-'}}</td>
                

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>