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

                                <input type="text" required=""  id="no_member" maxlength="12" class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <th>:</th>
                            <th>

                                <input type="text" required="" id="nik" class="form-control" readonly>
                            </th>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <th>:</th>
                            <th>

                                <input type="text" required=""  id="alamat" class="form-control" readonly>
                            </th>
                        </tr>
                    </tbody>
                </table>

                <form class="form-material mt-4" action="{{ route('dpd.pembatalan.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('nickname') ? 'has-error' : '' }}">
                        <input type="hidden" id="id" name="id_anggota" required="" class="form-control">

                    </div>

                    <div class="form-group">
                        <label for="Content">Alasan Pembatalan <span style="color: red">*</span></label>
                        <textarea class="form-control my-editor" name="alasan_pembatalan" required
                            id="alasan_pembatalan"> </textarea>
                        @error('alasan_pembatalan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('dpd.pembatalan.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
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
    $(document).ready(function () {
        $(`.cari`).select2({
            placeholder: 'Select Anggota',
            ajax: {
                url: `/dpd/where/pembatalan/loaddata`,
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
                url: `/dpd/where/searchAnggota`,
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
                        
                        var avatar = data[i].avatar;
                        document.getElementById('avatar').value = avatar;


                    };
                },
                error: function () {}
            })
        })
    })
</script>
@stop