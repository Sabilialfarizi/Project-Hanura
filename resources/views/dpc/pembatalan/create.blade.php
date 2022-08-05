@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-10 col-sg-6 m-b-6">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                Form Pembatalan Anggota
            </div>

            <div class="card-body">


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

                                <select class="cari form-control input-lg dynamic" id="nickname" name="nickname"
                                    data-dependent="no_member"></select>
                        <!--             @if($errors->has('nickname'))-->
                        <!--     <strong style="font-size:12px;" class="text-danger">-->
                        <!--               {{ $errors->first('nickname') }}-->
                        <!--    </strong>-->
                        <!--    <br>-->
                        <!--@endif-->

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

                                <input type="text" required id="no_member" name="no_member" maxlength="12"
                                    class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <th>:</th>
                            <th>

                                <input type="text" required id="roles" maxlength="12" class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <th>:</th>
                            <th>

                                <input type="text" required id="nik" class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <th>:</th>
                            <th>

                                <input type="text" required id="provinsi" class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>Kabupaten</th>
                            <th>:</th>
                            <th>

                                <input type="text" required id="kabupaten" class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>Kecamatan</th>
                            <th>:</th>
                            <th>

                                <input type="text" required id="kecamatan" class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>Kelurahan</th>
                            <th>:</th>
                            <th>

                                <input type="text" required id="kelurahan" class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <th>:</th>
                            <th>

                                <input type="text" required id="alamat" class="form-control" readonly>
                            </th>
                        </tr>
                    </tbody>
                </table>

               <form class="form-material mt-4" action="{{ route('dpc.pembatalan.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('nickname') ? 'has-error' : '' }}">
                        <input type="hidden" id="id" name="id_anggota" required="" class="form-control">

                    </div>

                    <div class="form-group">
                        <label for="alasan_pembatalan">Alasan Pembatalan <span style="color: red">*</span></label>
                        <textarea rows="5" class="form-control" value="" name="alasan_pembatalan" 
                            id="alasan_pembatalan" placeholder="Alasan Pembatalan"
                            ></textarea>
                        @if($errors->has('alasan_pembatalan'))
                             <strong style="font-size:12px;" class="text-danger">
                                       {{ $errors->first('alasan_pembatalan') }}
                            </strong>
                            <br>
                        @endif

                    </div>

                    <div class="form-group">
                        <label for="dokumen_pendukung">Dokumen Pendukung </label>
                        <input type="file" id="dokumen_pendukung" accept=".pdf,.doc" name="dokumen_pendukung"
                            class="form-control" value="">
                         @if($errors->has('dokumen_pendukung'))
                             <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Pakta Intergritas Kurang Dari 2 MB
                            </strong>
                            <br>
                        @endif
                         <label style="font-size:12px; "for="password"> <i class="fa-solid fa-triangle-exclamation"></i> Maksimum 2mb, format pdf/doc</label>
                    </div>

                    <div class="modal-footer">
                        <a href="{{ route('dpc.pembatalan.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                        <button type="submit" class="btn "
                            style="background-color:#D6A62C; color:#FFFF;">{{ __('Simpan') }}</button>
                    </div>
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
                </form>

            </div>
        </div>
    </div>
</div>
@stop
@section('footer')

<script>
    $(document).ready(function (e) {
        // $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#pembatalanForm').on('submit', function (e) {
            e.preventDefault();

            var name = $("#no_member").val();

            var alasan = $("#alasan_pembatalan").val();
       
           


            // var pakta = parseFloat(pakta_intergritas.files[2].size / (1024 * 1024)).toFixed(2); 
            if (name == '') {
                swal('Error', 'Nama Anggota Tidak Boleh Kosong');
                return false;
            }
            if (alasan == '') {
                swal('Error', 'Alasan Pembatalan Tidak Boleh Kosong');
                return false;
            }
             

            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('dpc.pembatalan.store') }}",
                type: "POST",
                data: formData,
                // dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if ((data.is_error) === true) {
                        swal('Error', data.error_msg);
                    } else {
                        swal('Info', data.error_msg);
                        document.getElementById("pembatalanForm").reset();
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


    $(document).ready(function () {
        $(`.cari`).select2({
            placeholder: 'Select Anggota',
            ajax: {
                url: `/dpc/where/pembatalan/load`,
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
                url: `/dpc/where/pembatalan/search`,
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

                        var nik = data[i].nik;
                        document.getElementById('nik').value = nik;

                        var alamat = data[i].alamat;
                        document.getElementById('alamat').value = alamat;

                        var id = data[i].id;
                        document.getElementById('id').value = id;

                        // var avatar = data[i].avatar;
                        // document.getElementById('avatar').value = avatar;

                        var roles = data[i].roles;
                        document.getElementById('roles').value = roles;

                        var provinsi = data[i].provinsi;
                        document.getElementById('provinsi').value = provinsi;

                        var kabupaten = data[i].kabupaten;
                        document.getElementById('kabupaten').value = kabupaten;

                        var kecamatan = data[i].kecamatan;
                        document.getElementById('kecamatan').value = kecamatan;

                        var kelurahan = data[i].kelurahan;
                        document.getElementById('kelurahan').value = kelurahan;


                    };
                },
                error: function () {}
            })
        })
    })
</script>
@stop