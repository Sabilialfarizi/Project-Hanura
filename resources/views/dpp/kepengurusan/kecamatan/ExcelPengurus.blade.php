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
                <th style="text-align:center;">Nama</th>
                <th style="text-align:center;">Jabatan</th>
                <th style="text-align:center;">Kode Jabatan</th>
                <th style="text-align:center;">NIK</th>
                <th style="text-align:center;">No. KTA</th>
                <th style="text-align:center;">No. SK</th>
                <th style="text-align:center;">Alamat Kantor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kepengurusan as $data)
        
            <tr>
                <td>{{$loop->iteration}}</td>
                <td> {{ $data->nama ?? '-' }} </td>
                <td> {{ $data->nama_jabatan ?? '-' }} </td>
                <td> {{ $data->jabatan ?? '-' }} </td>
                <td> {{ $data->nik ?? '-' }} </td>
                <td>{{$data->kta ?? '-'}}</td>
                <td>{{$data->no_sk ?? '-'}}</td>
                <td>{{$data->alamat_kantor ?? '-'}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>