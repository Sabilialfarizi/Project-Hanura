@extends('layouts.master', ['title' => 'Kecamatan'])
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css" />
<link type="text/css"
    href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css"
    rel="stylesheet" />
@section('content')

<div class="row">
    <div class="col-md-12">
        <h4 class="page-title">Cetak Kartu Anggota : {{ $kabupaten->name }} </h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-dark" role="alert">
                    DPC Dapat mencetak kartu anggota maksimal 10. Dengan cara, ceklis terlebih dahulu anggota yang ingin
                    dicetak multi print
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <form method="GET" action="{{ route('dpc.member.sdh_transfer.docx') }}" target="_blank">
                    <button type="button" id="importAnggota"
                        style="background-color:#D6A62C; color:#FFFF;  margin-top:10px; margin-left:10px;"
                        class="btn btn-lg"><i class="fa-solid fa-print"></i> Cetak Kartu</button>
                </form>
            </div>
        </div>
    </div>
    	<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped " id="import" width="100%">
					<thead>

						<tr style="font-size:12px;">
							<th>No.</th>

							<th>Waktu</th>
							<th>No. KTA</th>
							<th>Nama</th>
							<th>NIK</th>
							<th>Jenis Kelamin</th>
							<th>Tempat Lahir</th>
							<th>Tanggal Lahir</th>
							<!--<th>Status Perkawinan</th>-->
							<!--<th>Status Pekerjaan</th>-->
							<th>Alamat</th>
							<!--<th>Kelurahan</th>-->
							<!--<th>Kecamatan</th>-->
							<!--<th>Status Anggota</th>-->
							<!--<th>Status KTP</th>-->
							<!--<th>Created By</th>-->
							<!--<th>Action</th>-->

						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>

				<!--<div style="margin-bottom: 10px;" class="row">-->
				<!--    <div class="col-lg-12 col-md-12 col-xl-12">-->
				<!--        <button type="submit" onclick="transfer()"-->
				<!--            style="background-color:#D6A62C; color:#FFFF;  margin-top:10px; margin-left:10px;"-->
				<!--            id="transfer" disabled class="btn float-left">-->
				<!--            Transfer data-->
				<!--        </button>-->

				<!--    </div>-->

				<!--</div>-->

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
    $(document).ready(function () {
        var app = $('#import').DataTable({
            'processing': true,
            'serverSide': true,
             "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-12'f>>" +
                        "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            'ajax': '/dpc/ajax/ajax_kabupaten',
            columns: [{
                    data: 'id',
                    name: 'id',
                    className: "text-center"
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',

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
                    data: 'gender',
                    name: 'gender',

                },
                {
                    data: 'tempat_lahir',
                    name: 'tempat_lahir',

                },
                {
                    data: 'tgl_lahir',
                    name: 'tgl_lahir',

                },
                // {
                //     data: 'status',
                //     name: 'status',

                // },
                // {
                //     data: 'pekerjaan',
                //     name: 'pekerjaan',

                // },
                {
                    data: 'alamat',
                    name: 'alamat',

                },
                // {
                //     data: 'active',
                //     name: 'active',

                // },
                // {
                //     data: 'action',
                //     name: 'action',

                // },
            ],
            'columnDefs': [{
                'targets': 0,
                'checkboxes': {
                    selectRow: true,
                    // selectAll: true,
                }
            }],
            // 'order': [
            //     [1, 'asc']
            // ],
            'select': {
                'style': 'multi'
            }
            // order: [
            //     [1, 'desc']
            // ]
        });
        

        $('#importAnggota').click(function (e) {
            
            var rows_selected = app.column(0).checkboxes.selected();
            if (rows_selected.length > 10) {
                 var content = document.createElement('div');
                content.innerHTML = 'Data yang dicentang kotak <strong>' + rows_selected.length +'</strong> <br>( Silahkan centang kotak tidak lebih dari 10 )'  ;
                swal({
                    content: content,
                    title: 'Gagal',
                    icon: 'error'
                });

              
            } else if (rows_selected.length > 0) {
                var $this = $(this).parent();
                $.each(rows_selected, function (index, rowId) {
                    $this.append('<input type="hidden" name="id[]" value="' + rowId + '">');
                });

                $this.submit();
            } else {
                 var content = document.createElement('div');
                content.innerHTML = 'Silahkan centang kotak untuk anggota yang akan dicetak';
                swal({
                    content: content,
                    title: 'Gagal',
                    icon: 'error'
                });
            }
             e.preventDefault();
            $('input[name="id\[\]"]', $this).remove();


        });

      
    });
</script>
@endsection