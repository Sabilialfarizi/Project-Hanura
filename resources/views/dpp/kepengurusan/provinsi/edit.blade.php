@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/file-choose.css">

    <div class="card">
        <div class="card-header">
            <strong>Form Kepengurusan DPD Provinsi{{ $provinsi->name }}</strong>
        </div>

        <div class="card-body">
            <form action="{{ "/dpp/provinsi/$provinsi->id_prov/kepengurusan/$kepengurusan->id_kepengurusan" }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" value="{{ $kepengurusan->nama ?? '' }}" name="nama" class="form-control" id="nama" required>
                                @if($errors->has('nama'))
                                <strong class="text-danger">
                                    {{ $errors->first('nama') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                            <div class="col-sm-9">
                                <select name="jabatan"     onchange="showDiv(this)" id="jabatan" class="form-control select2" style="width: 100%; height:36px;">
                                    <option value="" selected disabled hidden>-- Pilih --</option>
                                    @foreach($jabatan as $data)
                                    <option value="{{ $data->kode }}" {{ $kepengurusan->jabatan == $data->kode ? 'selected' : '' }}>{{ $data->nama }}  ({{$data->kode}})</option>
                                    @endforeach
                                </select>
                                @if($errors->has('jabatan'))
                                <strong class="text-danger">
                                    {{ $errors->first('jabatan') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                    <!--    <div id="hidden_div">-->
                    <!--    <div class="form-group row">-->
                    <!--        @if($kepengurusan->other_jabatan != null)-->
                    <!--        <label for="kta" class="col-sm-3 col-form-label">Isi Nama Jabatan (Pilih Lainnya)</label>-->
                    <!--        <div class="col-sm-9">-->
                    <!--            <input  type="text" name="other_jabatan" class="form-control"-->
                    <!--                placeholder="Isi Nama Jabatan (Opsional)" id="other_jabatan"-->
                    <!--                value="{{ $kepengurusan->other_jabatan ?? '' }}">-->
                    <!--            <label style="font-size:12px; " for="other_jabatan"> <i-->
                    <!--                    class="fa-solid fa-triangle-exclamation"></i> Opsional Jika Tidak Ada Jabatan-->
                    <!--                Yang Dipilih</label>-->
                    <!--            @if($errors->has('other_jabatan'))-->
                    <!--            <strong class="text-danger">-->
                    <!--                {{ $errors->first('other_jabatan') }}-->
                    <!--            </strong>-->
                    <!--            @endif-->

                    <!--        </div>-->
                    <!--        @else-->
                    <!--        <label for="kta" class="col-sm-3 col-form-label">Other Jabatan (Pilih Lainnya)</label>-->
                    <!--        <div class="col-sm-9">-->
                    <!--            <input disabled type="text" name="other_jabatan" class="form-control"-->
                    <!--                placeholder="Other Jabatan (Opsional)" id="other_jabatan"-->
                    <!--                value="{{ $kepengurusan->other_jabatan ?? '' }}">-->
                    <!--            <label style="font-size:12px; " for="other_jabatan"> <i-->
                    <!--                    class="fa-solid fa-triangle-exclamation"></i> Opsional Jika Tidak Ada Jabatan-->
                    <!--                Yang Dipilih</label>-->
                    <!--            @if($errors->has('other_jabatan'))-->
                    <!--            <strong class="text-danger">-->
                    <!--                {{ $errors->first('other_jabatan') }}-->
                    <!--            </strong>-->
                    <!--            @endif-->

                    <!--        </div>-->
                    <!--        @endif-->
                    <!--    </div>-->
                    <!--</div>-->

                      <div class="form-group row">
                            <label for="kta" class="col-sm-3 col-form-label">No. KTA</label>
                            <div class="col-sm-9">
                                <input type="text" onkeypress="return isNumberKey(event)"  name="kta" class="form-control" id="kta" value="{{ $kepengurusan->kta ?? '' }}" required>
                                @if($errors->has('kta'))
                                <strong class="text-danger">
                                    {{ $errors->first('kta') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                            <div class="col-sm-9">
                                <input type="number" name="nik" class="form-control" id="nik" value="{{ $kepengurusan->nik ?? '' }}" required>
                                @if($errors->has('nik'))
                                <strong class="text-danger">
                                    {{ $errors->first('nik') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_sk" class="col-sm-3 col-form-label">Nomor SK</label>
                            <div class="col-sm-9">
                                <input type="text" name="no_sk" class="form-control" id="no_sk" value="{{ $kepengurusan->no_sk ?? '' }}" required>
                                @if($errors->has('no_sk'))
                                <strong class="text-danger">
                                    {{ $errors->first('no_sk') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alamat_kantor" class="col-sm-3 col-form-label">Alamat Kantor</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="alamat_kantor" class="form-control" id="alamat_kantor" rows="3" required>{{ $kepengurusan->alamat_kantor ?? '' }}</textarea>
                                @if($errors->has('alamat_kantor'))
                                <strong class="text-danger">
                                    {{ $errors->first('alamat_kantor') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12 d-flex justify-content-center mb-lg-0 mb-3">
                        <div class="file-input text-center">
                            <input type="hidden" name="foto_lama" value="{{ $kepengurusan->foto ?? '' }}">
                            <input type="file" id="foto" name="foto" class="file">
                            <label for="foto">
                                Upload Foto
                                <p class="file-name file-name-foto"></p>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12 d-flex justify-content-center">
                        <div class="file-input text-center">
                            <input type="hidden" name="ttd_lama" value="{{ $kepengurusan->ttd ?? '' }}">
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
          var name = $("#other_jabatan").val();

        if (select.value == 2004) {
            $("#other_jabatan").prop('disabled', false);
        } else {
            $("#other_jabatan").prop('disabled', true);
           
             var name = $("#other_jabatan").val('');
             console.log(name)//return true
        }
    }
</script>
<script>
   function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
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