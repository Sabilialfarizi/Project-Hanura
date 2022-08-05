@extends('layouts.master')

@section('content')

<style>
    .click-zoom input[type=checkbox] {
    display: none
    }
    
    .click-zoom img {
        transition: transform 0.25s ease;
        cursor: zoom-in
    }

    .click-zoom input[type=checkbox]:checked~img {
    transform: scale(3);
    cursor: zoom-out
    }
</style>

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a   style="background-color:#D6A62C; color:#FFFF;" class="btn float-right btn-lg" href="{{ '/dpp/provinsi/'. $provinsi->id_prov .'/kepengurusan/create' }}">
            <i class="fa fa-plus"></i> Add Kepengurusan
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        List Kepengurusan DPD Provinsi {{ $provinsi->name }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="report table table-bordered table-striped table-hover datatable" id="anggota" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Kode Jabatan</th>
                        <th>No. KTA</th>
                        <th>NIK</th>
                        <th>No. SK</th>
                        <th>Foto</th>
                        <th>TTD</th>
                        <th>Alamat Kantor</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

<style>
        .table.dataTable {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }

        .btn.btn-pdf {
            background-color: #D6A62C;
        }
       
    </style>
@section('footer')
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function () {
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        $.noConflict();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        load_data();

        function load_data(from = '', to = '') {
            var from = $('#from').val();
            var to = $('#to').val();

            var table = $('#anggota').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                fixedHeader: true,
                "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-pdf',
                        title: 'Laporan anggota',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-pdf',
                        title: 'Laporan anggota ',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-pdf',
                        title: 'Laporan anggota ',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ],

                ajax: {
                    url: '/dpp/ajax/ajax_kepengurusan_provinsi',
                    get: 'get',
                    data: {
                        from: from,
                        to: to,
                        id_daerah: {{ $provinsi->id_prov }},
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                   
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        width: '20%',
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan',
                        width: '20%',
                    },
                    {
                        data: 'kode_jabatan',
                        name: 'kode_jabatan',
                        width: '20%',
                    },
                    {
                        name: 'kta',
                        data: 'kta',
                        width: '20%',
                    },
                    {
                        name: 'nik',
                        data: 'nik',
                        width: '20%',
                    },
                    {
                        name: 'no_sk',
                        data: 'no_sk',
                        width: '20%',
                    },                   
                    {
                        name: 'foto',
                        data: 'foto',
                        width: '20%',
                    },
                    {
                        name: 'ttd',
                        data: 'ttd',
                        width: '20%',
                    },
                    {
                        name: 'alamat_kantor',
                        data: 'alamat_kantor',
                        width: '20%',
                    },
                    {
                        name: 'action',
                        data: 'action',
                        width: '20%',
                    }

                ],


            });
        }
        $('#filter').click(function () {
            var from = $('#from').val();
            var to = $('#to').val();
            if (from != '' && to != '') {
                $('#anggota').DataTable().destroy();
                load_data(from, to);
            } else {
                alert('Pilih Tanggal Terlebih Dahulu');
            }
        });
        $('#refresh').click(function () {
            $('#from').val('');
            $('#to').val('');
            $('#anggota').DataTable().destroy();
            load_data();
        });
    });

</script>
@stop
