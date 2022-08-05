@extends('layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css" />
<link type="text/css"
    href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css"
    rel="stylesheet" />
@section('content')
 <!--@if (session('message')) <div class="alert alert-success"> {{ session('message') }} </div> @endif -->
<div class="row">
    <div class="col-md-12">
        <h4 class="page-title">Anggota yang sudah di generated KTA & KTP : {{ $kecamatan->name }} </h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <!--<div class="col-md-6">-->
            <!--    <div class="alert alert-dark" role="alert">-->
            <!--        DPC Dapat mencetak kartu anggota maksimal 10. Dengan cara, ceklis terlebih dahulu anggota yang ingin-->
            <!--        dicetak multi print-->
            <!--    </div>-->
            <!--</div>-->
            
        </div>
    </div>
    	<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped " id="import" width="100%">
					<thead>

						<tr style="font-size:12px;">
							<th>No.</th>
							<th>NIK</th>
							<th>Nama</th>
							<th>Tanggal Input</th>
							<th>Tanggal Generated</th>
							<th>ID Kelurahan</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>

				<div style="margin-bottom: 10px;" class="row">
				     <div class="col-lg-12 col-md-12 col-xl-12">

                       
                          <form method="GET" action="/dpc/kecamatan/{{$kecamatan->id_kec}}/generated/update">
                            <button type="button" id="importAnggota"
                                 style="background-color:#D6A62C; color:#FFFF;  margin-top:26px; margin-left:10px;"
                                class="btn float-left"><i class="fa-solid fa-trash"></i> Hapus</button>
                        </form>
                     
                            <a  href="/dpc/kecamatan"
                                style="background-color:#D6A62C; color:#FFFF;  margin-top:12px; margin-left:10px;"
                                class="btn float-left">Kembali</a>
                        
                    </div>
				    

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
    $(document).ready(function () {
        var app = $('#import').DataTable({
            'processing': true,
            'serverSide': true,
             "dom": "<'row' <'col-sm-12' l>>" + "<'row'<'col-sm-12'f>>" +
                        "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            'ajax': '/dpc/ajax/{{$kecamatan->id_kec}}/ajax_generated',
            columns: [{
                    data: 'id',
                    name: 'id',
                    className: "text-center"
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
                    data: 'tgl_input',
                    name: 'tgl_input',

                },
                {
                    data: 'tgl_generated',
                    name: 'tgl_generated',

                },
                {
                    data: 'id_kelurahan',
                    name: 'id_kelurahan',

                },
              
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
            // if (rows_selected.length > 10) {
            //      var content = document.createElement('div');
            //     content.innerHTML = 'Data yang dicentang kotak <strong>' + rows_selected.length +'</strong> <br>( Silahkan centang kotak tidak lebih dari 10 )'  ;
            //     swal({
            //         content: content,
            //         title: 'Gagal',
            //         icon: 'error'
            //     });

              
            // } else 
            if (rows_selected.length > 0) {
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