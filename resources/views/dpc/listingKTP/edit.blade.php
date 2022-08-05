@extends('layouts.master')
@section('content')
<style>
    .click-zoom input[type=checkbox] {
        display: none
    }

    .click-zoom img {
        transition: transform 0.25s ease;
        cursor: zoom-in
    }

    .click-zoom input[type=checkbox]:checked~img {
        transform: scale(2);
        cursor: zoom-out
    }
</style>
<div class="card">
    <div class="card-header">
        <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
        Form Edit Listing KTP Anggota
    </div>

    <div class="card-body">

        <form class="form-material mt-4" action="{{ route('dpc.listingKTP.update', $member->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('put')

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
                                    <input type="nik" id="name" name="name" class="form-control"
                                        value="{{ old('nickname', $member->nickname) }}" placeholder="Nama" value=""
                                        onKeyUp="uppercase(this);">

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
                                    <input type="text" id="nik" name="nik" class="form-control"
                                        value="{{ old('nik', $member->nik) }}" maxlength="16" placeholder="Nomor KTP"
                                        value="" onKeyUp="numericFilter(this);">
                                    @if($errors->has('nik'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('nik') }}
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
                    <div class="panel-heading" style="background-color:#D6A62C; color:#FFFF; font-weight:bold;">File
                        Upload</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                                    <label for="avatar">Foto Untuk KTA </label>
                                    @if(!empty($member->avatar))
                                    <br>
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="{{asset('uploads/img/users/'.$member->avatar)}}" alt='noimage'
                                                width='100px' height='100px'>
                                        </label>
                                    </div>
                                    <input type="hidden" name="avatar_lama" value="{{ $member->avatar ?? '' }}">
                                    <input type="file" accept="image/png, image/jpg, image/jpeg" id="avatar"
                                        name="avatar" class="form-control" value="">
                                    @else
                                    <input type="hidden" name="avatar_lama" value="{{ $member->avatar ?? '' }}">
                                    <input type="file" accept="image/png, image/jpg, image/jpeg" id="avatar"
                                        name="avatar" class="form-control" value="">
                                    @if($errors->has('avatar'))
                                    <strong style="font-size:12px;" class="text-danger">
                                        Silakan Pilih Ukuran Foto Untuk KTA Kurang Dari 10 MB
                                    </strong>
                                    <br>
                                    @endif
                                    @endif
                                    <label style="font-size:12px; " for="password"> <i
                                            class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                        jpg/jpeg/png</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('foto_ktp') ? 'has-error' : '' }}">
                                    <label for="foto_ktp">Foto KTP <span style="color: red">*</span></label>
                                    @if(!empty($member->foto_ktp))
                                    <br>
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="{{asset('uploads/img/foto_ktp/'.$member->foto_ktp)}}"
                                                alt='noimage' width='150px' height='100px'>
                                        </label>
                                    </div>
                                    <input type="hidden" name="foto_ktp_lama" value="{{ $member->foto_ktp ?? '' }}">
                                    <input type="file" accept="image/png, image/jpg, image/jpeg" id="foto_ktp"
                                        name="foto_ktp" class="form-control" value="">
                                    @else
                                    <input type="hidden" name="foto_ktp_lama" value="{{ $member->foto_ktp ?? '' }}">
                                    <input type="file" accept="image/png, image/jpg, image/jpeg" id="foto_ktp"
                                        name="foto_ktp" class="form-control" value="">
                                    @if($errors->has('foto_ktp'))
                                    <strong style="font-size:12px;" class="text-danger">
                                        Silakan Pilih Ukuran Foto Untuk KTA Kurang Dari 10 MB
                                    </strong>
                                    <br>
                                    @endif
                                    @endif
                                    <label style="font-size:12px; " for="password"> <i
                                            class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                        jpg/jpeg/png</label>
                                </div>
                            </div>
     
                        </div>
                        <div>
                            <button style="background-color:#D6A62C; color:#FFFF;" type="submit" class="btn ">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('provinsi') ? 'has-error' : '' }}">
                                    <input hidden type="text" id="provinsi" name="provinsi"
                                        value="{{ old('provinsi_domisili', $member->provinsi_domisili) }}"
                                        placeholder="Nomor HP" class="form-control">
                                    @if($errors->has('provinsi'))
                                    <em class="invalid-provinsi">
                                        {{ $errors->first('provinsi') }}
                                    </em>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6 col-sg-6 m-b-6">
                            <div class="form-group {{ $errors->has('kabupaten') ? 'has-error' : '' }}">
                                <input hidden type="text" id="kabupaten" name="kabupaten"
                                    value="{{ old('kabupaten_domisili', $member->kabupaten_domisili) }}"
                                    placeholder="Nomor HP" class="form-control">
                                @if($errors->has('kabupaten'))
                                <em class="invalid-kabupaten">
                                    {{ $errors->first('kabupaten') }}
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
            // var pendidikan = $("#pendidikan").val();
            var job = $("#job").val();
            // var no_hp = $("#no_hp").val();
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
            if (name == '') {
                swal('Error', 'Nama Tidak Boleh Kosong');
                return false;
            }
            if (nickname == '') {
                swal('Error', 'nama panggilan tidak boleh kosong');
                return false;
            }
            if (nik == '') {
                swal('Error', 'Nomor KTP  Tidak Boleh Kosong');
                return false;
            }
            if (pakta_intergritas == '') {
                swal('Error', 'Pakta Intergritas  Tidak Boleh Kosong');
                return false;
            }
            if (agama == '') {
                swal('Error', 'Agama  Tidak Boleh Kosong');
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
            // if (pendidikan == '') {
            //     swal('Error', 'Pendidikan Tidak Boleh Kosong');
            //     return false;
            // }
            // if (kode_pos == '') {
            //     swal('Error', 'Kode Pos Tidak Boleh Kosong');
            //     return false;
            // }
            if (rt_rw == '') {
                swal('Error', 'RT dan RW Tidak Boleh Kosong');
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
            // if (no_hp == '') {
            //     swal('Error', 'Nomor Hp Tidak Boleh Kosong');
            //     return false;
            // }
            if (address == '') {
                swal('Error', 'Alamat Tidak Boleh Kosong');
                return false;
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
            if (ktp == '') {
                swal('Error', 'Foto KTP Tidak Boleh Kosong');
                return false;
            }
            if (avatar == '') {
                swal('Error', 'Foto Profil Tidak Boleh Kosong');
                return false;
            }
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('dpc.member.store') }}",
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
            url: '/dpc/ajax/kab',
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
            url: '/dpc/ajax/kec',
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
            url: '/dpc/ajax/kel',
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