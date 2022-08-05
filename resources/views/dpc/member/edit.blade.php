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
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('nickname', $member->nickname) }}" placeholder="Nama" value=""
                                       >

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
                                         <p id="demo"></p>
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
                                    <label for="emailaddress">Email </label>
                                    <input type="text" id="emailaddress" name="emailaddress"
                                        value="{{ old('email', $detail->email) }}" class="form-control"
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
                                        <option {{ $data == $member->gender ? 'selected' : '' }} value="{{ $data }}">
                                            {{ $row }}
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
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sg-6 m-b-6">
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
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('tgl_lahir') ? 'has-error' : '' }}">
                                    <label for="tgl_lahir">Tanggal Lahir <span style="color: red">*</span></label>
                                     <div class="input-group">
                                            <input id="tgl_lahir" type="text" name="tgl_lahir" class="form-control date-input" placeholder="Tanggal Lahir"
                                            value="{{Carbon\Carbon::parse($member->tgl_lahir)->format('d-m-Y') }}"/>
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                            
                                    </div>
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
                                        <option {{ $data == $member->status_kawin ? 'selected' : '' }}
                                            value="{{ $data }}">
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


                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">
                                    <label for="job">Pekerjaan <span style="color: red">*</span></label>
                                    <select name="job" id="job" class="form-control selectpicker"
                                        style="width: 100%; height:36px;" data-live-search="true">
                                        <option value="">-- Pilih --</option>
                                        @foreach($job as $data => $row)
                                        <option {{ $data == $member->pekerjaan ? 'selected' : '' }} value="{{ $data }}">
                                            {{ $row }}
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
                        </div>
                        <div class="row">
                            <!--<div class="col-sm-6 col-sg-6 m-b-6">-->
                            <!--    <div class="form-group {{ $errors->has('job') ? 'has-error' : '' }}">-->
                            <!--        <label for="pendidikan">Pendidikan <span style="color: red">*</span></label>-->
                            <!--        <select name="status_pendidikan" id="status_pendidikan"-->
                            <!--            class="form-control selectpicker" style="width: 100%; height:36px;"-->
                            <!--            data-live-search="true">-->
                            <!--            <option value="">-- Pilih --</option>-->
                            <!--            @foreach($pendidikan as $data => $row)-->
                            <!--            <option {{ $data == $member->pendidikan ? 'selected' : '' }}-->
                            <!--                value="{{ $data }}">-->
                            <!--                {{ $row }}-->
                            <!--            </option>-->
                            <!--            @endforeach-->
                            <!--        </select>-->
                            <!--        @if($errors->has('status_pendidikan'))-->
                            <!--        <em class="invalid-feedback">-->
                            <!--            {{ $errors->first('status_pendidikan') }}-->
                            <!--        </em>-->
                            <!--        @endif-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('agama') ? 'has-error' : '' }}">
                                    <label for="agama">Agama <span style="color: red">*</span></label>
                                    <select name="agama" id="agama" class="form-control selectpicker"
                                        style="width: 100%; height:36px;" data-live-search="true">
                                        <option value="">-- Pilih --</option>
                                        @foreach($agama as $data => $row)
                                        <option {{ $data == $member->agama ? 'selected' : '' }} value="{{ $data }}">
                                            {{ $row }}
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
                 
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('no_hp') ? 'has-error' : '' }}">
                                    <label for="no_hp">No. Hp </label>
                                    <input type="text" id="no_hp" maxlength="14" name="no_hp"
                                        value="{{ old('no_hp', $member->no_hp) }}" placeholder="Nomor HP"
                                        class="form-control" onKeyUp="numericFilter(this);">
                                    @if($errors->has('no_hp'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('no_hp') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                            @if($member->status_kta == 1)
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('created_at') ? 'has-error' : '' }}">
                                    <label for="tgl_pengesahan">Tanggal Pengesahan  <span style="color: red">*</span></label>
                                    <input type="date" id="created_at" name="created_at" class="form-control"
                                        value="{{ old('created_at', Carbon\Carbon::parse($member->created_at)->format('Y-m-d')) }}">
                                    @if($errors->has('created_at'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('created_at') }}
                                    </em>
                                    @endif
                                </div>
                            </div>
                            @else
                            
                            @endif

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
                            <div class="col-sm-4 col-sg-4 m-b-4">
                                <div class="form-group {{ $errors->has('kecamatan') ? 'has-error' : '' }}">
                                    <label for="kecamatan">Kecamatan <span style="color: red">*</span></label>
                             
                                    @php
                                    $kecamatan = \App\Kecamatan::getKec($member->kecamatan_domisili)
                                    @endphp
                                    <input readonly class="form-control" value="{{$kecamatan->name ?? ''}}">
                                    <input name="kecamatan" id="kecamatan" type="hidden" class="form-control"
                                        value="{{$member->kecamatan_domisili ?? ''}}">
                                    @if($errors->has('kecamatan'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('kecamatan') }}
                                    </em>
                                    @endif
                                </div>
                            </div>


                            <div class="col-sm-4 col-sg-4 m-b-4">
                                <div class="form-group {{ $errors->has('kelurahan') ? 'has-error' : '' }}">
                                    <label for="kelurahan">Kelurahan / Desa<span style="color: red">*</span></label>
                                    @php
                                    $kelurahan = \App\Kelurahan::getKel($member->kelurahan_domisili)
                                    @endphp
                                      <input readonly class="form-control" value="{{$kelurahan->name ?? ''}}">
                                     <input name="kelurahan" id="kelurahan" type="hidden" class="form-control"
                                        value="{{$member->kelurahan_domisili ?? ''}}">

                                   
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
                                    <input type="text" id="rt_rw" value="{{ old('rt_rw', $member->rt_rw) }}"
                                        name="rt_rw" class="form-control" placeholder="RT dan RW">
                                        <label style="font-size:12px; " for="password"> <i
                                            class="fa-solid fa-triangle-exclamation"></i>  contoh(005/008)</label>
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
                                placeholder="Alamat">{{$member->alamat}}</textarea>
                            @if($errors->has('address'))
                            <em class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </em>
                            @endif
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
                            <?php
                                $fot_ktp = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/foto_ktp/'.$member->foto_ktp) && !empty($member->foto_ktp)?
                                            '/www/wwwroot/siap.partaihanura.or.id/uploads/img/foto_ktp/'.$member->foto_ktp : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ektp.png';
                                            
                               
                                
                                $type_ktp = pathinfo($fot_ktp, PATHINFO_EXTENSION);
                                
                                 if (file_exists($fot_ktp)){
                                     $data_ktp =  file_get_contents($fot_ktp);
                                } else {
                                     $data_ktp = file_get_contents('/www/wwwroot/siap.partaihanura.or.id/uploads/img/ektp.png');
                                }
                                
                                $pic_ktp = 'data:image/' . $type_ktp . ';base64,' .base64_encode($data_ktp);
                            ?>
                            <div class="col-sm-6 col-sg-6 m-b-6">
                                <div class="form-group {{ $errors->has('foto_ktp') ? 'has-error' : '' }}">
                                    <label for="foto_ktp">Foto KTP <span style="color: red">*</span></label>
                                    @if(!empty($member->foto_ktp))
                                    <br>
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="<?php echo $pic_ktp ?>"
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
                            <!--<div class="col-sm-6 col-sg-6 m-b-6">-->
                            <!--    <div class="form-group {{ $errors->has('pakta_intergritas') ? 'has-error' : '' }}">-->
                            <!--        <label for="pakta_intergritas">Pakta Intergritas</label>-->
                            <!--        @if(!empty($member->pakta_intergritas))-->
                            <!--         <a style="font-size:14px;" href="{{url('/dpc/listuser/'.$member->id.'/download')}}">Download Pakta Intergritas</a>-->
                            <!--         @endif-->
                            <!--        <input type="hidden" name="pakta_intergritas_lama"-->
                            <!--            value="{{ $member->pakta_intergritas ?? '' }}">-->
                            <!--        <input type="file" id="pakta_intergritas" name="pakta_intergritas"-->
                            <!--            class="form-control" value="" accept=".pdf,.doc">-->
                            <!--        @if($errors->has('pakta_intergritas'))-->
                            <!--        <strong style="font-size:12px;" class="text-danger">-->
                            <!--            Silakan Pilih Ukuran Pakta Intergritas Kurang Dari 2 MB-->
                            <!--        </strong>-->
                            <!--        <br>-->
                            <!--        @endif-->
                            <!--        <label style="font-size:12px; " for="password"> <i-->
                            <!--                class="fa-solid fa-triangle-exclamation"></i> Maksimum 2mb, format-->
                            <!--            pdf/doc</label>-->
                            <!--    </div>-->
                            <!--</div>-->

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
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
        $(function () {
          $('#tgl_lahir').datepicker({
             format: "dd-mm-yyyy"
            });
        });
</script>
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
              
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kab'];
                        var name = response[i]['name'];
                        $("#kabupaten").append("<option value='" + code + "' name='" + name + "'>" +
                            name + "</option>");
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
              
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kec'];
                        var name = response[i]['name'];
                        $("#kecamatan").append("<option value='" + code + "' name='" + name + "'>" +
                            name + "</option>");
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
               
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kel'];
                        var name = response[i]['name'];
                        $("#kelurahan").append("<option value='" + code + "' name='" + name + "'>" +
                            name + "</option>");
                    }
                
            }
        });
    });

    function numericFilter(txb) {
        txb.value = txb.value.replace(/[^\0-9]/ig, "");
    }
     document.getElementById("nik").addEventListener("change", check_nik);

    function check_nik() {
        var x = document.getElementById("nik");
        var y = x.value.length;
        document.getElementById("demo").innerHTML = "Panjang Karakter: " + y;
    } 
</script>
@stop