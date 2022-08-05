@extends('layouts.master', ['title' => 'Kabupaten'])

@section('content')
<style>
    .click-zoom input[type=checkbox] {
        display: none
    }

    .click-zoom img {
        transition: transform 0.20s ease;
        cursor: zoom-in
    }

    .click-zoom input[type=checkbox]:checked~img {
        transform: scale(2);
        cursor: zoom-out
    }
</style>

<div class="row">
	<div class="col-md-12">
		<h4 class="page-title">Daftar Anggota Listing KTP DPC : {{$detail->name}} </h4>
	</div>

	<div class="col-sm-8 text-right m-b-20">

	</div>
</div>


<div class="card">
	<div class="card-header">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped " id="kabupaten" width="100%">
					<thead>

						<tr style="font-size:13px;">
							<th>No.</th>
							<th>Foto KTP</th>
							<th>Nama</th>
							<th>NIK</th>
							<!--<th>No. KTA</th>-->
							<th>Keterangan</th>
							<th>Action</th>

						</tr>
					</thead>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>    



	<script type="text/javascript">
		$(document).ready(function () {

			$("#kabupaten").DataTable({
				serverSide: true,
				ajax: {
					url: '/dpc/ajax/ajax_listingKTP',
					data: function (data) {
						data.params = {
							sac: "helo"
						}
					}
				},
		
				searching: true,
				processing:true,
				scrollY: 500,
				scrollX: true,
				scrollCollapse: true,
				columns: [
				    {
					    data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
						className: "text-center"
					},
					{
					  data: 'foto',
					  name: 'foto',
					},
				
					{
						data: 'name',
						name: 'name',

					},
					{
						data: 'nik',
						name: 'nik',

					},
					
				// 	{
				// 		data: 'no_anggota',
				// 		name: 'no_anggota',

				// 	},
					{
						data: 'keterangan',
						name: 'keterangan',

					},
					{
						data: 'action',
					    name: 'action',
					},
				],
			});

		});
	</script>

	@stop