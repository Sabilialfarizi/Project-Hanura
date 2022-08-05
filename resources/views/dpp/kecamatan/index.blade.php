@extends('layouts.master', ['title' => 'Kecamatan'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h4 class="page-title">Kecamatan</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<!--<div style="margin-bottom: 10px;" class="row">-->
<!--    <div class="col-lg-12">-->
<!--        <a  style="background-color:#D6A62C; color:#ffff; font-weight:bold;"   class="btn float-right" href="{{ '/dpp/kecamatan/create' }}">-->
<!--            <i class="fa fa-plus"></i> Add Kecamatan-->
<!--        </a>-->
<!--    </div>-->
<!--</div>-->

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="emptableid" width="100%">
                        <thead>
                            <tr style="font-size:16px;">
                                <th>
                                    No.
                                </th>
                                <th>Kode</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten / Kota</th>
                                <th>Provinsi</th>
                                <th>Total Anggota</th>
                                <!--<th>Download</th>-->
                                <!--<th>Action</th>-->

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
<style>
        .table.dataTable {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }

        .btn.btn-default {
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
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>



<script type="text/javascript">
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
            var table = $("#emptableid").DataTable({
                
                ajax: {
                    url: '/dpp/ajax/ajax_kecamatan',
                    data: {
                        from: from,
                        to: to
                    }
                },
                serverSide: true,
                processing: true,
                orderCellsTop: true,
                fixedHeader: true,
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [{
                        extend: 'copy',
                        className: ' btn btn-default',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-default',
                        title: 'Laporan kecamatan',
                  
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-default',
                        title: 'Laporan kecamatan ',
                       
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-default',
                        title: 'Laporan kecamatan ',
                     
                        footer: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ],

                columns: [{
                        data: 'id',
                        name: 'id',
                        className: "text-center"
                    },
                    {
                        data: 'kode',
                        name: 'id_kec',
                        className: "text-center"
                    },
                    {
                        data: 'kecamatan',
                        name: 'name',
                        className: "text-left"
                    },
                    {
                        data: 'kabupaten',
                        name: 'id_kab',
                   
                        className: "text-left"
                    },
                    {
                        data: 'provinsi',
                        name: 'id_kab',
                      
                        className: "text-left"
                    },
                    {
                        data: 'total',
                        name: 'id_kab',
                        className: "text-center"
                    },
                    // {
                    //     data: 'download',
                    //     name: 'download',
                    //     searchable: false,
                    //     className: "text-center"
                    // },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     searchable: false,
                    //     className: "text-center"
                    // },

                ],
            });
        }
    });
</script>

@stop