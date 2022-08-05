    @extends('layouts.master')
    @section('content')

    
    <x-alert></x-alert>
    <div class="card">
        <div class="card-header">
            Pengesahan Anggota
        </div>
        
        <div class="col-lg-8">
        <div class="alert alert-dark" role="alert">
        DPC Dapat memverifikasi anggota yang sudah diinput dengan status "Aktif" / "Ditolak" .
        </div>
       </div>
     

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover" id="anggota" width="100%">
                    <thead>
                        <tr style="font-size:12px;">
                            <th><input type="checkbox" name="select_all" value="1" id="anggota-select-all"></th>
                           
                            <th>
                                NIK
                            </th>
                            <th>
                                Nama
                            </th>
                            <th>
                                Dikeluarkan
                            </th>
                            <th>
                                Tempat/Tgl Lahir
                            </th>
                             <th>
                                Jenis Kelamin
                            </th>
                            <th>
                                Last Update
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Status</th>

                            <th>

                                <select disabled name="form_select" id="test" class="form-control"
                                    onchange="showDiv(this)">
                                    <option value="0">Pending</option>
                                    <option value="1">Aktif</option>
                                    <option value="2">Ditolak</option>
                                </select>
                            </th>
                            <th colspan="6"></th>

                        </tr>
                    </tfoot>
                </table>

                <div id="hidden_div" style="display:none;">

                    <div class="form-group {{ $errors->has('tgl_pengesahan') ? 'has-error' : '' }}">
                        <label for="tgl_pengesahan">Tanggal Pengesahan <span style="color: red">* (wajib
                                diisi)</span></label>
                        <input type="date" id="tgl_pengesahan" name="tgl_pengesahan" class="form-control"
                            value="{{ old('tgl_pengesahan', date('Y-m-d')) }}">
                        @if($errors->has('tgl_pengesahan'))
                        <em class="invalid-feedback">
                            {{ $errors->first('tgl_pengesahan') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>

                    <div class="modal-footer">
                        <a href="{{ route('dpc.pending.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                        <button type="submit" onclick="akftifstatus()" style="background-color:#D6A62C; color:#FFFF;"
                            id="button_aktif" disabled class="btn float-left">
                            Status Anggota Aktif
                        </button>
                    </div>

                </div>
                <div id="hidden_div2" style="display:none;">

                    <div class="form-group {{ $errors->has('id_anggota') ? 'has-error' : '' }}">


                    </div>

                    <div class="form-group">
                        <label for="Content">Alasan Penolakan <span style="color: red">* (Wajib
                                diisi)</span></label>
                        <textarea class="form-control my-editor" rows="8" name="alasan_pembatalan" required
                            id="alasan_pembatalan"> </textarea>
                        @error('alasan_pembatalan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('dpc.pending.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>

                        <button type="submit" onclick="nonaktif()"
                            style="background-color:#D6A62C; color:#FFFF;  margin-left:10px;" id="button_nonaktif"
                            disabled class="btn float-left">
                            Status Anggota Pending
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>

    @endsection
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

    <script type="text/javascript">
        function submit_form() {
            document.form1.submit();
            document.form2.submit();
        }

        function showDiv(select) {
            if (select.value == 1) {
                document.getElementById('hidden_div').style.display = "block";
            } else {
                document.getElementById('hidden_div').style.display = "none";
            }

            if (select.value == 2) {
                document.getElementById('hidden_div2').style.display = "block";
            } else {
                document.getElementById('hidden_div2').style.display = "none";
            }
        }

    </script>
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
            // $('#anggota thead tr')
            //     .clone(true)
            //     .addClass('filters')
            //     .appendTo('#anggota thead');
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
                           /*
                        {
                            extend: 'excel',

                            title: 'Laporan Anggota',

                            footer: true,
                            exportOptions: {
                                columns: ':visible'
                            }
                        }
                        */
                        {
                            extend: 'pdf',
                          className: 'btn btn-pdf',
                            title: 'Laporan anggota ',
                        
                            footer: true,
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                             className: 'btn btn-pdf',
                            title: 'Laporan anggota ',
                         
                            footer: true,
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                    ],

                    initComplete: function () {
                        var api = this.api();

                        // For each column
                        api
                            .columns()
                            .eq(0)
                            .each(function (colIdx) {
                                // Set the header cell to contain the input element
                                var cell = $('.filters th').eq(
                                    $(api.column(colIdx).header()).index()
                                );
                                var title = $(cell).text();
                                $(cell).html('<input type="text" placeholder="' + title +
                                    '" style="width:50%; font-size:12px; text-align:center;" />'
                                );

                                // On every keypress in this input
                                $(
                                        'input',
                                        $('.filters th').eq($(api.column(colIdx).header())
                                            .index())
                                    )
                                    .off('keyup change')
                                    .on('keyup change', function (e) {
                                        e.stopPropagation();

                                        // Get the search value
                                        $(this).attr('title', $(this).val());
                                        var regexr =
                                            '({search})';
                                        // $(this).parents('th').find('select').val();

                                        var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != '' ?
                                                regexr.replace('{search}', '(((' + this
                                                    .value +
                                                    ')))') :
                                                '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();

                                        $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition,
                                                cursorPosition);
                                    });
                            });
                    },

                    ajax: {
                        url: '/dpc/ajax/ajax_acc_anggota',
                        get: 'get',
                        data: {
                            from: from,
                            to: to
                        }

                    },

                    'columnDefs': [{
                            targets: '_all',
                            visible: true
                        },

                        {
                            'targets': 0,
                            'searchable': false,
                            'sortable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function (data, type, meta, row) {
                                return '<input type="checkbox" class="cb-child" value="' + $(
                                    '<div/>').text(data).html() + '">';
                            }
                        }
                    ],
                    'order': [
                        [1, 'desc']
                    ],

                    columns: [{
                            data: 'id',
                            name: 'id',

                        },
                       
                        {
                            data: 'nik',
                            name: 'nik',

                        },
                        {
                            data: 'name',
                            name: 'name',

                        },
                        {
                            data: 'jabatan',
                            name: 'jabatan',

                        },
                        {
                            data: 'tempat_lahir',
                            name: 'tempat_lahir',

                        },
                         {
                            data: 'no_anggota',
                            name: 'no_anggota',

                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal',

                        },
                        {
                            data: 'action',
                            name: 'action',
                            className: "text-center"

                        },

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
            // Handle click on "Select all" control
            $('#anggota-select-all').on('click', function () {
                
                var isChecked = $("#anggota-select-all").prop('checked')
                $(".cb-child").prop('checked', isChecked)
                $("#test").prop('disabled', !isChecked)
                $("#button_aktif").prop('disabled', !isChecked)
                $("#button_nonaktif").prop('disabled', !isChecked)
            });

            // Handle click on checkbox to set state of "Select all" control
            $('#anggota tbody').on('click', '.cb-child', function () {
                if ($(this).prop('checked') != true) {
                    $("#anggota-select-all").prop('checked', false)
                }

                let all_checkbox = $("#anggota tbody .cb-child:checked")

                let button_aktif_status = (all_checkbox.length > 0)
                $("#test").prop('disabled', !button_aktif_status)
                $("#button_aktif").prop('disabled', !button_aktif_status)
                $("#button_nonaktif").prop('disabled', !button_aktif_status)

            });


        });

    </script>
    <script>



        function akftifstatus() {

             // $(this).html('Sending..');
            let checkbox = $("#anggota tbody .cb-child:checked")
            let tgl_pengesahan = $("#tgl_pengesahan").val();
            if (tgl_pengesahan == '') {
                swal('Error', 'Tanggal Pengesahan Tidak Boleh Kosong');
                return false;
            }
            let semua_id = []

            $.each(checkbox, function (index, elm) {
                semua_id.push(elm.value)
            })
            $.ajax({
                url: "{{route ('dpc.pending.updateaktif')}}",
                method: 'post',
                data: {
                    ids: semua_id,
                    tgl_pengesahan: tgl_pengesahan
                },
                success: function (res) {
                    document.location.reload(null, false)
                    $("#button_aktif").prop('disabled', false)
                    $("#button_nonaktif").prop('disabled', false)
                    $("#anggota-select-all").prop('checked', false)
                }
            })
        }
        function nonaktif() {

            let checkbox = $("#anggota tbody .cb-child:checked")
            let semua_id = []
            let alasan_pembatalan = $("#alasan_pembatalan").val();
            if (alasan_pembatalan == '') {
                swal('Error', 'Alasan Pembalasan Tidak Boleh Kosong');
                return false;
            }

            $.each(checkbox, function (index, elm) {

                semua_id.push(elm.value)
                // console.log(semua_id)
            })

            $.ajax({
                url: "{{route ('dpc.pending.updatenonaktif')}}",
                method: 'post',
                data: {
                    ids: semua_id,
                    alasan_pembatalan : alasan_pembatalan
                },
                success: function (res) {
                   document.location.reload(null, false)
                    $("#button_aktif").prop('disabled', false)
                    $("#button_nonaktif").prop('disabled', false)
                    $("#anggota-select-all").prop('checked', false)
                }
            })
        }

    </script>
    @stop
