@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-8 col-sg-8 m-b-10">
        <div class="card">
            <div class="card-header" style="font-size:16px; font-weight:bold;">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                Form Pengesahan KTA DPD : @php
                $namo = \App\Kabupaten::getKab($pending->kabupaten_domisili);
                @endphp <span style="font-size:20px;">{{ $namo->name ?? '-' }}</span>
            </div>

            <div class="card-body">

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h2 style="font-size:15px; font-weight:bold;">Foto Profile</h2>
                            <a href="#myModal" data-toggle="modal" data-gallery="example-gallery" class="col-sm-6"
                                data-img-url="{{asset('/uploads/img/users/'.$pending->avatar)}}">

                                <img src="{{asset('/uploads/img/users/' .$pending->avatar  ) }}"
                                    style="margin-left:-20px; width: 150px; height: 100px;"
                                    class="img-fluid image-control" alt="shortcut">

                            </a>
                        </div>
                        <div class="col">
                            <h2 style="font-size:15px; font-weight:bold;">Foto KTP</h2>
                            <a href="#myModal2" data-toggle="modal" data-gallery="example-gallery" class="col-sm-6"
                                data-img-url="{{asset('/uploads/img/foto_ktp/'.$pending->foto_ktp)}}">
                                <img src="{{asset('/uploads/img/foto_ktp/' .$pending->foto_ktp  ) }}"
                                    style=" margin-left:-10px; width: 150px; height: 100px;"
                                    class="img-fluid image-control" alt="shortcut">
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#D6A62C; color:#FFFF; font-weight:bold;">
                        Informasi Anggota</div>
                    <div class="panel-body">
                        <table class="table table-borderless">
                            <tbody>

                                <tr>
                                    <th>No. KTA</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" required="" value="{{$pending->no_member ?? '-'}}"
                                            id="no_member" maxlength="12" class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" required="" value="{{$pending->nik ?? '-'}}" id="nik"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" required="" value="{{$pending->nickname ?? '-'}}"
                                            id="no_member" maxlength="12" class="form-control" readonly>

                                    </th>
                                </tr>



                                <tr>
                                    <th>Tempat Lahir</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" required="" value="{{$pending->birth_place ?? '-'}}"
                                            id="birth_place" class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" required="" id="tgl_lahir"
                                            value="{{$pending->tgl_lahir ?? '-'}}" class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <th>:</th>
                                    <th>
                                        @php
                                        $nama_gender= \App\Gender::getGender($pending->gender);
                                        @endphp
                                        <input type="text" required="" value="{{$nama_gender->name ?? '-'}}" id="gender"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Status Pekerjaan</th>
                                    <th>:</th>
                                    <th>
                                        @php
                                        $nama_job= \App\Job::getJob($pending->pekerjaan);
                                        @endphp

                                        <input type="text" required="" value="{{$nama_job->name ?? ''}}" id="pekerjaan"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Status Perkawinan</th>
                                    <th>:</th>
                                    <th>
                                        @php
                                        $nama_kawin= \App\Perkawinan::getMer($pending->status_kawin);
                                        @endphp

                                        <input type="text" required="" value="{{$nama_kawin->nama ?? '-'}}" id="nik"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" required="" id="alamat" value="{{$pending->alamat ?? '-'}}"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>RT / RW</th>
                                    <th>:</th>
                                    <th>

                                        <input type="text" required="" id="alamat" value="{{$pending->rt_rw ?? '-'}}"
                                            class="form-control" readonly>
                                    </th>
                                </tr>


                                <tr>
                                    <th>Provinsi</th>
                                    <th>:</th>
                                    <th>
                                        @php
                                        $nama_prov= \App\Provinsi::getProv($pending->provinsi_domisili);
                                        @endphp

                                        <input type="text" required="" value="{{ $nama_prov->name ?? '-' }}" id="alamat"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Kab</th>
                                    <th>:</th>
                                    <th>
                                        @php
                                        $nama_kab= \App\Kabupaten::getKab($pending->kabupaten_domisili);
                                        @endphp

                                        <input type="text" required="" value="{{ $nama_kab->name ?? '-' }}" id="alamat"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Kec</th>
                                    <th>:</th>
                                    <th>
                                        @php
                                        $nama_kec= \App\Kecamatan::getKec($pending->kecamatan_domisili);
                                        @endphp

                                        <input type="text" required="" value="{{ $nama_kec->name ?? '-' }}" id="alamat"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Kel / Desa</th>
                                    <th>:</th>
                                    <th>

                                        @php
                                        $nama_kel= \App\Kelurahan::getKel($pending->kelurahan_domisili);
                                        @endphp
                                        <input type="text" required="" value="{{$nama_kel->name ?? '-'}}" id="alamat"
                                            class="form-control" readonly>
                                    </th>
                                </tr>
                                <!--<tr>-->
                                <!--    <th>Telp / Hp</th>-->
                                <!--    <th>:</th>-->
                                <!--    <th>-->

                                <!--        <input type="text" required=""  id="no_hp" value="{{$pending->no_hp ?? '-'}}" class="form-control" readonly>-->
                                <!--    </th>-->
                                <!--</tr>-->

                                <tr>
                                    <th>Status</th>
                                    <th>:</th>
                                    <th>

                                        <select name="form_select" id="test" class="form-control"
                                            onchange="showDiv(this)">
                                            <option value="0">Pending</option>
                                            <option value="1">Aktif</option>
                                            <option value="2">Ditolak</option>
                                        </select>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



                <div id="hidden_div" style="display:none;">
                    <form class="form-material mt-4" action="{{ route('dpd.pending.update', $pending->id) }}"
                        method="POST">
                        @csrf
                        @method('put')

                        <div class="form-group {{ $errors->has('tgl_pengesahan') ? 'has-error' : '' }}">
                            <label for="tgl_pengesahan">Tanggal Pengesahan <span style="color: red">* (wajib
                                    diisi)</span></label>
                            <input type="date" id="tgl_pengesahan" name="tgl_pengesahan" class="form-control"
                                value="{{ old('tgl_pengesahan', date('Y-m-d')) }}">
                            @if($errors->has('tgl_pengesahan'))
                            <em class="invalid-feedback">
                                {{ $errors->first('tgl_pengesahan') }}
                            </em>
                            @endif
                            <p class="helper-block">

                            </p>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('dpd.pending.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                        </div>



                    </form>
                </div>
                <div id="hidden_div2" style="display:none;">
                    <form class="form-material mt-4" action="{{ route('dpd.pending.store') }}" method="POST">
                        @csrf

                        <div class="form-group {{ $errors->has('id_anggota') ? 'has-error' : '' }}">
                            <input type="hidden" id="id_anggota" value="{{$pending->id}}" name="id_anggota" required=""
                                class="form-control">

                        </div>

                        <div class="form-group">
                            <label for="Content">Alasan Penolakan <span style="color: red">* (Wajib
                                    diisi)</span></label>
                            <textarea class="form-control my-editor" rows="8" name="alasan_pembatalan" required
                                id="alasan_pembatalan"> </textarea>
                            @error('alasan_pembatalan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('dpd.pending.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a style="font-weight:bold; font-size:16px;">Foto Profile</a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('/uploads/img/users/'.$pending->avatar)}}" style="width: 400px; height: 264px;"
                    class="img-fluid image-control">
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <a style="font-weight:bold; font-size:16px;">Foto KTP</a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('/uploads/img/foto_ktp/'.$pending->foto_ktp)}}" style="width: 400px; height: 264px;"
                    class="img-fluid image-control">
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>

@stop
@section('footer')
<script type="text/javascript">
    function submit_form() {
        document.form1.submit();
        document.form2.submit();
    }

    function showDiv(select) {
        if (select.value == 1) {
            document.getElementById('hidden_div').style.display = "block";
        } else {
            document.getElementById('hidden_div').style.display = "none";
        }

        if (select.value == 2) {
            document.getElementById('hidden_div2').style.display = "block";
        } else {
            document.getElementById('hidden_div2').style.display = "none";
        }
    }
</script>
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