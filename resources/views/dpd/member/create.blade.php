@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
        <label> Form Pendaftaran Anggota DPD Provinsi <span style="font-size:15px;">
                @php
                $name = \App\Provinsi::getProv($detail->provinsi_domisili)
                @endphp
                {{$name->name ?? '-'}}</span></label>
    </div>

    <div class="card-body">
        <form class="form form-vertical" method="post" id="registrationForm" enctype="multipart/form-data">
            {{-- <form class="form-material mt-4" action="{{ route('dpd.member.store') }}" method="POST"
            enctype="multipart/form-data"> --}}
            @csrf

            <div class="row">
                <div class="col-sm-6 col-sg-4 m-b-4">
                    <ul class="list-unstyled">
                        <li>
                            <div class="form-group">
                                <label for="name"><span style="color: red">(*) Data wajib diisi</span></label>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <blockquote>

                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#D6A62C; color:#FFFF; font-weight:bold;">
                        Informasi Pribadi</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="nama">Nama Lengkap (Sesuai Ktp) <span
                                            style="color: red">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama"
                                        value="" onKeyUp="uppercase(this);" autofocus="autofocus">
                                    @if($errors->has('name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('nik') ? 'has-error' : '' }}">
                                    <label for="no_ktp">NIK <span style="color: red">*</span></label>
                                    <input type="text" id="nik" name="nik" class="form-control" placeholder="Nomor KTP"
                                        value="" onKeyUp="numericFilter(this);">
                                    @if($errors->has('nik'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('nik') }}
                                    </em>
                                    @endif
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="emailaddress">Email <span style="color: red">*</span></label>
                                    <input type="text" id="emailaddress" name="emailaddress" class="form-control"
                                        placeholder="Alamat Email" value="">
                                    @if($errors->has('emailaddress'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('emailaddress') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                                    <label for="gender">Jenis Kelamin <span style="color: red">*</span></label>
                                    <select name="gender" id="gender" class="form-control select2"
                                        style="width: 100%; height:36px;">
                                        <option value="">-- Pilih --</option>
                                        @foreach($jenis_kelamin as $data => $row)
                                        <option value="{{ $data }}">{{ $row }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('gender'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('gender') }}
                                    </em>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('tempat_lahir') ? 'has-error' : '' }}">
                                    <label for="tempat_lahir">Tempat Lahir <span style="color: red">*</span></label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control"
                                        placeholder="Tempat Lahir" onKeyUp="uppercase(this);">
                                    @if($errors->has('tempat_lahir'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('tempat_lahir') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('tgl_lahir') ? 'has-error' : '' }}">
                                    <label for="tgl_lahir">Tanggal Lahir <span style="color: red">*</span></label>
                                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control"
                                        value="{{ old('tgl_lahir', date('Y-m-d')) }}">
                                    @if($errors->has('tgl_lahir'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('tgl_lahir') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">

                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('marital_status') ? 'has-error' : '' }}">
                                    <label for="marital">Status Pernikahan <span style="color: red">*</span></label>
                                    <select name="marital" id="marital" class="form-control select2"
                                        style="width: 100%; height:36px;">
                                        <option value="">-- Pilih --</option>
                                        @foreach($marital as $data => $row)
                                        <option value="{{ $data }}">{{ $row }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('marital_status'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('marital_status') }}
                                    </em>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">
                                    <label for="job">Pekerjaan <span style="color: red">*</span></label>
                                    <select name="job" id="job" class="form-control selectpicker"
                                        style="width: 100%; height:36px;" data-live-search="true">
                                        <option value="">-- Pilih --</option>
                                        @foreach($job as $data => $row)
                                        <option value="{{ $data }}">{{ $row }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('job'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('job') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">
                                    <label for="pendidikan">Pendidikan <span style="color: red">*</span></label>
                                    <select name="status_pendidikan" id="status_pendidikan"
                                        class="form-control selectpicker" style="width: 100%; height:36px;"
                                        data-live-search="true">
                                        <option value="">-- Pilih --</option>
                                        @foreach($pendidikan as $data => $row)
                                        <option value="{{ $data }}">{{ $row }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('status_pendidikan'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('status_pendidikan') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">
                                    <label for="agama">Agama <span style="color: red">*</span></label>
                                    <select name="agama" id="agama" class="form-control selectpicker"
                                        style="width: 100%; height:36px;" data-live-search="true">
                                        <option value="">-- Pilih --</option>
                                        @foreach($agama as $data => $row)
                                        <option value="{{ $data }}">{{ $row }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('agama'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('agama') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('no_hp') ? 'has-error' : '' }}">
                                    <label for="no_hp">No. Hp <span style="color: red">*</span></label>
                                    <input type="text" id="no_hp" name="no_hp" placeholder="Nomor HP"
                                        class="form-control" onKeyUp="numericFilter(this);">
                                    @if($errors->has('no_hp'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('no_hp') }}
                                    </em>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



            </blockquote>
            

            <blockquote>
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#D6A62C; color:#FFFF; font-weight:bold;">Tempat
                        Tinggal</div>
                    <div class="panel-body">
                        <div class="row">
                        <div class="col-sm-6 col-sg-6 m-b-6">
                            <div class="form-group {{ $errors->has('kabupaten') ? 'has-error' : '' }}">
                                <label for="kabupaten">Kabupaten <span style="color: red">*</span></label>
                                <select  name="kabupaten" id="kabupaten" class="form-control select2"
                                    style="width: 100%; height:36px;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($kabupaten as $data => $row)
                                    <option value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('kabupaten'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('kabupaten') }}
                                </em>
                                @endif
                            </div>
                        </div>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('kecamatan') ? 'has-error' : '' }}">
                                    <label for="kecamatan">Kecamatan <span style="color: red">*</span></label>
                                    <select name="kecamatan" id="kecamatan" class="form-control select2"
                                        style="width: 100%; height:36px;">
                                        <option value="">-- Pilih --</option>
                                    </select>
                                    @if($errors->has('kecamatan'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('kecamatan') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('kelurahan') ? 'has-error' : '' }}">
                                    <label for="kelurahan">Kelurahan <span style="color: red">*</span></label>
                                    <select name="kelurahan" id="kelurahan" class="form-control select2"
                                        style="width: 100%; height:36px;">
                                        <option value="">-- Pilih --</option>
                                    </select>
                                    @if($errors->has('kelurahan'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('kelurahan') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('rt_rw') ? 'has-error' : '' }}">
                                    <label for="rt_rw">RT / RW <span style="color: red">*</span></label>
                                    <input type="text" id="rt_rw" name="rt_rw" class="form-control"
                                        placeholder="RT dan RW">
                                    @if($errors->has('rt_rw'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('rt_rw') }}
                                    </em>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="address">Alamat <span style="color: red">*</span></label>
                            <textarea name="address" id="address" class="form-control" cols="20" rows="10"
                                placeholder="Alamat Sesuai KTP"></textarea>
                            @if($errors->has('address'))
                            <em class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </em>
                            @endif
                        </div>
                       
                </div>
            </blockquote>
            <blockquote>


                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#D6A62C; color:#FFFF; font-weight:bold;">File
                        Upload</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4 col-sg-4 m-b-4">
                                <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                                    <label for="avatar">Foto Untuk KTA <span style="color: red">*</span></label>
                                    <input type="file" id="avatar" name="avatar"  accept="image/png, image/jpg, image/jpeg" class="form-control" value="">
                                       <label style="font-size:12px; "for="password"> <i class="fa-solid fa-triangle-exclamation"></i> Maksimum 2mb, format jpg/jpeg/png</label>
                                    @if($errors->has('avatar'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('avatar') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-sg-4 m-b-4">
                                <div class="form-group {{ $errors->has('foto_ktp') ? 'has-error' : '' }}">
                                    <label for="foto_ktp">Foto KTP <span style="color: red">*</span></label>
                                    <input type="file" id="foto_ktp" name="foto_ktp"  accept="image/png, image/jpg, image/jpeg" class="form-control" value="">
                                       <label style="font-size:12px; "for="password"> <i class="fa-solid fa-triangle-exclamation"></i> Maksimum 2mb, format jpg/jpeg/png</label>
                                    @if($errors->has('foto_ktp'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('foto_ktp') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4 col-sg-4 m-b-4">
                                <div class="form-group {{ $errors->has('pakta_intergritas') ? 'has-error' : '' }}">
                                    <label for="pakta_intergritas">Pakta Integritas </label>
                                    <input type="file" id="pakta_intergritas" accept=".pdf,.doc" name="pakta_intergritas"
                                        class="form-control" value="">
                                        <label style="font-size:12px; "for="password"> <i class="fa-solid fa-triangle-exclamation"></i> Maksimum 2mb, pdf/doc</label>
                                    @if($errors->has('pakta_intergritas'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('pakta_intergritas') }}
                                    </em>
                                    @endif
                                    <p class="helper-block">
                                    </p>
                                </div>
                            </div>

                        </div>
                         <div>
                            <button style="background-color:#D6A62C; color:#FFFF;" type="submit" class="btn ">
                                <i class="fa fa-save"></i> Daftar
                            </button>
                        </div>
                        <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('provinsi') ? 'has-error' : '' }}">
                                    <!--<label for="provinsi">Provinsi <span style="color: red">*</span></label>-->
                                    <select hidden name="provinsi" id="provinsi" class="form-control select2"
                                        style="width: 100%; height:36px;">
                                        <option value="">-- Pilih --</option>
                                        @foreach($provinsi as $data => $row)
                                        <option {{ $data == $detail->provinsi_domisili ? 'selected' : '' }}
                                            value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('provinsi'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('provinsi') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                        
                    </div>
                    </div>
                </div>




            </blockquote>
        </form>
    </div>
</div>
@stop
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function (e) {
        // $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#check").change(function () {
            let alamat = $('#address').val();
            let prov = $('#provinsi').find('option:selected').val();
            let kab = $('#kabupaten').find('option:selected').val();
            let kec = $('#kecamatan').find('option:selected').val();
            let kel = $('#kelurahan').find('option:selected').val();

            let prov_name = $('#provinsi').find('option:selected').attr("name");
            let kab_name = $('#kabupaten').find('option:selected').attr("name");
            let kec_name = $('#kecamatan').find('option:selected').attr("name");
            let kel_name = $('#kelurahan').find('option:selected').attr("name");

            if (this.checked) {
                $("#alamat_domisili").val(alamat);
                $("#provinsi_domisili").prop('readonly', true);
                $("#kabupaten_domisili").prop('readonly', true);
                $("#kecamatan_domisili").prop('readonly', true);
                $("#kelurahan_domisili").prop('readonly', true);
                $("#provinsi_domisili").append('<option value="' + prov + '" selected>' + prov_name +
                    '</option>');
                $("#kabupaten_domisili").append('<option value="' + kab + '" selected>' + kab_name +
                    '</option>');
                $("#kecamatan_domisili").append('<option value="' + kec + '" selected>' + kec_name +
                    '</option>');
                $("#kelurahan_domisili").append('<option value="' + kel + '" selected>' + kel_name +
                    '</option>');
            } else {
                $("#alamat_domisili").val("");
                $("#provinsi_domisili").prop('readonly', false);
                $("#kabupaten_domisili").prop('readonly', true);
                $("#kecamatan_domisili").prop('readonly', true);
                $("#kelurahan_domisili").prop('readonly', true);
                $('#provinsi_domisili').find('option').remove();
                $('#kabupaten_domisili').find('option').remove();
                $('#kecamatan_domisili').find('option').remove();
                $('#kelurahan_domisili').find('option').remove();
                $("#provinsi_domisili").append('<option value="">--Pilih--</option>');
                $("#kabupaten_domisili").append('<option value="">--Pilih--</option>');
                $("#kecamatan_domisili").append('<option value="">--Pilih--</option>');
                $("#kelurahan_domisili").append('<option value="">--Pilih--</option>');
            }
        });

        $('#registrationForm').on('submit', function (e) {
            e.preventDefault();
            // $(this).html('Sending..');
            var name = $("#name").val();
            var nickname = $("#nickname").val();
            var nik = $("#nik").val();
            var email = $("#emailaddress").val();
            var gender = $("#gender").val();
            var tempat_lahir = $("#tempat_lahir").val();
            var tgl_lahir = $("#tgl_lahir").val();
            var rt_rw = $("#rt_rw").val();
            // var kode_pos = $("#kode_pos").val();
            var pendidikan = $("#pendidikan").val();
            var job = $("#job").val();
            var no_hp = $("#no_hp").val();
            var nickname = $("#nickname").val();
            var address = $("#address").val();
            var provinsi = $("#provinsi").val();
            var kabupaten = $("#kabupaten").val();
            var kecamatan = $("#kecamatan").val();
            var kelurahan = $("#kelurahan").val();
            var agama = $("#agama").val();
            var ktp = $("#foto_ktp").val();

            var pakta_intergritas = $("#pakta_intergritas").val()

            var avatar = $("#avatar").val()
              var avatar = $("#avatar").val()
            var image = document.getElementById("avatar");
            var ktp_file = document.getElementById("foto_ktp");
         
         
            // var pakta = parseFloat(pakta_intergritas.files[2].size / (1024 * 1024)).toFixed(2); 

            if (name == '') {
                swal('Error', 'Nama Tidak Boleh Kosong');
                return false;
            }
      
            if (nik == '') {
                swal('Error', 'Nomor KTP  Tidak Boleh Kosong');
                return false;
            }
            if (nik.length < 16) {
                swal('Error', 'Nik Harus 16 Karakter');
                return false;
            }
           
            if (email == '') {
                swal('Error', 'Email  Tidak Boleh Kosong');
                return false;
            }
         
            if (!validateEmail(email)) {
                swal('Error', 'Masukan Email Dengan Benar');
                return false;
            }
      
            if (gender == '') {
                swal('Error', 'Jenis Kelamin Tidak Boleh Kosong');
                return false;
            }
            if (tempat_lahir == '') {
                swal('Error', 'Tempat Lahir Tidak Boleh Kosong');
                return false;
            }
            if (tgl_lahir == '') {
                swal('Error', 'Tanggal Lahir Tidak Boleh Kosong');
                return false;
            }
            if (marital == '') {
                swal('Error', 'Status Pernikahan Tidak Boleh Kosong');
                return false;
            }
            if (job == '') {
                swal('Error', 'Pekerjaan Tidak Boleh Kosong');
                return false;
            }
            if (pendidikan == '') {
                swal('Error', 'Pendidikan Tidak Boleh Kosong');
                return false;
            }
             if (agama == '') {
                swal('Error', 'Agama  Tidak Boleh Kosong');
                return false;
            }
         
            
            if (no_hp == '') {
                swal('Error', 'Nomor Hp Tidak Boleh Kosong');
                return false;
            }
          
            
            if (avatar == '') {
                swal('Error', 'Foto Untuk KTA Tidak Boleh Kosong');
                return false;
            }
             if (typeof (image.files) != "undefined") {
            var size = parseFloat(image.files[0].size / (1024 * 1024)).toFixed(2); 
            if(size > 2) {
               swal('Error', 'Silakan Pilih Ukuran Foto Untuk KTA Kurang Dari 2 MB');
                return false;
                }
             }
             if (ktp == '') {
                swal('Error', 'Foto KTP Tidak Boleh Kosong');
                return false;
            }
       
            if (typeof (ktp_file.files) != "undefined") {
                var ukuran = parseFloat(ktp_file.files[0].size / (1024 * 1024)).toFixed(2); 
            if(ukuran > 2) {
               swal('Error', 'Silakan Pilih Ukuran Foto KTP Kurang Dari 2 MB');
                return false;
                }
            }
              // if (pakta_intergritas == '') {
            //     swal('Error', 'Pakta Intergritas  Tidak Boleh Kosong');
            //     return false;
            // }
             if (typeof (pakta_intergritas.files) != "undefined") {
            var pakta = parseFloat(pakta_intergritas.files[0].size / (1024 * 1024)).toFixed(2); 
            if(pakta > 2) {
               swal('Error', 'Silakan Pilih Ukuran File Intergritas Kurang Dari 2 MB');
                return false;
                }
             }
            
            if (provinsi == '') {
                swal('Error', 'Provinsi Tidak Boleh Kosong');
                return false;
            }
            if (kabupaten == '') {
                swal('Error', 'Kabupaten Tidak Boleh Kosong');
                return false;
            }
            if (kecamatan == '') {
                swal('Error', 'Kecamatan Tidak Boleh Kosong');
                return false;
            }
            if (kelurahan == '') {
                swal('Error', 'Kelurahan Tidak Boleh Kosong');
                return false;
            }
             if (rt_rw == '') {
                swal('Error', 'RT dan RW Tidak Boleh Kosong');
                return false;
            }
                 if (address == '') {
                swal('Error', 'Alamat Tidak Boleh Kosong');
                return false;
            }
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('dpd.member.store') }}",
                type: "POST",
                data: formData,
                // dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if ((data.is_error) === true) {
                        swal('Error', data.error_msg);
                    } else {
                        swal('Info', data.error_msg);
                        document.getElementById("registrationForm").reset();
                        // $('#registrationForm').reset();
                        parent.history.back();
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                error: function (data) {
                    console.log('Error:', data);
                    swal('error', data.error_msg);
                }
            });
        });
    });

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }

    function uppercase(obj) {
        obj.value = obj.value.toUpperCase();
    }


    $("#provinsi").change(function () {
        let val = $(this).val();
        $.ajax({
            url: '/dpd/ajax/kab',
            data: {
                val: val
            },
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                var len = response.length;
                $('#kabupaten').find('option').remove();
                $("#kabupaten").prop('readonly', false);
                $("#kabupaten").append('<option value="">--Pilih--</option>');
                if (len > 1) {
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kab'];
                        var name = response[i]['name'];
                        $("#kabupaten").append("<option value='" + code + "' name='" + name + "'>" +
                            name + "</option>");
                    }
                }
            }
        });
    });

    $("#kabupaten").change(function () {
        let val = $(this).val();
        $.ajax({
            url: '/dpd/ajax/kec',
            data: {
                val: val
            },
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                var len = response.length;
                $('#kecamatan').find('option').remove();
                $("#kecamatan").prop('readonly', false);
                $("#kecamatan").append('<option value="">--Pilih--</option>');
                if (len > 1) {
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kec'];
                        var name = response[i]['name'];
                        $("#kecamatan").append("<option value='" + code + "' name='" + name + "'>" +
                            name + "</option>");
                    }
                }
            }
        });
    });

    $("#kecamatan").change(function () {
        let val = $(this).val();
        $.ajax({
            url: '/dpd/ajax/kel',
            data: {
                val: val
            },
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                var len = response.length;
                $('#kelurahan').find('option').remove();
                $("#kelurahan").prop('readonly', false);
                $("#kelurahan").append('<option value="">--Pilih--</option>');
                if (len > 1) {
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kel'];
                        var name = response[i]['name'];
                        $("#kelurahan").append("<option value='" + code + "' name='" + name + "'>" +
                            name + "</option>");
                    }
                }
            }
        });
    });

    function numericFilter(txb) {
        txb.value = txb.value.replace(/[^\0-9]/ig, "");
    }
</script>
@stop