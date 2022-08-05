@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
        Form Edit Anggota
    </div>

    <div class="card-body">

        <form class="form-material mt-4" action="{{ route('dpc.member.update', $member->id) }}" method="POST"
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
            <div class="row">
                <div class="col-sm-4 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="nama">Nama Lengkap (Sesuai Ktp) <span style="color: red">*</span></label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('nickname', $member->nickname) }}" placeholder="Nama" value=""
                            onKeyUp="uppercase(this);">
                        @if($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('nik') ? 'has-error' : '' }}">
                        <label for="no_ktp">NIK <span style="color: red">*</span></label>
                        <input type="text" id="nik" name="nik" class="form-control"
                            value="{{ old('nik', $member->nik) }}" placeholder="Nomor KTP" value=""
                            onKeyUp="numericFilter(this);">
                        @if($errors->has('nik'))
                        <em class="invalid-feedback">
                            {{ $errors->first('nik') }}
                        </em>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="emailaddress">Email <span style="color: red">*</span></label>
                        <input type="text" id="emailaddress" name="emailaddress"
                            value="{{ old('email', $detail->email) }}" class="form-control" placeholder="Alamat Email"
                            value="">
                        @if($errors->has('emailaddress'))
                        <em class="invalid-feedback">
                            {{ $errors->first('emailaddress') }}
                        </em>
                        @endif
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-sm-3 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                        <label for="gender">Jenis Kelamin <span style="color: red">*</span></label>
                        <select name="gender" id="gender" class="form-control select2"
                            style="width: 100%; height:36px;">
                            <option value="">-- Pilih --</option>
                            @foreach($jenis_kelamin as $data => $row)
                            <option {{ $data == $member->gender ? 'selected' : '' }} value="{{ $data }}">{{ $row }}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('gender'))
                        <em class="invalid-feedback">
                            {{ $errors->first('gender') }}
                        </em>
                        @endif
                    </div>

                </div>
                <div class="col-sm-3 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('tempat_lahir') ? 'has-error' : '' }}">
                        <label for="tempat_lahir">Tempat Lahir <span style="color: red">*</span></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('birth_place', $member->birth_place) }}" class="form-control"
                            placeholder="Tempat Lahir" onKeyUp="uppercase(this);">
                        @if($errors->has('tempat_lahir'))
                        <em class="invalid-feedback">
                            {{ $errors->first('tempat_lahir') }}
                        </em>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('tgl_lahir') ? 'has-error' : '' }}">
                        <label for="tgl_lahir">Tanggal Lahir <span style="color: red">*</span></label>
                        <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control"
                            value="{{ old('tgl_lahir', Carbon\Carbon::parse($member->tgl_lahir)->format('Y-m-d')) }}">
                        @if($errors->has('tgl_lahir'))
                        <em class="invalid-feedback">
                            {{ $errors->first('tgl_lahir') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                </div>
                <div class="col-sm-3 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('marital_status') ? 'has-error' : '' }}">
                        <label for="marital">Status Pernikahan <span style="color: red">*</span></label>
                        <select name="marital" id="marital" class="form-control select2"
                            style="width: 100%; height:36px;">

                            <option value="">-- Pilih --</option>
                            @foreach($marital as $data => $row)
                            <option {{ $data == $member->status_kawin ? 'selected' : '' }} value="{{ $data }}">
                                {{ $row }}</option>
                            @endforeach

                        </select>
                        @if($errors->has('marital_status'))
                        <em class="invalid-feedback">
                            {{ $errors->first('marital_status') }}
                        </em>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-3 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">
                        <label for="job">Pekerjaan <span style="color: red">*</span></label>
                        <select name="job" id="job" class="form-control selectpicker" style="width: 100%; height:36px;"
                            data-live-search="true">
                            <option value="">-- Pilih --</option>
                            @foreach($job as $data => $row)
                            <option {{ $data == $member->pekerjaan ? 'selected' : '' }} value="{{ $data }}">{{ $row }}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('job'))
                        <em class="invalid-feedback">
                            {{ $errors->first('job') }}
                        </em>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">
                        <label for="pendidikan">Pendidikan <span style="color: red">*</span></label>
                        <select name="status_pendidikan" id="status_pendidikan" class="form-control selectpicker"
                            style="width: 100%; height:36px;" data-live-search="true">
                            <option value="">-- Pilih --</option>
                            @foreach($pendidikan as $data => $row)
                            <option {{ $data == $member->pendidikan ? 'selected' : '' }} value="{{ $data }}">{{ $row }}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('status_pendidikan'))
                        <em class="invalid-feedback">
                            {{ $errors->first('status_pendidikan') }}
                        </em>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">
                        <label for="agama">Agama <span style="color: red">*</span></label>
                        <select name="agama" id="agama" class="form-control selectpicker"
                            style="width: 100%; height:36px;" data-live-search="true">
                            <option value="">-- Pilih --</option>
                            @foreach($agama as $data => $row)
                            <option {{ $data == $member->agama ? 'selected' : '' }} value="{{ $data }}">{{ $row }}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('agama'))
                        <em class="invalid-feedback">
                            {{ $errors->first('agama') }}
                        </em>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('no_hp') ? 'has-error' : '' }}">
                        <label for="no_hp">No. Hp <span style="color: red">*</span></label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $member->no_hp) }}"
                            placeholder="Nomor HP" class="form-control" onKeyUp="numericFilter(this);">
                        @if($errors->has('no_hp'))
                        <em class="invalid-feedback">
                            {{ $errors->first('no_hp') }}
                        </em>
                        @endif
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-4 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                        <label for="avatar">Foto Profil <span style="color: red">*</span></label>
                        <input type="file" id="avatar" name="avatar" required="" class="form-control" value="">
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
                        <input type="file" id="foto_ktp" name="foto_ktp" required="" class="form-control" value="">
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
                        <label for="pakta_intergritas">Pakta Intergritas <span style="color: red">*</span></label>
                        <input type="file" id="pakta_intergritas" required="" name="pakta_intergritas"
                            class="form-control" value="">
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
            <div class="row">
                <div class="col-sm-4 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('kecamatan') ? 'has-error' : '' }}">
                        <label for="kecamatan">Kecamatan <span style="color: red">*</span></label>
                        <select name="kecamatan" id="kecamatan" class="form-control select2"
                            style="width: 100%; height:36px;">
                            <option value="">-- Pilih --</option>
                            @foreach($kecamatan as $data => $row)
                            <option {{ $data == $member->kecamatan_domisili ? 'selected' : '' }} value="{{ $data }}"
                                name="{{ $row }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('kecamatan'))
                        <em class="invalid-feedback">
                            {{ $errors->first('kecamatan') }}
                        </em>
                        @endif
                    </div>
                </div>


                <div class="col-sm-4 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('kelurahan') ? 'has-error' : '' }}">
                        <label for="kelurahan">Kelurahan <span style="color: red">*</span></label>

                        <select name="kelurahan" id="kelurahan" class="form-control select2"
                            style="width: 100%; height:36px;">
                            <option value="">-- Pilih --</option>
                            @foreach($kelurahan as $data => $row)
                            <option {{ $data == $member->kelurahan_domisili ? 'selected' : '' }} value="{{ $data }}"
                                name="{{ $row }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('kelurahan'))
                        <em class="invalid-feedback">
                            {{ $errors->first('kelurahan') }}
                        </em>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('rt_rw') ? 'has-error' : '' }}">
                        <label for="rt_rw">RT / RW <span style="color: red">*</span></label>
                        <input type="text" id="rt_rw" value="{{ old('rt_rw', $member->rt_rw) }}" name="rt_rw"
                            class="form-control" placeholder="RT dan RW">
                        @if($errors->has('rt_rw'))
                        <em class="invalid-feedback">
                            {{ $errors->first('rt_rw') }}
                        </em>
                        @endif
                    </div>
                </div>
                <!--<div class="col-sm-4 col-sg-4 m-b-4">-->
                <!--                <div class="form-group {{ $errors->has('kode_pos') ? 'has-error' : '' }}">-->
                <!--                    <label for="kode_pos">Kode Pos <span style="color: red">*</span></label>-->
                <!--                    <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $member->kode_pos) }}"class="form-control" placeholder ="Kode Pos">-->
                <!--                    @if($errors->has('kode_pos'))-->
                <!--                    <em class="invalid-feedback">-->
                <!--                        {{ $errors->first('kode_pos') }}-->
                <!--                    </em>-->
                <!--                    @endif-->
                <!--                </div>-->
                <!--            </div>-->
                <div class="col-sm-4 col-sg-4 m-b-4">
                    <div class="form-group {{ $errors->has('provinsi') ? 'has-error' : '' }}">
                        <!--<label for="provinsi">Provinsi <span style="color: red">*</span></label>-->
                        <select hidden name="provinsi" id="provinsi" class="form-control select2"
                            style="width: 100%; height:36px;">
                            <option value="">-- Pilih --</option>
                            @foreach($provinsi as $data => $row)
                            <option {{ $data == $member->provinsi_domisili ? 'selected' : '' }} value="{{ $data }}"
                                name="{{ $row }}">{{ $row }}</option>
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

            <div class="form-group">
                <label for="address">Alamat <span style="color: red">*</span></label>
                <textarea name="address" id="address" class="form-control" cols="20" rows="10"
                    placeholder="Alamat Sesuai KTP">{{$member->alamat}}</textarea>
                @if($errors->has('address'))
                <em class="invalid-feedback">
                    {{ $errors->first('address') }}
                </em>
                @endif
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Daftar
                </button>
            </div>
            <div class="col-sm-4 col-sg-4 m-b-4">
                <div class="form-group {{ $errors->has('kabupaten') ? 'has-error' : '' }}">
                    <!--<label for="kabupaten">Kabupaten <span style="color: red">*</span></label>-->
                    <select hidden name="kabupaten" id="kabupaten" class="form-control select2"
                        style="width: 100%; height:36px;">
                        <option value="">-- Pilih --</option>
                        @foreach($kabupaten as $data => $row)
                        <option {{ $data == $member->kabupaten_domisili ? 'selected' : '' }} value="{{ $data }}"
                            name="{{ $row }}">{{ $row }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('kabupaten'))
                    <em class="invalid-feedback">
                        {{ $errors->first('kabupaten') }}
                    </em>
                    @endif
                </div>
            </div>



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



                function validateEmail($email) {
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    return emailReg.test($email);
                }

                function uppercase(obj) {
                    obj.value = obj.value.toUpperCase();
                }

                $("#provinsi_domisili").change(function () {
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
                            $('#kabupaten_domisili').find('option').remove();
                            $("#kabupaten_domisili").prop('readonly', false);
                            $("#kabupaten_domisili").append('<option value="">--Pilih--</option>');
                            if (len > 1) {
                                for (var i = 0; i < len; i++) {
                                    var code = response[i]['id_kab'];
                                    var name = response[i]['name'];
                                    $("#kabupaten_domisili").append("<option value='" + code +
                                        "' name='" +
                                        name + "'>" + name + "</option>");
                                }
                            }
                        }
                    });
                });

                $("#kabupaten_domisili").change(function () {
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
                            $('#kecamatan_domisili').find('option').remove();
                            $("#kecamatan_domisili").prop('readonly', false);
                            $("#kecamatan_domisili").append('<option value="">--Pilih--</option>');
                            if (len > 1) {
                                for (var i = 0; i < len; i++) {
                                    var code = response[i]['id_kec'];
                                    var name = response[i]['name'];
                                    $("#kecamatan_domisili").append("<option value='" + code +
                                        "' name='" +
                                        name + "'>" + name + "</option>");
                                }
                            }
                        }
                    });
                });

                $("#kecamatan_domisili").change(function () {
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
                            $('#kelurahan_domisili').find('option').remove();
                            $("#kelurahan_domisili").prop('readonly', false);
                            $("#kelurahan_domisili").append('<option value="">--Pilih--</option>');
                            if (len > 1) {
                                for (var i = 0; i < len; i++) {
                                    var code = response[i]['id_kel'];
                                    var name = response[i]['name'];
                                    $("#kelurahan_domisili").append("<option value='" + code +
                                        "' name='" +
                                        name + "'>" + name + "</option>");
                                }
                            }
                        }
                    });
                });

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
                                    $("#kabupaten").append("<option value='" + code + "' name='" +
                                        name + "'>" +
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
                                    $("#kecamatan").append("<option value='" + code + "' name='" +
                                        name + "'>" +
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
                                    $("#kelurahan").append("<option value='" + code + "' name='" +
                                        name + "'>" +
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