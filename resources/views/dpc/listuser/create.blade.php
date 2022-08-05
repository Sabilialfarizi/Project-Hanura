@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-12 col-sg-12 m-b-4">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                <label> Form Pendaftaran User DPC Kabupaten / Kota <span style="font-size:15px;">
                        @php
                        $name = \App\Kabupaten::getKab($detail->kabupaten_domisili)
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

                                                <tr>
                                                    <th>Nama Anggota</th>
                                                    <th>:</th>
                                                    <th>

                                                        <select class="cari form-control input-lg dynamic" id="nickname"
                                                            name="nickname" data-dependent="no_member"></select>

                                                    </th>
                                                </tr>
                                               
                                                <tr>
                                                    <th>NO. KTA</th>
                                                    <th>:</th>
                                                    <th>

                                                        <input type="text" required id="no_member" maxlength="12"
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

                                                        <input type="text" required id="kabupaten_1"
                                                            class="form-control" readonly>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Kecamatan</th>
                                                    <th>:</th>
                                                    <th>

                                                        <input type="text" required id="kecamatan_1"
                                                            class="form-control" readonly>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Kelurahan</th>
                                                    <th>:</th>
                                                    <th>

                                                        <input type="text" required id="kelurahan_1"
                                                            class="form-control" readonly>
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
                                            </tbody>
                                        </table>

                                        <form class="form form-vertical" method="post"  id="havingform">
                                            @csrf

                                            <div class="form-group {{ $errors->has('nickname') ? 'has-error' : '' }}">
                                                <input type="hidden" id="id" name="id_anggota" required=""
                                                    class="form-control">

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 col-sg-4 m-b-4">
                                                    <div
                                                        class="form-group {{ $errors->has('jabatan') ? 'has-error' : '' }}">
                                                        <label for="jabatan">Hak Akses <span
                                                                style="color: red">*</span></label>
                                                        <select name="jabatan" id="jabatan" class="form-control">
                                                            <option value="">Pilih Hak Akses</option>
                                                            <option value="1">DPC</option>
                                                            <option value="2">PAC</option>
                                                        </select>
                                                        @if($errors->has('jabatan'))
                                                        <em class="invalid-feedback">
                                                            {{ $errors->first('jabatan') }}
                                                        </em>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-sg-4 m-b-4">
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
                                                <div class="col-sm-4 col-sg-4 m-b-4">
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

    </div>
    @stop
    @section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />

    <script>
        $(document).ready(function () {
            $(`.cari`).select2({
                placeholder: 'Select Anggota',
                ajax: {
                    url: `/dpc/where/listuser/loaddata`,
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
                    url: `/dpc/where/listuser/searchAnggota`,
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

                            // var roles = data[i].roles;
                            // document.getElementById('roles').value = roles;

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
            document.form1.submit();
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
                var jabatan = $("#jabatan").val();
                var username = $("#username").val();
                var password = $("#password_1").val();
                var nickname = $("#no_member").val();

                if (jabatan == '') {
                    swal('Error', 'Jabatan Tidak Boleh Kosong');
                    return false;
                }
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
                    url: "{{ route('dpc.listuser.having') }}",
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

       
    </script>
    @stop