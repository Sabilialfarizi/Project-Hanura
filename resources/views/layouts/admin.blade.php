<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ \App\Configuration::where('name','apps_name')->first()->value }}</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
	<link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
	{{-- <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" /> --}}
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/custom.min.css') }}" rel="stylesheet" />

	<!--

	select from tabel_user 
	
	left join

	tabel_theme

	tabel_user.id_user_theme=
	tabel_theme.id_theme

	where id_user=$_SESSION[id_user] -->
	@yield('styles')
	<style>
		.navbar-dark .navbar-nav .nav-link {
			color: rgb(250, 250, 250);
			font-size: 1.25rem;
		}
	</style>
</head>

<body ng-app="app">
	<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
		<div class="container">
			<a href="{{ route('dashboard') }}" class="navbar-brand">{{ \App\Configuration::where('name','apps_name')->first()->value }}</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

		</div>
	</div>
	<div class="container">
	{{-- <div class="app-body"> --}}
		{{-- <main class="main"> --}}
			{{-- <div style="padding-top: 20px" class="container-fluid"> --}}
				@yield('content')
			{{-- </div> --}}
		{{-- </main> --}}
		<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
			{{ csrf_field() }}
		</form>
		<footer id="footer">
			<div class="row">
				<div class="col-lg-12">
					<p> copyright <a href="https://thomaspark.co">{{ \App\Configuration::where('name','footer')->first()->value }}</a>.</p>
					{{-- <p>Based on <a href="https://getbootstrap.com" rel="nofollow">Bootstrap</a>. Icons from <a href="https://fontawesome.com/" rel="nofollow">Font Awesome</a>. Web fonts from <a href="https://fonts.google.com/" rel="nofollow">Google</a>.</p> --}}
				</div>
			</div>
		</footer>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	{{-- <script src="https://unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script> --}}
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
	<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
	<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
	<script src="{{ asset('js/notify.min.js') }}"></script>
	<script src="{{ asset('js/angular.min.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
	<script src="{{ asset('js/tinymce/tinymce.js') }}"></script>
	<script>
		$(".spin-save").hide()
		var app = angular.module('app',[])
		@if(session('success'))
			let success = '{{ session('success') }}'
			console.log(success)
			$.notify(success, "success");
		@endif

		@if(session('error'))
			let error = '{{ session('error') }}'
			$.notify(error, "error");
		@endif

		$(function() {
			let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
			let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
			let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
			let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
			let printButtonTrans = '{{ trans('global.datatables.print') }}'
			let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
			let languages = {
				'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
			};

			$.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
			$.extend(true, $.fn.dataTable.defaults, {
				language: {
				url: languages.{{ app()->getLocale() }}
			},
			columnDefs: [{
				orderable: false,
				className: 'select-checkbox',
				targets: 0
			}, {
				orderable: false,
				searchable: false,
				targets: -1
			}],
			select: {
				style:    'multi+shift',
				selector: 'td:first-child'
			},
			order: [],
			scrollX: true,
			pageLength: 25,
			dom: 'lBfrtip<"actions">',
			buttons: [
			{
				extend: 'copy',
				className: 'btn-default',
				text: copyButtonTrans,
				exportOptions: {
				columns: ':visible'
				}
			},
			{
				extend: 'csv',
				className: 'btn-default',
				text: csvButtonTrans,
				exportOptions: {
				columns: ':visible'
				}
			},
			{
				extend: 'excel',
				className: 'btn-default',
				text: excelButtonTrans,
				exportOptions: {
				columns: ':visible'
				}
			},
			{
				extend: 'pdf',
				className: 'btn-default',
				text: pdfButtonTrans,
				exportOptions: {
				columns: ':visible'
				}
			},
			{
				extend: 'print',
				className: 'btn-default',
				text: printButtonTrans,
				exportOptions: {
				columns: ':visible'
				}
			},
			{
				extend: 'colvis',
				className: 'btn-default',
				text: colvisButtonTrans,
				exportOptions: {
				columns: ':visible'
				}
			}
		]
	});
	$.fn.dataTable.ext.classes.sPageButton = '';
});

</script>
	@yield('scripts')
</body>
</html>
