<html>

<head>
    <title>Hanura</title>
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

            .wrapper-page {
                page-break-after: always;
            }

            .wrapper-page:last-child {
                page-break-after: avoid;
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

        .page-break-after {
            page-break-after: always;
        }

        .font-kartu {
            font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
            font-size: 8px;
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
            border-bottom-width: 2px
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
        #watermark {
            position: fixed;
            bottom:   0px;
            top: 236px;
            left: 20px;
           
            width:    85.6mm;
            height:   53.98mm;
            z-index:  -1000;
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
<?php 
                     $ttd_ketua = $ketua->ttd ?? '';
                    $ttd_sekre = $sekre->ttd ?? '';
                    $cap = $kantor->cap_kantor ?? '';
                    $avatar = $details->avatar ?? '';
                    $ktp = $details->foto_ktp ?? '';
    
                               
                 $ketua_ttd = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/'.$ttd_ketua) && !empty($ketua->ttd)?
                '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/'.$ttd_ketua : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/noimage.jpg';
               
                $sekre_ttd = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/'.$ttd_sekre) && !empty($sekre->ttd)?
                '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/'.$ttd_sekre :'/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/noimage.jpg';
              
                $fotolama = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/'.$cap) && !empty($kantor->cap_kantor)?
                '/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/'.$cap : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/cap.jpg';
                
                // $avatar = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$avatar) && !empty($details->avatar)?
                // '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$avatar : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/profile.png';
                
                $avatar = $details->avatar ==  'profile.png' ?  '/www/wwwroot/siap.partaihanura.or.id/uploads/img/'.$details->image : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/'.$details->avatar || !empty($details->image) ? '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$details->image : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/profile.png';
                
                // $avatar = $details->avatar ==  'profile.png' ?  '/www/wwwroot/siap.partaihanura.or.id/uploads/img/users/'.$details->image : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/'.$details->avatar;
                
                $logo = '/www/wwwroot/siap.partaihanura.or.id/img/logo/logo_hanura.PNG';
                $fot_ktp = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/foto_ktp/'.$ktp) && !empty($details->foto_ktp)?
                '/www/wwwroot/siap.partaihanura.or.id/uploads/img/foto_ktp/'.$ktp : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/foto_ktp/ektp.png';
                        
                    
                        
                        $type_avatar = pathinfo($avatar, PATHINFO_EXTENSION);
                        if (file_exists($avatar)) {
                             $data_avatar = file_get_contents($avatar);
                        } else {
                            $data_avatar = file_get_contents('/www/wwwroot/siap.partaihanura.or.id/uploads/img/profile.png');
                        }
                        $pic_avatar = 'data:image/' . $type_avatar . ';base64,' .base64_encode($data_avatar);
                        
                        $type_logo = pathinfo($logo, PATHINFO_EXTENSION);
                        $data_logo = file_get_contents($logo);
                        $pic_logo = 'data:image/' . $type_logo . ';base64,' .base64_encode($data_logo);
                        
                        $type = pathinfo($fotolama, PATHINFO_EXTENSION);
                        $data = file_get_contents($fotolama);
                        $pic = 'data:image/' . $type . ';base64,' .base64_encode($data);
                        
                        $type_ketua = pathinfo($ketua_ttd, PATHINFO_EXTENSION);
                        $data_ketua = file_get_contents($ketua_ttd);
                        $pic_ketua = 'data:image/' . $type_ketua . ';base64,' .base64_encode($data_ketua);
                        
                        $type_sekre = pathinfo($sekre_ttd, PATHINFO_EXTENSION);
                        $data_sekre = file_get_contents($sekre_ttd);
                        $pic_sekre = 'data:image/' . $type_sekre . ';base64,' .base64_encode($data_sekre);
                        
                        $type = pathinfo($fotolama, PATHINFO_EXTENSION);
                        $data = file_get_contents($fotolama);
                        $pic = 'data:image/' . $type . ';base64,' .base64_encode($data);
                        
                        $type_ktp = pathinfo($fot_ktp, PATHINFO_EXTENSION);
                        $data_ktp = file_get_contents($fot_ktp);
                        $pic_ktp = 'data:image/' . $type_ktp . ';base64,' .base64_encode($data_ktp);
                    ?>

<body>

	<center>
		<div class="row">
			<div class="col-md-12">
				<p style="margin-bottom:-8px;"><span style="font-size: 15px; font-weight:bold;">DAFTAR NAMA
						DAN ALAMAT ANGGOTA PARTAI
						POLITIK</span>
				</p>
			</div>

			<div class="col-md-12">
				<p style="margin-bottom:-8px;"><span style="font-size: 15px; font-weight:bold;">KAB/KOTA
						:
						@php
						$namo = \App\Kabupaten::getKab( $details->kabupaten_domisili);
						@endphp {{ ucwords(strtolower($namo->name ?? '-')) }}</span>
				</p>
			</div>

			<div class="col-md-12 text-center">
				<p style="margin-bottom:-8px;"><span
						style="font-size: 15px;  margin-bottom:20px; font-weight:bold;">PARTAI HATI NURANI
						RAKYAT
						(HANURA)</span>
				</p>
			</div>
			<br>
			<div class="col-md-12 text-center">
				<div class="dashboard-logo">
					<img width="180px;" src="<?php echo $pic_logo ?>">
				</div>

			</div>
		</div>
	</center>
	<br>
	<br>


	<div style="margin-left:30px">
		<table class="table table-borderless" style="font-size:10px;">
			<tr> 
				<td style="padding-right:50px;">
        		    <div id="watermark">
                         <img  src="{{asset('/uploads/img/KTA Belakang.jpg' ) }}"  height="100%" width="100%" />
                    </div>
                    <main>


            			<table class="table-borderless" border="0px" cellpadding="0px" cellspacing="0px" width="250"
            				class="bold">
            				<tbody>
            					<tr>
            						<!--td class="foto-kartu" width="107" rowspan="12" align="center"-->
            
            						<td width="75" rowspan="12" border="0px" valign="top"
            							style="border-collapse: collapse;">
            							<img id="blah" class="responsive" src="<?php echo $pic_avatar ?>" width="90"
            								height="105" style="border-collapse: collapse;" border="0px" alt="Foto Profil">
            						</td>
            
            
            
            						<td class="font-kartu" width="52">No. KTA</td>
            						<td class="font-kartu" align="center">:</td>
            						<td class="font-kartu">{{$details->no_member}}</td>
            					</tr>
            					<tr>
            						<td class="font-kartu">Nama</td>
            						<td class="font-kartu" align="center">:</td>
            						<td class="font-kartu">{{ ucwords(strtolower($details->nickname))}}</td>
            					</tr>
            					<tr>
            						<td class="font-kartu" width="25">Tempat/Tgl Lahir </td>
            						<td class="font-kartu" align="center">:</td>
            						<td class="font-kartu">{{ucwords(strtolower($details->birth_place))}}
            							, {{ Carbon\Carbon::parse($details->tgl_lahir)->Format('d-m-Y') }}
            						</td>
            
            					</tr>
            					<tr>
            						<td class="font-kartu">Alamat</td>
            						<td class="font-kartu" align="center">:</td>
            						<td class="font-kartu">{{ $details->alamat}}</td>
            					</tr>
            					<tr>
            						<td class="font-kartu">RT/RW</td>
            						<td class="font-kartu" align="center">:</td>
            						<td class="font-kartu"> {{$details->rt_rw}} </td>
            					</tr>
            
            					<tr>
            						<td class="font-kartu" width="25">Kel./Desa</td>
            						<td class="font-kartu" width="10" align="center">:</td>
            						<td class="font-kartu"> @php
            							$nama_kel = \App\Kelurahan::getKel( $details->kelurahan_domisili);
            							@endphp
            							{{  ucwords(strtolower($nama_kel->name ?? '-')) }}</td>
            					</tr>
            					<tr>
            						<td class="font-kartu" width="28">Kec.</td>
            						<td class="font-kartu" width="10" align="center">:</td>
            						<td class="font-kartu"> @php
            							$nama_kec = \App\Kecamatan::getKec( $details->kecamatan_domisili);
            							@endphp
            							{{  ucwords(strtolower($nama_kec->name ?? '-')) }}</td>
            					</tr>
            					<tr>
            						<td class="font-kartu">Kab./Kota</td>
            						<td class="font-kartu" align="center">:</td>
            						<td class="font-kartu"> @php
            							$namo = \App\Kabupaten::getKab( $details->kabupaten_domisili);
            							@endphp {{ ucwords(strtolower($namo->name ?? '-')) }}</td>
            					</tr>
            					<tr>
            						<td class="font-kartu">Provinsi</td>
            						<td class="font-kartu" align="center">:</td>
            						<td class="font-kartu">@php
            							$name = \App\Provinsi::getProv( $details->provinsi_domisili);
            							@endphp
            							{{  ucwords(strtolower($name->name ?? '-')) }}</td>
            					</tr>
            					<tr>
            						<td class="font-kartu">Diterbitkan</td>
            						<td class="font-kartu" align="center">:</td>
            						<td class="font-kartu">
            							{{Carbon\Carbon::parse($details->created_at)->Format('d-m-Y')}}</td>
            					</tr>
            					<tr>
            						<td class="font-kartu" colspan="3">&nbsp;</td>
            					</tr>
            
            					<!--<tr>-->
            					<!--    <td class="font-kartu" nowrap=""></td>-->
            					<!--    <td class="font-kartu"></td>-->
            					<!--    <td class="font-kartu"></td>-->
            					<!--</tr>-->
            					<tr>
            						<td class="font-kartu1" colspan="4" width="140">
            							<div style="font-size:9spx; color:black; font-weight:bold; margin-left:-70px;">
            								DPC @php
            								$namo = \App\Kabupaten::getKab($details->kabupaten_domisili);
            								@endphp {{ ucwords(strtolower($namo->name ?? '-')) }}
            							</div>
            						</td>
            					</tr>
            					<tr>
            						<td colspan="5" style="padding: 0">
            							<table width="100%" style="padding: 0">
            								<tr>
            
            									<td class="font-kartu" align="center" width="100">Ketua</td>
            									@if ($kantor == null)-->
            									<td style="width:40.3333%" rowspan="3"></td>
            									@else
            									<td style="width:40.3333%" rowspan="3" align="center">
            										<img src="<?php echo $pic; ?>" alt="cap kantor notfound" width="50"
            											height="36">
            									</td>
            									@endif
            									<td class="font-kartu" align="center" width="110">Sekretaris</td>
            
            								</tr>
            								<tr>
            									@if($ketua == null)
            									<td align="center" class="ttd-kartu"><img id="ttdKetua" src="" width="40"
            											height="10" border="0" alt="ttd ketua"></td>
            									@else
            
            									<td align="center" style="font-weight:bold;" class="ttd-kartu"
            										align="center">
            										<img id="ttdKetua" src="<?php echo $pic_ketua ?>" width="45" height="15"
            											border="0" alt="ttd ketua"></td>
            									@endif
            
            
            									@if($sekre == null)
            									<td align="center" class="ttd-kartu"><img id="ttdKetua" src="" width="40"
            											height="10" border="0" alt="ttd sekre"></td>
            									@else
            									<td align="center" style="font-weight:bold;" class="ttd-kartu"><img
            											id="ttdSekre" src="<?php echo $pic_sekre ?>" width="45" height="15"
            											border="0" alt="ttd sekre"></td>
            									@endif
            
            
            								</tr>
            								<tr>
            									<td class="font-kartu" align="center">@php
            										$name_ketua =
            										\App\DetailUsers::getName($kabupaten->id_ketua_dpc);
            										@endphp
            										{{ $ketua->nama ?? 'nama ketua'}}</td>
            									<td class="font-kartu" align="center">@php
            										$name = \App\DetailUsers::getName($kabupaten->id_sekre_dpc);
            										@endphp
            										{{ $sekre->nama ?? 'nama sekre'}}</td>
            								</tr>
            
            
            							</table>
            								</main>
								</td>
							</tr>
						</tbody>
					</table>


				</td>
			
				<td>
					<div style="margin-left:-45px">
						<table cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td>
									
										<img alt="Foto Ktp" class="responsive" src="<?php echo $pic_ktp ?>" width="260"
											height="180">
									
									</td>
								</tr>

							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<center>
					<div class="row">
						<div class="col-md-12 text-center">
							<p style="margin-bottom:-8px;"><span style="font-size: 12px;font-weight:bold;">SURAT
									PERNYATAAN ANGGOTA PARTAI POLITIK </span>
							</p>
						</div>
					</div>
				</center>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-xl-12">
				<br>
				<table class="table table-borderless">
					<tr>
						<td style="padding-right: 48px;">
							<table cellspacing="5" cellpadding="5">

							</table>
						</td>
						<td style="padding-right: 100px;">
							<table cellspacing="5" cellpadding="5">
								<tbody style="font-size: 11px; 	font-family: 'Rubik', sans-serif;">
									<tr>
										<td>Yang bertanda tangan di bawah ini :</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-xl-12" style="margin-top:-20px;">
				<table class="table table-borderless">
					<tr>
						<td style="padding-right: 80px;">
							<table cellspacing="5" cellpadding="5">

							</table>
						</td>
						<td style="padding-right: 50px;">

							<table cellspacing="5" cellpadding="0">
								<tbody style="font-size: 11px; 	font-family: 'Rubik', sans-serif;">
									<tr>
										<td>Nama </td>
										<td>:</td>
										<td>{{ucwords(strtolower($details->nickname))}}</td>
									</tr>
									<tr>
										<td>No. KTA </td>
										<td>:</td>
										<td>{{$details->no_member}}</td>
									</tr>
									<tr>
										<td>NIK </td>
										<td>:</td>
										<td>{{$details->nik}}</td>
									</tr>
									<tr>
										<td>Tempat/Tgl. Lahir </td>
										<td>:</td>
										<td>{{ucwords(strtolower($details->birth_place))}} /
											{{ Carbon\Carbon::parse($details->tgl_lahir)->isoFormat('D MMMM Y') }}</td>
									</tr>
									<tr>
										<td>Usia </td>
										<td>:</td>
										<td>{{Carbon\Carbon::parse($details->tgl_lahir)->diffInYears()}}</td>
									</tr>
									<tr>
										<td>Jenis Kelamin </td>
										<td>:</td>
										<td>
											@php
											$name_gen = \App\Gender::getGender($details->gender);
											@endphp
											@if($details->gender == 1)
											<a>{{$name_gen->name}}</a> / <s>Perempuan*)</s>
											@else
											<s>Laki-laki</s> / <a>{{$name_gen->name}}*)</a>
											@endif
										</td>
									</tr>
									<tr>
										<td>Alamat </td>
										<td>:</td>
										<td width="30px">{{ ucwords(strtolower($details->alamat))}}<</td> </tr> <tr>

									</tr>
									<tr>
										<td>Pekerjaan Saat ini</td>
										<td>:</td>
										<td>
											@php
											$nama_job= \App\Job::getJob($details->pekerjaan);
											@endphp
											{{$nama_job->name}}
										</td>
									</tr>
									<tr>
										<td>Status Perkawinan</td>
										<td>:</td>
										<td>
											@php
											$nama_kawin= \App\Perkawinan::getMer($details->status_kawin);
											@endphp
											@if($details->status_kawin == 1)
											<a>Belum Menikah</a> / <s>Sudah Menikah</s> / <s>Pernah Menikah</s>*)
											@elseif($details->status_kawin == 4)
											<s>Belum Menikah</s> / <a>Sudah Menikah</a> / <s>Pernah Menikah</s>*)
											@elseif($details->status_kawin == 2 && $details->status_kawin == 3)
											<s>Belum Menikah</s> / <s>Sudah Menikah</s> / <a>Pernah Menikah</a>*)
											@endif

										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="col-md-12 col-xl-12" style="margin-top:-20px;">
			<table class="table table-borderless">
				<tr>
					<td style="padding-right: 108px;">
						<table cellspacing="5" cellpadding="5">

						</table>
					</td>

					<td style="padding-right: 50px;">
						<table cellspacing="10" cellpadding="5">
							<thead>
								<tr>
									<div class="col-md-4 col-xl-4" style="margin-top:-20px;">
										<p style="margin-bottom:8px; font-size: 11px; text-align:justify; text-justify:distribute;
                                        font-family: 'Rubik', sans-serif;">
											Menyatakan dengan sesungguhnya bahwa benar saya sebagai anggota Partai
											Hanura yang dibuktikan dengan KTA dan tidak menjadi
											anggota/pengurus*) partai
											politik lain. Apabila ternyata dikemudian hari terbukti tidak benar,
											saya bersedia menerima
											konsekuensi hukum sesuai dengan ketentuan paraturan perundang-undangan
											yang berlaku.
										</p>
										<p style="margin-bottom:-8px; font-size: 11px; text-align: justify;
                                                     text-align-last: center; font-family: 'Rubik', sans-serif;">
											Demikian surat pernyataan ini dibuat dengan sebenarnya untuk dapat
											dipergunakan sebagaimana mestinya.
										</p>
									</div>
								</tr>
							</thead>

						</table>
					</td>
					<td>
						<table cellspacing="5" cellpadding="5">

						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-12">

			<table class="table table-borderless">
				<tr>
					<td style="padding-right: 200px;">
						<table>

						</table>
					</td>

					<td style="padding-right:70px;">

					</td>
					<td>
						<table>
							<thead>

								<tr>
									<p style="font-size: 11px;  text-align:center; font-family: 'Rubik', sans-serif;">
										{{ucwords(strtolower($kabupaten->name))}},
										{{Carbon\carbon::now()->isoFormat('D MMMM YYYY')}}
									</p>
									<p style="font-size: 11px; text-align:center; font-family: 'Rubik', sans-serif;">
										Yang membuat pernyataan,</p>

									<p style="font-size: 11px; font-family: 'Rubik', sans-serif;">


									</p>
								</tr>

							</thead>
							<tfoot>
								<p style="font-size: 11px;  text-align:center; font-family: 'Rubik', sans-serif;">
									Tanda tangan dan nama lengkap
								</p>
							</tfoot>

						</table>
					</td>

				</tr>
			</table>
		</div>
		<div class="col-md-12">

			<table class="table table-borderless">
				<tr>
					<td style="padding-right: 28px;">
						<table cellspacing="5" cellpadding="5">

						</table>
					</td>
					<td style="padding-right: 50px;">

						<table cellspacing="5" cellpadding="0">
							<tbody style="font-size: 11px; 	font-family: 'Rubik', sans-serif;">
								<tr>
									<div class="form-group">
										<label style="font-size: 11px;" for="name"> Keterangan:</label><br>
										<label style="font-size: 11px;" for="name">
											*) Coret yang tidak perlu</label>
									</div>
								</tr>

							</tbody>
						</table>
					</td>

				</tr>
			</table>
		</div>
	</div>
</body>

</html>