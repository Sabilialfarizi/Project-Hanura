@extends('layouts.master', ['title' => 'Kabupaten'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="page-title">Daftar Nama Dan Alamat Anggota partai politik 
KAB/KOTA</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>

<x-alert></x-alert>

<!--<div style="margin-bottom: 10px;" class="row">-->
<!--    <div class="col-lg-12">-->
<!--        <a  style="background-color:#D6A62C; color:#ffff; font-weight:bold;"   class="btn float-right" href="{{ '/dpp/kabupaten/create' }}">-->
<!--            <i class="fa fa-plus"></i> Add Kabupaten/Kota-->
<!--        </a>-->
<!--    </div>-->
<!--</div>-->

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover " id="kabupaten" width="100%">
                        <thead>
                            <tr style="font-size:16px; text-align:center;">
                                <th width="10">
                                    No.
                                </th>
                                <th >Kode</th>
                                <th style="font-size:16px; text-align:left;">Kabupaten / Kota</th>
                                <th style="font-size:16px; text-align:left;">Provinsi</th>
                                <!--<th>Ketua DPC</th>-->
                                <!--<th>Sekretaris DPC</th>-->
                                <!--<th>Bendahara DPC</th>-->
                                <th>Taget Anggota</th>
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

		.btn.btn-pdf {
			background-color: #D6A62C;
		}
	</style>
	@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>    



	<script type="text/javascript">
		$(document).ready(function () {

			$("#kabupaten").DataTable({
				serverSide: true,
				ajax: {
					url:'/dpp/ajax/ajax_kabupaten',
					data: function (data) {
						data.params = {
							sac: "helo"
						}
					}
				},
		
				searching: true,
				processing:true,
				scrollY: 1500,
				scrollX: true,
				scrollCollapse: true,
			 columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center"
                    },
                    {
                        data: 'kode',
                        name: 'kode',
                        className: "text-center"
                    },
                    {
                        data: 'kabupaten',
                        name: 'kabupaten',
                        className: "text-left"
                    },
                    {
                        data: 'provinsi',
                        name: 'provinsi',
                        className: "text-left"
                    },
            
                     {
                        data: 'total',
                        name: 'total',
                        className: "text-center"
                    },
                   
                ],
			});

		});
	</script>

	@stop
	
