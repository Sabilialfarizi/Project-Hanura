@extends('layouts.master', ['title' => 'Provinsi'])

@section('content')


<x-alert></x-alert>
<div style="margin-bottom: 10px;" class="row">
  <div class="col-lg-12">
  <h4 class="page-tittle"> Rekapitulasi Anggota</h4>
  </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('cruds.information.title_singular') }} {{ trans('global.list') }} -->
                <!-- Informasi -->
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="report table table-bordered table-striped table-hover " id="provinsi" width="100%">
                        <thead>
                            <tr style="font-size:13px;">
                                <th width="10">
                                    No.
                                </th>
                                <th>Kode</th>
                                <th>Provinsi</th>
                                <th>Total Kabupaten / Kota</th>
                                <th>Total Anggota</th>
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

			$("#provinsi").DataTable({
				serverSide: true,
				ajax: {
				  url: '/dpc/ajax/ajax_provinsi',
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
                        data: 'provinsi',
                        name: 'provinsi',
                        className: "text-left"
                    },
                    {
                        data: 'total_kabupaten',
                        name: 'total_kabupaten',
                        className: "text-center"
                    },
                    
                    {
                        data: 'total',
                        name: 'total',
                        className: "text-center"
                    }
                    
                ]
			});

		});
	</script>

	@stop
