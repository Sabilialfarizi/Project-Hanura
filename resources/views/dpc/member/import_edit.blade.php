@extends('layouts.master', ['title' => 'Kabupaten'])
<style>
    .custom-file-label,
    .custom-file-label::after,
    .custom-file-input,
    .custom-file {
        height: auto !important;
        padding: 6px 12px;
    }
</style>
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('dpc.import.anggota') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('dpc.import.save') }}" method="POST" class="row" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $anggota->id }}">
                <div class="col-md-3 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Nama</label>
                        <input type="text" value="{{ $anggota->nama }}" name="nama" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group mb-3">
                        <label for="">NIK</label>
                        <input type="text" value="{{ $anggota->ktp }}" name="nik" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group mb-3">
                        <label for="">No Member</label>
                        <input type="text" value="{{ $anggota->kode_anggota }}" name="no_member" class="form-control"
                            readonly>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Jenis Kelamin</label>
                        <select name="jk" class="custom-select" required style="height: 34px; padding: 6px 12px;">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Pria" @if ($anggota->jk == 'Pria') selected @endif>Pria</option>
                            <option value="Wanita" @if ($anggota->jk == 'Wanita') selected @endif>Wanita</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Provinsi</label>
                        <input type="text" value="{{ $provinsi->name }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Kabupaten</label>
                        <input type="text" value="{{ $kabupaten->name }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="custom-select"
                            style="height: 34px; padding: 6px 12px;">
                            @foreach ($kecamatan as $value)
                                <option value="{{ $value->id_kec }}" @if ($anggota->kecamatan == $value->id_kec) selected @endif>
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Kelurahan</label>
                        <select name="kelurahan" id="kelurahan" class="custom-select"
                            style="height: 34px; padding: 6px 12px;">
                            @foreach ($kelurahan as $value)
                                <option value="{{ $value->id_kel }}" @if ($anggota->kelurahan == $value->id_kel) selected @endif>
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Status Pernikahan</label>
                        <select name="pernikahan" id="" class="custom-select" required
                            style="height: 34px; padding: 6px 12px;">
                            <option value="">Pilih Status</option>
                            @foreach ($marital as $key => $value)
                                <option value="{{ $value->id }}" @if ($anggota->pernikahan == $value->id) selected @endif>
                                    {{ $value->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Pekerjaan</label>
                        <select name="pekerjaan" id="" class="custom-select" required
                            style="height: 34px; padding: 6px 12px;">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach ($job as $key => $value)
                                <option value="{{ $value->id }}" @if ($anggota->pekerjaan == $value->id) selected @endif>
                                    {{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group mb-3">
                        <label for="">Agama</label>
                        <select name="agama" id="" class="custom-select" required
                            style="height: 34px; padding: 6px 12px;">
                            <option value="">Pilih Agama</option>
                            @foreach ($agama as $key => $value)
                                <option value="{{ $value->id }}" @if ($anggota->agama == $value->id) selected @endif>
                                    {{ $value->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    @if (is_null($anggota->foto))
                        <div class="row mb-3" id="csContainer1">
                            <div class="col-4">
                                <img src="/uploads/profile_picture/p1.jpeg" alt="" class="img-thumbnail mb-3">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1"
                                        value="/uploads/profile_picture/p1.jpeg" name="kta_custom"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline1">Pilih Foto Ini</label>
                                </div>

                            </div>
                            <div class="col-4">
                                <img src="/uploads/profile_picture/p2.jpeg" alt="" class="img-thumbnail mb-3">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2"
                                        value="/uploads/profile_picture/p2.jpeg" name="kta_custom"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline2">Pilih Foto Ini</label>
                                </div>

                            </div>
                            <div class="col-4">
                                <img src="/uploads/profile_picture/p3.jpeg" alt="" class="img-thumbnail mb-3">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline3"
                                        value="/uploads/profile_picture/p3.jpeg" name="kta_custom"
                                        class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline3">Pilih Foto Ini</label>
                                </div>

                            </div>
                        </div>
                    @endif
                    <img id="csFile1" alt="" class="img-thumbnail mb-2"
                        @if (is_null($anggota->foto)) style="display: none" src="" @else src="/uploads/img/users/{{ $anggota->foto }}" @endif>
                    <div class="custom-file">
                        <input type="file" name="kta" class="custom-file-input" id="customFile1"
                            style="height:auto" accept="image/*" @if (is_null($anggota->foto)) required @endif>
                        <label class="custom-file-label" for="customFile1">Pilih Foto KTA</label>
                        <span>Silahkan Pilih foto atau upload foto untuk KTA (diwajibkan menggunakan foto asli)</span>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <img id="csFile" alt="" class="img-thumbnail mb-2"
                        @if (is_null($anggota->foto)) style="display: none" src="" @else src="/uploads/img/foto_ktp/{{ $anggota->foto_ktp }}" @endif>
                    <div class="custom-file">
                        <input type="file" name="ktp" class="custom-file-input" id="customFile"
                            style="height:auto" accept="image/*" @if (is_null($anggota->foto_ktp)) required @endif>
                        <label class="custom-file-label" for="customFile">Pilih Foto KTP</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#customFile1').change(function() {
                $('#csFile1').slideUp();
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#csFile1').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
                $('#csFile1').slideDown();
            });

            $('#customFile1').click(function() {
                $(this).val('');
            });

            $('#customFile').change(function() {
                $('#csFile').slideUp();
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#csFile').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
                $('#csFile').slideDown();
            });

            $('#customFile').click(function() {
                $(this).val('');
            });

            $('#kecamatan').on('change', function() {
                $.ajax({
                    url: '/dpc/ajax/member/kel',
                    type: 'GET',
                    data: {
                        val: $(this).val()
                    },
                    success: function(response) {
                        $('#kecamatan').prop('disabled', true);
                        $('#kelurahan').empty();
                        $.each(response, function(index, item) {
                            $('<option>').attr({
                                value: item.id_kel
                            }).html(item.name).appendTo($('#kelurahan'))
                        });
                        $('#kecamatan').prop('disabled', false);
                    }
                })
            });

            $('input[name=kta_custom]').on('change', function() {
                if ($(this).prop('checked')) {
                    $('input[name=kta]').val('');
                    $('#customFile1').attr('required', false);
                } else {
                    $('#customFile1').attr('required', true);
                }
            });
        });
    </script>
@endsection
