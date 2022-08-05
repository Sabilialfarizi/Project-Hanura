@extends('layouts.master')
@section('content')

<!--<div class="card">-->
<!--    <div class="card-header">-->
<!--        Member Report-->
<!--    </div>-->
<!--    <div class="card-body">-->
<!--        <div class="row input-daterange">-->
<!--            <div class="col-sm-6 col-md-3">-->
<!--                <div class="form-group form-focus">-->
<!--                    <label class="focus-label">From</label>-->
<!--                    <div class="cal-icon">-->
<!--                        <input type="text" name="from" id="from" class="form-control" placeholder="From Date" />-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="col-sm-6 col-md-3">-->
<!--                <div class="form-group form-focus">-->
<!--                    <label class="focus-label">To</label>-->
<!--                    <div class="cal-icon">-->
<!--                        <input type="text" name="to" id="to" class="form-control" placeholder="To Date" />-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="col-sm-6 col-md-3">-->
<!--                <div style="margin-top:8px;">-->
<!--                    <button type="button" name="filter" id="filter" class="btn btn-primary"><i-->
<!--                            class="fa-solid fa-magnifying-glass"></i></button>-->
<!--                    <button type="button" name="refresh" id="refresh" class="btn btn-danger"><i-->
<!--                            class="fa-solid fa-arrows-rotate"></i></button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

<!--    </div>-->
<!--</div>-->

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a style="background-color:#D6A62C; color:#FFFF;" class="btn float-right" href="{{ route('dpd.pembatalan.create') }}">
            <i class="fa fa-plus"></i> Add Pembatalan Anggota
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        List Pembatalan Anggota
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="report table table-bordered table-striped table-hover datatable" id="pembatalan" width="100%">
                <thead>
                    <tr>
                         <th><input type="checkbox" name="select_all" value="1" id="pembatalan-select-all"></th>

                        <th>
                            No. KTA
                        </th>
                        <th>
                            Nama
                        </th>
                        <th>
                            NIK
                        </th>
                        <th>
                            Alamat
                        </th>
                        <th>
                            Alasan Pembatalan
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
             <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12 col-md-12 col-xl-12">
                      
                        <button type="submit" onclick="receivedstatus()" style="background-color:#D6A62C; color:#FFFF;  margin-left:10px;" id="button_nonaktif" disabled class="btn float-left">
                           Menolak Pembatalan
                        </button>
                     <button type="submit" onclick="failstatus()" style="background-color:#D6A62C; color:#FFFF;  margin-left:10px;;" id="button_aktif" disabled class="btn float-left">
                           Menerima Pembatalan
                        </button>
                   
                       
                </div>
               
            </div>
        </div>
    </div>
</div>
@stop


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
        // $('#pembatalan thead tr')
        //     .clone(true)
        //     .addClass('filters')
        //     .appendTo('#pembatalan thead');
        load_data();


        function load_data(from = '', to = '') {
            var from = $('#from').val();
            var to = $('#to').val();

            var table = $('#pembatalan').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                fixedHeader: true,
                "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                        extend: 'copy',
                        className: 'btn-default',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-default',
                        title: 'Laporan Pembatalan Anggota',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Laporan Pembatalan Anggota ',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        title: 'Laporan Pembatalan Anggota ',
                        messageTop: 'Tanggal: ' + from + ' - ' + to + ' ',
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
                                '" style="width:70%; text-align:center;" />');

                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
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
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();

                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },

                ajax: {
                    url: '/dpd/ajax/ajax_pembatalan',
                    get: 'get',
                    data: {
                        from: from,
                        to: to
                    }

                },
                'columnDefs': [
                    { targets: '_all' , visible: true},
                    
                    {'targets': 0,
                    'searchable': false,
                    'sortable' :false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function (data, type, meta, row) {
                        return '<input type="checkbox" class="cb-child" value="' + $('<div/>').text(data).html() + '">';
                    }
                }],
                'order': [
                    [1, 'desc']
                ],

                columns: [{
                        data: 'id',
                        name: 'id',
                        className: "text-center"
                    },
                    {
                        data: 'no_anggota',
                        name: 'no_anggota',
                    
                    },
                    {
                        data: 'name',
                        name: 'name',
                      
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                      
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                      
                    },
                    {
                        data: 'alasan',
                        name: 'alasan',
                      
                    },
                    {
                        data: 'status',
                        name: 'status',
                      
                    },
                    {
                        data: 'action',
                        name: 'action',
                      
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
        $('#pembatalan-select-all').on('click', function () {
            var isChecked = $("#pembatalan-select-all").prop('checked')
            $(".cb-child").prop('checked', isChecked)
            $("#button_aktif").prop('disabled', !isChecked)
            $("#button_nonaktif").prop('disabled', !isChecked)
           
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#pembatalan tbody').on('click','.cb-child', function () {
            if($(this).prop('checked')!=true){
            $("#pembatalan-select-all").prop('checked',false)
            }
            
            let all_checkbox = $("#pembatalan tbody .cb-child:checked ")
      
            let button_aktif_status = (all_checkbox.length>0)
            $("#button_aktif").prop('disabled', !button_aktif_status)
            $("#button_nonaktif").prop('disabled', !button_aktif_status)
  
           
        });
        
       
    });

</script>
<script>
  function receivedstatus() {
           
            let checkbox = $("#pembatalan tbody .cb-child:checked")
            let semua_id = []
           
            $.each(checkbox , function(index,elm){
              
                semua_id.push(elm.value)
                //   console.log(semua_id)
            })
            
            $.ajax({
                url:"{{route ('dpd.pembatalan.updateacc')}}",
                method:'post',
                data:{ids:semua_id},
                success:function(res){
                  
                     $('#pembatalan').DataTable().ajax.reload();
                    
                       $("#button_aktif").prop('disabled', true)
                     $("#button_nonaktif").prop('disabled', true)
            
                        $("#pembatalan-select-all").prop('checked',false)
                }
                
            })
        }
     function failstatus() {
           
            let checkbox = $("#pembatalan tbody .cb-child:checked")
            let semua_id = []
           
            $.each(checkbox , function(index,elm){
              
                semua_id.push(elm.value)
                // console.log(semua_id)
            })
            
            $.ajax({
                url:"{{route ('dpd.pembatalan.updatefail')}}",
                method:'post',
                data:{ids:semua_id},
                success:function(res){
                    
                    $('#pembatalan').DataTable().ajax.reload();
                     $("#button_aktif").prop('disabled', true)
                     $("#button_nonaktif").prop('disabled', true)
                  
                        $("#pembatalan-select-all").prop('checked',false)
                }
                
            })
        }

</script>

@stop