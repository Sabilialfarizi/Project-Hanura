@extends('layouts.master')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/file-choose.css">

<div class="card">
    <div class="card-header">
        <strong>Form Tambah Petugas Penghubung</strong><br>
         Kecamatan DPC : @php
        $name = \App\Kecamatan::where('id_kec',$id_daerah)->first();
        @endphp  <a style="font-weight:bold;">{{ $name->name ?? '-'}}</a>
        
    </div>

    <div class="card-body">
        <form action="{{ "/dpc/kecamatan/$id_daerah/penghubungs" }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-10">
                    <!--<div class="form-group row">-->
                    <table class="table table-borderless">

                        <tbody>
                            
                             <tr>
                                <th>No. SK Penunjukkan <span style="color: red">*</span></th>
                                <th>:</th>
                                <th>
                                    <input type="text" name="no_sk" class="form-control" id="no_sk">
                                    @if($errors->has('no_sk'))
                                    <strong class="text-danger">
                                        {{ $errors->first('no_sk') }}
                                    </strong>
                                    @endif
                                </th>
                            </tr>
                            
                             <tr>
                                <th>Tgl SK Penunjukkan <span style="color: red">*</span></th>
                                <th>:</th>
                                <th>
                                    <input type="date" name="tanggal_sk" class="form-control" id="tanggal_sk">
                                    @if($errors->has('tanggal_sk'))
                                    <strong class="text-danger">
                                        {{ $errors->first('tanggal_sk') }}
                                    </strong>
                                    @endif
                                </th>
                            </tr>
                            
                             <tr>
                                <th>Attachment SK <span style="color: red">*</span></th>
                                <th>:</th>
                                <th>
                                    <input type="file" name="attachment" accept=".pdf,.doc"  class="form-control" id="attachment">
                                    @if($errors->has('attachment'))
                                    <strong class="text-danger">
                                        {{ $errors->first('attachment') }}
                                    </strong>
                                    @endif
                                </th>
                            </tr>
                            
                            
                            <tr>
                                <th>Koordinator (Masukkan Nik) <span style="color: red">*</span> </th>
                                <th>:</th>
                                <th>
                                    <select class="cari form-control input-lg dynamic" id="koordinator" name="koordinator"
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
                                <th>Nama <span style="color: red">*</span> </th>
                                <th>:</th>
                                <th>
                                    <input type="text" name="name" class="form-control" id="name">
                                    @if($errors->has('name'))
                                    <strong class="text-danger">
                                        {{ $errors->first('name') }}
                                    </strong>
                                    @endif
                                </th>
                            </tr>

                            <tr>
                                <th>Jabatan <span style="color: red">*</span> </th>
                                <th>:</th>
                                <th>
                                    <input type="text" name="jabatan" class="form-control" id="jabatan">
                                    @if($errors->has('jabatan'))
                                    <strong class="text-danger">
                                        {{ $errors->first('jabatan') }}
                                    </strong>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th>No. Telp <span style="color: red">*</span> </th>
                                <th>:</th>
                                <th>

                                    <input type="number" name="no_telp" class="form-control" id="no_telp"
                                        value="{{ $kepengurusan->kta ?? '' }}"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "13">
                                     <input type="hidden" name="roles" class="form-control" id="roles"
                                    >
                                    @if($errors->has('no_telp'))
                                    <strong class="text-danger">
                                        {{ $errors->first('no_telp') }}
                                    </strong>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th>Email <span style="color: red">*</span> </th>
                                <th>:</th>
                                <th>
                                    <input type="text" name="email" class="form-control" id="email"
                                        value="{{ $kepengurusan->nik ?? '' }}" >
                                    @if($errors->has('email'))
                                    <strong class="text-danger">
                                        {{ $errors->first('email') }}
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
                                <th>Alamat <span style="color: red">*</span> </th>
                                <th>:</th>
                                <th>

                                    <textarea type="text" name="alamat" class="form-control" id="alamat" rows="3"
                                        >{{ $kepengurusan->alamat ?? '' }}</textarea>
                                     <input type="hidden" name="provinsi_domisili" class="form-control" id="provinsi_domisili">
                                     <input type="hidden" name="kabupaten_domisili" value="{{$kecamatan->id_kab}}" class="form-control">
                                     <input type="hidden" name="kecamatan_domisili" value="{{$kecamatan->id_kec}}"class="form-control" >
                                    @if($errors->has('alamat'))
                                    <strong class="text-danger">
                                        {{ $errors->first('alamat') }}
                                    </strong>
                                    @endif
                                </th>
                            </tr>
                        </tbody>
                    </table>

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

        if (select.value == 3004) {
            $("input").prop('disabled', false);
        } else {
            $("input").prop('disabled', true);
        }
    }
</script>

<script>
    $(document).ready(function () {
        $(`.cari`).select2({
            placeholder: 'Cari Anggota',
            ajax: {
                url: `/dpc/wheres/kecamatan/penghubung/loaddata/{{$id_daerah}}`,
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
            console.log(id);
            $.ajax({
                url: `/dpc/wheres/kecamatan/penghubung/searchAnggota`,
                method: "get",
                data: {
                    'id': id
                },
                success: function (data) {
                    console.log(data);
                    op += '<input value="0" disabled>';
                    for (var i = 0; i < data.length; i++) {

                        var no_telp = data[i].no_hp;
                        document.getElementById('no_telp').value = no_telp;

                        var email = data[i].email;
                        document.getElementById('email').value = email;

                        var alamat = data[i].alamat;
                        document.getElementById('alamat').value = alamat;
                        
                        var roles = data[i].roles;
                        document.getElementById('roles').value = roles;

                        var name = data[i].name;
                        document.getElementById('name').value = name;

                        var provinsi = data[i].provinsi_domisili;
                        document.getElementById('provinsi_domisili').value = provinsi;
                     

                        // var kabupaten = data[i].kabupaten_domisili;
                        // document.getElementById('kabupaten_domisili').value = kabupaten;
                        
                        // var kecamatan = data[i].kecamatan_domisili;
                        // document.getElementById('kecamatan_domisili').value = kecamatan;

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