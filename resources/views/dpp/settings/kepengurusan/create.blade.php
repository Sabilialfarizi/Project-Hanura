@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/file-choose.css">

    <div class="card">
        <div class="card-header">
            <strong>Form Kepengurusan</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('dpp.settings.kepengurusan.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                    <!--<div class="form-group row">-->
                        <table class="table table-borderless">
                            
                            <tbody>

                                <tr>
                                    <th>Cari Anggota</th>
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

                                <tr>
                                    <th>Nama</th>
                                    <th>:</th>
                                    <th>
                                        <input type="text" name="nama" class="form-control" id="name">
                                        @if($errors->has('nama'))
                                        <strong class="text-danger">
                                            {{ $errors->first('nama') }}
                                        </strong>
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th>NO. KTA</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" name="kta" class="form-control" id="no_member"
                                            value="{{ $kepengurusan->kta ?? '' }}" readonly>
                                        @if($errors->has('kta'))
                                        <strong class="text-danger">
                                            {{ $errors->first('kta') }}
                                        </strong>
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <th>:</th>
                                    <th>
                                        <input type="number" name="nik" class="form-control" id="nik"
                                            value="{{ $kepengurusan->nik ?? '' }}" readonly>
                                        @if($errors->has('nik'))
                                        <strong class="text-danger">
                                            {{ $errors->first('nik') }}
                                        </strong>
                                        @endif

                                    </th>
                                </tr>
                                <!--<tr>-->
                                <!--    <th>Provinsi</th>-->
                                <!--    <th>:</th>-->
                                <!--    <th>-->

                                <!--        <input type="text" required id="provinsi" class="form-control" readonly>-->
                                <!--    </th>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <th>Kabupaten</th>-->
                                <!--    <th>:</th>-->
                                <!--    <th>-->

                                <!--        <input type="text" required id="kabupaten" class="form-control" readonly>-->
                                <!--    </th>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <th>Kecamatan</th>-->
                                <!--    <th>:</th>-->
                                <!--    <th>-->

                                <!--        <input type="text" required id="kecamatan" class="form-control" readonly>-->
                                <!--    </th>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <th>Kelurahan</th>-->
                                <!--    <th>:</th>-->
                                <!--    <th>-->

                                <!--        <input type="text" required id="kelurahan" class="form-control" readonly>-->
                                <!--    </th>-->
                                <!--</tr>-->
                               
                               <tr>
                                    <th>Jabatan</th>
                                    <th>:</th>
                                    <th>

                                        <select name="jabatan" id="jabatan" class="form-control select2"
                                             onchange="showDiv(this)" style="width: 100%; height:36px;">
                                            <option value="" selected disabled hidden>-- Pilih --</option>
                                            @foreach($jabatan as $data)
                                            <option value="{{ $data->kode }}">{{ $data->nama }}  ({{$data->kode}})</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('jabatan'))
                                        <strong class="text-danger">
                                            {{ $errors->first('jabatan') }}
                                        </strong>
                                        @endif
                                    </th>
                                </tr>
                            <!--    <tr>-->


                            <!--<th>Isi Nama Jabatan (Pilih Lainnya)</th>-->
                            <!--<th>:</th>-->
                            <!--<th>-->
                            <!--    <div id="hidden_div">-->
                            <!--        <input disabled type="text" name="other_jabatan" class="form-control"-->
                            <!--            placeholder="Isi Nama Jabatan (Opsional)" id="other_jabatan"-->
                            <!--            value="{{ $kepengurusan->other_jabatan ?? '' }}">-->
                            <!--        <label style="font-size:12px; " for="other_jabatan"> <i-->
                            <!--                class="fa-solid fa-triangle-exclamation"></i> Opsional Jika Tidak Ada Jabatan-->
                            <!--            Yang Dipilih</label>-->
                            <!--        @if($errors->has('other_jabatan'))-->
                            <!--        <strong class="text-danger">-->
                            <!--            {{ $errors->first('other_jabatan') }}-->
                            <!--        </strong>-->
                            <!--        @endif-->

                            <!--    </div>-->
                            <!--</th>-->
                            <!--</tr>-->
                                <tr>
                                    <th>Nomor SK</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" name="no_sk" class="form-control" id="no_sk"
                                            value="{{ $kepengurusan->no_sk ?? '' }}">
                                        @if($errors->has('no_sk'))
                                        <strong class="text-danger">
                                            {{ $errors->first('no_sk') }}
                                        </strong>
                                        @endif
                                    </th>
                                </tr>
                                 <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <th>

                                        <textarea type="text" name="alamat_kantor" class="form-control" id="alamat"
                                            rows="3" >{{ $kepengurusan->alamat_kantor ?? '' }}</textarea>
                                        @if($errors->has('alamat_kantor'))
                                        <strong class="text-danger">
                                            {{ $errors->first('alamat_kantor') }}
                                        </strong>
                                        @endif
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    <!--</div>-->
                </div>

                    <div class="col-lg-3 col-12 d-flex justify-content-center mb-lg-0 mb-3">
                        <div class="file-input text-center">
                            <input type="file" id="foto" name="foto" class="file">
                            <label for="foto">
                                Upload Foto
                                <p class="file-name file-name-foto"></p>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12 d-flex justify-content-center">
                        <div class="file-input text-center">
                            <input type="file" id="ttd" name="ttd" class="file">
                            <label for="ttd">
                                Upload TTD
                                <p class="file-name file-name-ttd"></p>
                            </label>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn" style="background-color:#D6A62C; color:#ffff; font-weight:bold;">
                            <i class="fa fa-save"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('footer')
<script>
    function showDiv(select) {

        if (select.value == 1004) {
            $("#other_jabatan").prop('disabled', false);
        } else {
            $("#other_jabatan").prop('disabled', true);
            var name = $("#other_jabatan").val('');
        }
    }
</script>
<script>
    $(document).ready(function () {
        $(`.cari`).select2({
            placeholder: 'Select Anggota',
            ajax: {
                url: `/dpp/where/settings/kepengurusan/loaddata`,
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
                url: `/dpp/where/settings/kepengurusan/searchAnggota`,
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

                        var name = data[i].name;
                        document.getElementById('name').value = name;

                        // var id = data[i].id;
                        // document.getElementById('id').value = id;

                        // var avatar = data[i].avatar;
                        // document.getElementById('avatar').value = avatar;

                        // var roles = data[i].roles;
                        // document.getElementById('roles').value = roles;

                        // var provinsi = data[i].provinsi;
                        // document.getElementById('provinsi').value = provinsi;

                        // var kabupaten = data[i].kabupaten;
                        // document.getElementById('kabupaten').value = kabupaten;

                        // var kecamatan = data[i].kecamatan;
                        // document.getElementById('kecamatan').value = kecamatan;

                        // var kelurahan = data[i].kelurahan;
                        // document.getElementById('kelurahan').value = kelurahan;


                    };
                },
                error: function () {}
            })
        })
    })
    const file = document.querySelector('#foto');
    file.addEventListener('change', (e) => {
        const [file] = e.target.files;
        const {
            name: fileName,
            size
        } = file;

        const fileSize = (size / 10000).toFixed(2);
        const fileNameAndSize = `${fileName} - ${fileSize}KB`;
        document.querySelector('.file-name-foto').textContent = fileNameAndSize;
    });

    const file2 = document.querySelector('#ttd');
    file2.addEventListener('change', (e) => {
        // Get the selected file
        const [file2] = e.target.files;
        // Get the file name and size
        const {
            name: fileName2,
            size
        } = file2;
        // Convert size in bytes to kilo bytes
        const fileSize2 = (size / 10000).toFixed(2);
        // Set the text content
        const fileNameAndSize2 = `${fileName2} - ${fileSize2}KB`;
        document.querySelector('.file-name-ttd').textContent = fileNameAndSize2;
    });
</script>

@stop