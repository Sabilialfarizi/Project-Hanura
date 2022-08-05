@extends('layouts.master', ['title' => 'Kabupaten'])
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css" />
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css"
    rel="stylesheet" />
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="page-title">Import Anggota DPC
                    </h4>
                </div>
                <div class="col-md-8 d-flex align-items-center justify-content-end">
                    <form>
                        @csrf
                        <button type="button" id="importAnggota" class="btn btn-sm btn-warning text-white"><i
                                class="fa fa-import"></i> Import Anggota</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="import">
                    <thead>
                        <th></th>
                        <th>No. KTA</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Status Perkawinan</th>
                        <th>Status Pekerjaan</th>
                        <th>Kec</th>
                        <th>Kel</th>
                        <th>Alamat</th>
                        <th></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript"
        src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
    <script>
        $(document).ready(function() {
            var app = $('#import').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/dpc/ajax/import/anggota',
                    method: 'GET'
                },
                columns: [{
                        data: 'id'
                        // orderable: false,
                        // render: function(data, type, full, meta) {
                        //     return '<input type="checkbox" class="cb" value="' + data + '"/>';
                        // }
                    },
                    {
                        data: 'kode_anggota'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'ktp'
                    },
                    {
                        data: 'jk'
                    },
                    {
                        data: 'tmp_lhr'
                    },
                    {
                        data: 'tgl_lhr'
                    },
                    {
                        data: 'pernikahan',
                        // render: function(data, type, full, meta) {
                        //     if (data == 1) {
                        //         return 'Menikah';
                        //     }
                        //     return 'Lajang';
                        // }
                    },
                    {
                        data: 'pekerjaan',
                        // render: function(data, type, full, meta) {
                        //     return (data == null) ? '-' : data;
                        // }
                    },
                    {
                        data: 'kec_name'
                    },
                    {
                        data: 'kel_name'
                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                'columnDefs': [{
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                        'selectAll': false
                    }
                }],
                'select': {
                    'style': 'multi'
                },
                order: [
                    [1, 'asc']
                ]
            });

            $('#importAnggota').click(function(e) {
                e.preventDefault();
                var rows_selected = app.column(0).checkboxes.selected();

                if (rows_selected.length > 0) {
                    var $this = $(this).parent();
                    $.each(rows_selected, function(index, rowId) {
                        $this.append('<input type="hidden" name="id[]" value="' + rowId + '">');
                    });

                    var form = $this.serialize();

                    $.ajax({
                        url: '/dpc/ajax/add/import/anggota',
                        type: 'POST',
                        data: form,
                        success: function(res) {
                            if (res.status) {
                                app.ajax.reload();
                                swal('Berhasil melakukan Import');
                            }
                        }
                    });
                } else {
                    swal('Silahkan centang kotak untuk anggota yang akan diimport');
                }
            });

            $('#import').on('change', '.dt-checkboxes', function() {
                console.log('tes');
                var tr = $(this).parent().parent();
                var data = app.row(tr).data();
                if (data.pekerjaan == null && data.agama == null && data.pernikahan == null && data.foto ==
                    null && data.foto_ktp == null) {
                    var content = document.createElement('div');
                    content.innerHTML = 'Tidak dapat mengimport <strong>' + data.nama +
                        '</strong> (silahkan lengkapi data pribadi)';
                    swal({
                        content: content,
                        title: 'Gagal',
                        icon: 'error'
                    });
                    $(this).prop('checked', false);
                }
            });
        });
    </script>
@endsection
