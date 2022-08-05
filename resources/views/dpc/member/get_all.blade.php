<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- saved from url=(0064)http://kta.partaihanura.or.id/admin/qrcetak_kartu.php?id=1131306 -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Hanura</title>
    <link href="./KARTU KTA_files/popcalendar.css" type="text/css" rel="stylesheet">
    <link href="http://kta.partaihanura.or.id/admin/images/icon.jpg" rel="icon">
    <link href="./KARTU KTA_files/kartu-qr.css" rel="stylesheet" type="text/css">
    <script language="JavaScript">
        function printPage() {
            if (window.print) {
                agree = confirm('Tekan tombol OK untuk mencetak kartu.');
                if (agree) window.print();
            }
        }
        printPage();
    </script>
    <script src="./KARTU KTA_files/readurl.js.download" type="text/javascript"></script>
    <script src="./KARTU KTA_files/imageshow.js.download" type="text/javascript"></script>
    <style type="text/css">
        @page {
            width: 230mm;
            height: 947mm;

        }

        @media screen {

            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12;
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm auto;
                display: block;
            }
        }

        .italic {
            font-style: italic;
        }

        .oblique {
            font-style: oblique;
        }

        .bold {
            font-weight: bold;
        }

        .font-kartu {
            font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
            font-size: 8px;
            font-weight: bold;
            color: #000000;
        }

        .font-kartu3 {
            font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
            font-size: 8px;
            text-align: center;
            font-weight: bold;
            color: #000000;
        }

        .font-kartu1 {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 10px;
            text-align: center;
            color: #FFFFFF;
        }

        .font-kartu2 {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #00000;
        }

        .ttd-kartu {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #00000;
            padding-right: 2px;
            padding-left: -32px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;

        }


        .table-bordered {
            border: 1px solid #dee2e6
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 1px
        }

        .table-borderless tbody+tbody,
        .table-borderless td,
        .table-borderless th,
        .table-borderless thead th {
            border: 0
        }


        #menu {
            display: none;
        }

        #wrapper,
        #content {
            width: 864px;
            border: 0;
            margin: 30 1%;
            padding: 0;
            padding-bottom: 50px;
            margin-left: 2%;
            float: none !important;
        }
    </style>
</head>

<body bgcolor="#FFFFFF" data-new-gr-c-s-check-loaded="14.1057.0" data-gr-ext-installed="" cz-shortcut-listen="true">


<div class="card">
   
    	<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped report" id="report" width="100%">
					<thead>

						<tr style="font-size:12px;">
							<th>No.</th>

							<th>Nama</th>
							<th>Foto Image</th>
							<th>Foto Avatar</th>
							<th>NIK</th>
							

						</tr>
					</thead>
					<tbody>
                    @foreach($detail as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->nickname}}</td>
                        <td>{{$data->image}}</td>
                        <td><img width="180px;"  src="{{asset('uploads/img/users/'.$data->avatar)}}"></td>
                        <td>{{$data->nik}}</td>
                    </tr>
                    @endforeach
					</tbody>
				</table>

			
			</div>
		</div>
</div>
</body>

</html>