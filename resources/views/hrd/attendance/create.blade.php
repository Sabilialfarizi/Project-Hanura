@extends('layouts.master', ['title'=>'asd'])
@section('content')
<table id="table-jadwal" class="table table-striped">
    <thead class="text-center">
        <tr>
            <th>no</th>
            <th>tanggal</th>
            <th>kode</th>
            <th>input</th>
            <th>Id</th>
        </tr>
    </thead>
    <tbody class="text-center"></tbody>
</table>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js" integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#table-jadwal').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,   
            ajax: ({
                url: `/admin/attendance/1`,
                type: 'get',
                error: err => {s
                    console.error(err)
                }
            }),
            columns: [
                {
                    name: "no",
                    data: "no"
                },
                {
                    name: "tanggal",
                    data: "tanggal"
                },
                {
                    name: "kode",
                    data: "kode"
                },
                {
                    name: "input",
                    data: "input"
                },
                {
                    data: 'DT_RowIndex'
                }
            ]
        })
    })
</script>
@stop
