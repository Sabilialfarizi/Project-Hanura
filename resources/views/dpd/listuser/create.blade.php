@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
        <label> Form Pendaftaran User DPD Provinsi <span style="font-size:15px;">
                @php
                $name = \App\Provinsi::getProv($detail->provinsi_domisili)
                @endphp
                {{$name->name ?? '-'}}</span></label>

    </div>

        <div class="card-body">

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
                            <div class="col-sm-12 col-sg-12 m-b-12">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Anggota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <div class="row">
                                              <div class="col-sm-6 col-sg-6 m-b-4">
                                            <tr>
                                                <th>Nama Anggota</th>
                                                <th>:</th>
                                                <th>

                                                    <select class="cari form-control input-lg dynamic" id="nickname"
                                                        name="nickname" data-dependent="no_member"></select>

                                                </th>
                                            </tr>
                                            <!-- <tr>-->
                                            <!--    <th>Foto Profil</th>-->
                                            <!--    <th>:</th>-->
                                            <!--    <th>-->

                                            <!--         <img alt="Foto Profile" class="responsive" id="avatar"   width="250" height="170">-->

                                            <!--    </th>-->
                                            <!--</tr>-->
                                            <tr>
                                                <th>NO. KTA</th>
                                                <th>:</th>
                                                <th>

                                                    <input type="text" required id="no_member" maxlength="12"
                                                        class="form-control" readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Jabatan</th>
                                                <th>:</th>
                                                <th>

                                                    <input type="text" required id="roles" maxlength="12"
                                                        class="form-control" readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>NIK</th>
                                                <th>:</th>
                                                <th>

                                                    <input type="text" required id="nik_1" class="form-control"
                                                        readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Provinsi</th>
                                                <th>:</th>
                                                <th>

                                                    <input type="text" required id="provinsi_1" class="form-control"
                                                        readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Kabupaten</th>
                                                <th>:</th>
                                                <th>

                                                    <input type="text" required id="kabupaten_1" class="form-control"
                                                        readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Kecamatan</th>
                                                <th>:</th>
                                                <th>

                                                    <input type="text" required id="kecamatan_1" class="form-control"
                                                        readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Kelurahan</th>
                                                <th>:</th>
                                                <th>

                                                    <input type="text" required id="kelurahan_1" class="form-control"
                                                        readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <th>:</th>
                                                <th>

                                                    <input type="text" required id="alamat_1" class="form-control"
                                                        readonly>
                                                </th>
                                            </tr>
                                          </div>
                                        </div>
                                        </tbody>
                                    </table>

                                    <form class="form form-vertical" method="post" name="form2" id="havingform">
                                        @csrf

                                        <div class="form-group {{ $errors->has('nickname') ? 'has-error' : '' }}">
                                            <input type="hidden" id="id" name="id_anggota" required=""
                                                class="form-control">

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-sg-6 m-b-4">
                                                <div
                                                    class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                                                    <label for="username">Username<span
                                                            style="color: red">*</span></label>
                                                    <input type="text" id="username" value="{{$no_anggota}}"
                                                        name="username" class="form-control" placeholder="Username">
                                                    @if($errors->has('username'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('username') }}
                                                    </em>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-sg-6 m-b-4">
                                                <div
                                                    class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                                    <label for="password">Password <span
                                                            style="color: red">*</span></label>
                                                    <input type="password" id="password_1" name="password_1"
                                                        class="form-control" placeholder="password">
                                                    @if($errors->has('password'))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('password') }}
                                                    </em>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>




                                        <div>
                                            <button style="background-color:#D6A62C; color:#FFFF;" type="submit"
                                                class="btn ">
                                                <i class="fa fa-save"></i> Daftar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
            </blockquote>

        </div>
    </div>
<!--</div>-->
@stop
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />

<script>
    $(document).ready(function () {
        $(`.cari`).select2({
            placeholder: 'Select Anggota',
            ajax: {
                url: `/dpd/where/listuser/loaddata`,
                processResults: function (data) {
                    console.log(data)
                    return {
                        results: data
                    };
                },
                cache: true
            },

        });

    })
    $(document).ready(function () {
        $('.dynamic').change(function () {
            var id = $(this).val();
            var div = $(this).parent();
            var op = " ";

            $.ajax({
                url: `/dpd/where/listuser/searchAnggota`,
                method: "get",
                data: {
                    'id': id
                },
                success: function (data) {
                    console.log(data);
                    op += '<input value="0" disabled>';
                    for (var i = 0; i < data.length; i++) {

                        var no_member = data[i].no_member;
                        document.getElementById('no_member').value = no_member;

                        var nik_1 = data[i].nik_1;
                        document.getElementById('nik_1').value = nik_1;

                        var alamat_1 = data[i].alamat_1;
                        document.getElementById('alamat_1').value = alamat_1;

                        var id = data[i].id;
                        document.getElementById('id').value = id;

                        // var avatar = data[i].avatar;
                        // document.getElementById('avatar').value = avatar;

                        var roles = data[i].roles;
                        document.getElementById('roles').value = roles;

                        var provinsi_1 = data[i].provinsi_1;
                        document.getElementById('provinsi_1').value = provinsi_1;

                        var kabupaten_1 = data[i].kabupaten_1;
                        document.getElementById('kabupaten_1').value = kabupaten_1;

                        var kecamatan_1 = data[i].kecamatan_1;
                        document.getElementById('kecamatan_1').value = kecamatan_1;

                        var kelurahan_1 = data[i].kelurahan_1;
                        document.getElementById('kelurahan_1').value = kelurahan_1;


                    };
                },
                error: function () {}
            })
        })
    })
</script>
<script type="text/javascript">
    function submit_form() {
       
        document.form2.submit();
    }

    function myFunction() {
        var checkBox = document.getElementById("myCheck");
        var text = document.getElementById("text");
        var checkBox2 = document.getElementById("myCheck2");
        var text2 = document.getElementById("text2");

        if (checkBox.checked == true) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }

        if (checkBox2.checked == true) {
            text2.style.display = "block";
        } else {
            text2.style.display = "none";
        }
    }
</script>
<script>
    $(document).ready(function (e) {
        // $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#havingform').on('submit', function (e) {
            e.preventDefault();
            // $(this).html('Sending..');
            var username = $("#username").val();
            var password = $("#password_1").val();
            var nickname = $("#no_member").val();

            if (username == '') {
                swal('Error', 'Username Tidak Boleh Kosong');
                return false;
            }
            if (nickname == '') {
                swal('Error', 'Nama Anggota Tidak Boleh Kosong');
                return false;
            }

            if (password == '') {
                swal('Error', 'Password  Tidak Boleh Kosong');
                return false;
            }
            if (password.length < 7) {
                swal('Error', 'Password Harus 6 Karakter');
                return false;
            }
            var formHaving = new FormData(this);
            $.ajax({
                url: "{{ route('dpd.listuser.having') }}",
                type: "POST",
                data: formHaving,
                // dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if ((data.is_error) === true) {
                        swal('Error', data.error_msg);
                    } else {
                        swal('Info', data.error_msg);
                      document.getElementById("havingform").reset();
                        // $('#registrationForm').reset();
                        // parent.history.back();
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
            var password = $("#password").val();
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
            if (password == '') {
                swal('Error', 'Password  Tidak Boleh Kosong');
                return false;
            }
         
            if (password.length < 7 ) {
                swal('Error', 'Password Harus 6 Karakter');
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
                url: "{{ route('dpd.listuser.store') }}",
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
                        // parent.history.back();
                          document.location.reload(null, false)
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