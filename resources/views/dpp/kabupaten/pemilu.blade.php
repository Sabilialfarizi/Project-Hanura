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
                <th style="text-align:center;">No. KTA</th>
                <th style="text-align:center;">Penerbit KTA</th>
                <th style="text-align:center;">Nama</th>
                <th style="text-align:center;">NIK <br>(16 digit)</th>
                <th style="text-align:center;">Jenis Kelamin</th>
                <th style="text-align:center;">Tempat Lahir</th>
                <th style="text-align:center;">Tanggal Lahir <br>(dd-mm-yyyy)</th>
                <th style="text-align:center;">Status Perkawinan <br>S=Sudah, B=Belum, P=Pernah</th>
                <th style="text-align:center;">Status Pekerjaan</th>
                <th style="text-align:center;">Alamat</th>
                <th style="text-align:center;">Id Kelurahan KPU <br>
                (Bisa dilihat di
                Download ID Wilayah)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $data)
        
            <tr>
                <td>{{$loop->iteration}}</td>
                <td> {{ $data->no_member ?? '-' }} </td>
                <td> @php
                    $nama_penerbit = \App\Kabupaten::getKab($data->kabupaten_domisili);
                    @endphp
                    {{ $nama_penerbit->name ?? '-' }}</td>
                <td>{{ucwords(strtolower($data->nickname ?? '-'))}}</td>
                <td >{{$data->nik}}</td>
                <td>{{$data->gender == 'Laki-Laki' ? 'L' : 'P' }}</td>
                <td>{{$data->birth_place ?? '-'}}</td>
                <td>{{ Carbon\Carbon::parse($data->tgl_lahir)->isoFormat('DD-MM-YYYY') }} </td>
                @if($data->nama == 'Belum Kawin')
                <td>{{$data->nama ? 'B' : '-'}}</td>
                @elseif($data->nama == 'Pernah')
                <td>{{$data->nama ? 'P' : '-'}}</td>
                @elseif($data->nama == 'Sudah')
                  <td>{{$data->nama ? 'S' : '-'}}</td>
                @else
                 <td>-</td>
                @endif
                @if($data->name != 'Kepolisisan' && $data->name != 'Pegawai Negeri Sipil' && $data->name != 'Tentara Nasional Indonesia')
                <td>LAINNYA</td>
                @else
                <td>{{$data->name ?? '-'}}</td>
                @endif
                <td>{{$data->alamat ?? '-'}}</td>
                <td >{{$data->id_kpu == 0 ? $data->kelurahan_domisili : $data->id_kpu}} </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>