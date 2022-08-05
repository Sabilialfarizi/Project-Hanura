@extends('layouts.master', ['title' => 'Provinsi'])

@section('content')
<div class="row">
    <div class="col-md-6">
        <h4 class="page-title">Edit Kantor Pusat</h4>
    </div>

    <div class="col-sm-6 text-right m-b-20">

    </div>
</div>
<style>
    .click-zoom input[type=checkbox] {
        display: none
    }

    .click-zoom img {
        transition: transform 0.25s ease;
        cursor: zoom-in
    }

    .click-zoom input[type=checkbox]:checked~img {
        transform: scale(3);
        cursor: zoom-out
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('cruds.information.title_singular') }} {{ trans('global.list') }} -->
                <!-- Informasi -->
            </div>

            <div class="card-body pl-4">
                <form method="post" enctype="multipart/form-data" action="{{ route('dpp.settings.kantor.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <label for="alamat" class="col-sm-2 col-form-label" placeholder="Alamat">Alamat</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="alamat" name="alamat"
                                rows="5">{{ old('alamat') }}{{ $kantor->alamat }}</textarea>
                            @if($errors->has('alamat'))
                            <strong class="text-danger">
                                {{ $errors->first('alamat') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">
                            <select name="provinsi" id="provinsi" class="form-control select2"
                                style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                @foreach($provinsi as $data => $row)
                                <option {{ $data == $kantor->provinsi ? 'selected' : '' }} value="{{ $data }}"
                                    name="{{ $row }}">{{ $row }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('provinsi'))
                            <strong class="text-danger">
                                {{ $errors->first('provinsi') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="kab_kota" class="col-sm-2 col-form-label">Kab/Kota</label>
                        <div class="col-10">
                            <select name="kab_kota" id="kab_kota" class="form-control select2"
                                style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                @foreach($kabupaten as $data => $row)
                                <option {{ $data == $kantor->kab_kota ? 'selected' : '' }} value="{{ $data }}"
                                    name="{{ $row }}">{{ $row }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kab_kota'))
                            <strong class="text-danger">
                                {{ $errors->first('kab_kota') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="kec" class="col-sm-2 col-form-label">Kecamatan</label>
                        <div class="col-10">
                            <select name="kec" id="kec" class="form-control select2" style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                @foreach($kecamatan as $data => $row)
                                <option {{ $data == $kantor->kec ? 'selected' : '' }} value="{{ $data }}"
                                    name="{{ $row }}">{{ $row }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kec'))
                            <strong class="text-danger">
                                {{ $errors->first('kec') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="kel" class="col-sm-2 col-form-label">Kelurahan</label>
                        <div class="col-10">
                            <select name="kel" id="kel" class="form-control select2" style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                @foreach($kelurahan as $data => $row)
                                <option {{ $data == $kantor->kel ? 'selected' : '' }} value="{{ $data }}"
                                    name="{{ $row }}">{{ $row }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('kel'))
                            <strong class="text-danger">
                                {{ $errors->first('kel') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="rt_rw" class="col-sm-2 col-form-label">RT/RW</label>
                        <div class="col-10">
                            <input type="text" name="rt_rw" class="form-control" id="rt_rw" placeholder="RT/RW"
                                value="{{ $kantor->rt_rw }}">
                            @if($errors->has('rt_rw'))
                            <strong class="text-danger">
                                {{ $errors->first('rt_rw') }}
                            </strong>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="kode_pos" class="col-sm-2 col-form-label">Kode Pos</label>
                        <div class="col-10">
                            <input type="text" name="kode_pos" class="form-control" id="kode_pos" placeholder="Kode Pos"
                                value="{{ $kantor->kode_pos }}">
                            @if($errors->has('kode_pos'))
                            <strong class="text-danger">
                                {{ $errors->first('kode_pos') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-10">
                            <input type="text" name="no_telp" class="form-control" id="no_telp"
                                placeholder="Nomor Telepon" value="{{ $kantor->no_telp }}">
                            @if($errors->has('no_telp'))
                            <strong class="text-danger">
                                {{ $errors->first('no_telp') }}
                            </strong>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="wa_kantor" class="col-sm-2 col-form-label">WhatsApp Kantor</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="15" name="wa_kantor" class="form-control" id="wa_kantor"
                                placeholder="WhatsApp Kantor" value="{{$kantor->wa_kantor}}">
                            @if($errors->has('wa_kantor'))
                            <strong class="text-danger">
                                {{ $errors->first('wa_kantor')}}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="fax" class="col-sm-2 col-form-label">Nomor Fax</label>
                        <div class="col-10">
                            <input type="text" name="fax" class="form-control" id="fax" placeholder="Nomor Fax"
                                value="{{ $kantor->fax }}">
                            @if($errors->has('fax'))
                            <strong class="text-danger">
                                {{ $errors->first('fax') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
                        <div class="col-10">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Alamat Email"
                                value="{{ $kantor->email }}">
                            @if($errors->has('email'))
                            <strong class="text-danger">
                                {{ $errors->first('email') }}
                            </strong>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="koordinat" class="col-sm-2 col-form-label">Koordinat</label>
                        <div class="col-10">
                            <input type="koordinat" name="koordinat" class="form-control" id="koordinat"
                                placeholder="Koordinat" value="{{ $kantor->koordinat }}">
                            @if($errors->has('koordinat'))
                            <strong class="text-danger">
                                {{ $errors->first('koordinat') }}
                            </strong>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">SK. Kemenkumham</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->no_sk))
                            <a style="font-size:14px;"
                               href="{{asset('/uploads/file/no_sk/'.$kantor->no_sk)}}"
                               >Download
                                SK. Kemenkumham</a>
                            @endif
                            <input type="hidden" name="no_sk_lama" value="{{ $kantor->no_sk ?? '' }}">
                            <input type="file" id="no_sk" accept=".pdf,.doc" name="no_sk" class="form-control" value="">
                            @if($errors->has('no_sk'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran SK. Kemenkumham Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Domisili</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->domisili))
                            <a style="font-size:14px;"
                              href="{{asset('/uploads/file/domisili/'.$kantor->domisili)}}">Download
                                Domisili</a>
                            @endif
                            <input type="hidden" name="domisili_lama" value="{{ $kantor->domisili ?? '' }}">
                            <input type="file" id="domisili" accept=".pdf,.doc" name="domisili" class="form-control"
                                value="">
                            @if($errors->has('domisili'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Domisili Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Surat Keterangan Kantor</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->surat_keterangan_kantor))
                            <a style="font-size:14px;"
                               href="{{asset('/uploads/file/surat_keterangan_kantor/'.$kantor->surat_keterangan_kantor)}}">Download
                                Surat Keterangan Kantor</a>
                            @endif
                            <input type="hidden" name="surat_keterangan_kantor_lama"
                                value="{{ $kantor->surat_keterangan_kantor ?? '' }}">
                            <input type="file" id="surat_keterangan_kantor" accept=".pdf,.doc"
                                name="surat_keterangan_kantor" class="form-control" value="">
                            @if($errors->has('surat_keterangan_kantor'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Surat Keterangan Kantor Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Rekening Bank</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->rekening_bank))
                            <a style="font-size:14px;"
                               href="{{asset('/uploads/file/rekening_bank/'.$kantor->rekening_bank)}}">Download
                                Rekening Bank</a>
                            @endif
                            <input type="hidden" name="rekening_bank_lama" value="{{ $kantor->rekening_bank ?? '' }}">
                            <input type="file" id="rekening_bank" accept=".pdf,.doc" name="rekening_bank"
                                class="form-control" value="">
                            @if($errors->has('rekening_bank'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Rekening Bank Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Akta Pendirian</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->akta_pendirian))
                            <a style="font-size:14px;"
                             href="{{asset('/uploads/file/akta_pendirian/'.$kantor->akta_pendirian)}}"
                                >Download
                                Akta Pendirian</a>
                            @endif
                            <input type="hidden" name="akta_pendirian_lama" value="{{ $kantor->akta_pendirian ?? '' }}">
                            <input type="file" id="akta_pendirian" accept=".pdf,.doc" name="akta_pendirian"
                                class="form-control" value="">
                            @if($errors->has('akta_pendirian'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Akta Pendirian Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="cap_kantor" class="col-sm-2 col-form-label">Upload Cap Kantor</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->cap_kantor))
                            <br>
                            <div class='click-zoom'>
                                <label>
                                    <input type='checkbox'>
                                    <img src="{{asset('uploads/img/cap_kantor/'.$kantor->cap_kantor)}}" alt='noimage'
                                        width='150px' height='100px'>
                                </label>
                            </div>
                            <input type="hidden" name="cap_kantor_lama" value="{{ $kantor->cap_kantor ?? '' }}">
                            <input type="file" accept="image/png, image/jpg, image/jpeg" id="cap_kantor"
                                name="cap_kantor" class="form-control" value="">
                            @else
                            <input type="hidden" name="cap_kantor_lama" value="{{ $kantor->cap_kantor ?? '' }}">
                            <input type="file" accept="image/png, image/jpg, image/jpeg" id="cap_kantor"
                                name="cap_kantor" class="form-control" value="">
                            @if($errors->has('cap_kantor'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Cap Kantor Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                jpg/jpeg/png</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <!--<label for="is_active" class="col-sm-2 col-form-label">Status Kantor</label>-->
                        <div class="col-10">
                            <input type="hidden" name="is_active" class="form-control" id="is_active"
                                placeholder="Status Kantor" value="{{ $kantor->is_active }}">
                            @if($errors->has('is_active'))
                            <strong class="text-danger">
                                {{ $errors->first('is_active') }}
                            </strong>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <!--<label for="is_active" class="col-sm-2 col-form-label">Status Kantor</label>-->
                        <div class="col-10">
                            <button style="background-color:#D6A62C; color:#FFFF;" type="submit" class="btn btn-lg">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
@stop

@section('footer')
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

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
            var email = $("#emailaddress").val();
            var rt_rw = $("#rt_rw").val();
            var address = $("#address").val();
            var provinsi = $("#provinsi").val();
            var kabupaten = $("#kabupaten").val();
            var kecamatan = $("#kecamatan").val();
            var kelurahan = $("#kelurahan").val();

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

            if (password.length < 7) {
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
            if (pendidikan == '') {
                swal('Error', 'Pendidikan Tidak Boleh Kosong');
                return false;
            }
            if (kode_pos == '') {
                swal('Error', 'Kode Pos Tidak Boleh Kosong');
                return false;
            }
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
            if (no_hp == '') {
                swal('Error', 'Nomor Hp Tidak Boleh Kosong');
                return false;
            }
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
                        $("#kabupaten_domisili").append("<option value='" + code + "' name='" +
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
                        $("#kecamatan_domisili").append("<option value='" + code + "' name='" +
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
                        $("#kelurahan_domisili").append("<option value='" + code + "' name='" +
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
                $('#kab_kota').find('option').remove();
                $("#kab_kota").prop('readonly', false);
                $("#kab_kota").append('<option value="">--Pilih--</option>');
                if (len > 1) {
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kab'];
                        var name = response[i]['name'];
                        $("#kab_kota").append("<option value='" + code + "' name='" + name + "'>" +
                            name + "</option>");
                    }
                }
            }
        });
    });

    $("#kab_kota").change(function () {
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
                $('#kec').find('option').remove();
                $("#kec").prop('readonly', false);
                $("#kec").append('<option value="">--Pilih--</option>');
                if (len > 1) {
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kec'];
                        var name = response[i]['name'];
                        $("#kec").append("<option value='" + code + "' name='" + name + "'>" +
                            name + "</option>");
                    }
                }
            }
        });
    });

    $("#kec").change(function () {
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
                $('#kel').find('option').remove();
                $("#kel").prop('readonly', false);
                $("#kel").append('<option value="">--Pilih--</option>');
                if (len > 1) {
                    for (var i = 0; i < len; i++) {
                        var code = response[i]['id_kel'];
                        var name = response[i]['name'];
                        $("#kel").append("<option value='" + code + "' name='" + name + "'>" +
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