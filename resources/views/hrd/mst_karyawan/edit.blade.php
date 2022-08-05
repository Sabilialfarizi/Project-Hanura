@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow mb-4">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Karyawan') }}</h5>
    </div>

    <form method="POST" action="{{ route('MstKaryawan.update',$karyawan->users_id) }}" autocomplete="off" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="modal-body">

            <div class="row">

                <div class="col-lg-12 order-lg-4">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="nik">Nik<span
                                            class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="nik" class="form-control" name="nik" placeholder="Nik"
                                        value="{{$karyawan->nik}}" required="" disabled
                                      >

                                    @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="nama">Nama<span
                                            class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="nama" class="form-control" name="nama" placeholder="nama"
                                        value="{{$karyawan->nama}}" required="">

                                    @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="divisi">Nomor Telpon<span
                                            class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="no_telp" class="form-control" name="no_telp"
                                        placeholder="Nomor Telpon" value="{{$karyawan->telp}}" required=""
                                        >

                                    @error('no_telp')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="jabatan_id">Jabatan<span
                                            class="small text-danger">*</span>
                                    </label>
                                    <select class="form-control border-input" name="jabatan_id">
                                        @foreach($jabatan as $itemK => $itemV)
                                        <option value="{{$itemK}}" {{old('jabatan') == $itemK ? 'selected' : ''}}>
                                            {{$itemV}}</option>
                                        @endforeach
                                    </select>

                                    @error('jabatan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email<span
                                            class="small text-danger">*</span></label>
                                    <input type="text" id="email" class="form-control" name="email" placeholder="Email" value="{{$user->email}}"
                                        required="">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        {{-- </div> --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="password">Password<span
                                            class="small text-danger"></span></label>
                                    <input type="text" id="password" class="form-control" name="password"
                                        placeholder="Password" 
                                       >

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    {{-- </div>  --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="alamat">Alamat<span
                                            class="small text-danger">*</span></label>
                                    <input type="text" id="alamat" class="form-control" name="alamat"
                                        placeholder="Alamat" value="{{$karyawan->alamat}}" required=""
                                       >

                                    @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="jk">Jenis
                                        Kelamin<span class="small text-danger">*</span>
                                    </label>
                                    <select id="jk" class="form-control" name="jk">
                                        <option value="M">Pria</option>
                                        <option value="F">Wanita</option>
                                    </select>

                                    @error('jk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="tgl_lahir">Tanggal
                                        Lahir<span class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="tgl_lahir" class="form-control datepicker" name="tgl_lahir"
                                        placeholder="Tanggal Lahir" value="{{$karyawan->tgl_lahir}}" required>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>

                                    @error('tgl_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            {{-- <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="status">Status<span
                                                        class="small text-danger">*</span>
                                            </label>
                                            <select id="status" class="form-control" name="status">
                                                <option value="ACTIVE">AKTIF</option>
                                                <option value="NOTACTIVE">NONAKTIF</option>
                                            </select>

                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div> --}}


                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="role_id">Hak Akses<span
                                    class="small text-danger">*</span>
                            </label>
                            <select name="role_id" id="roleID" class="form-control">
                                <option value="">-- Pilih hak akses --</option>
                                <option value="1">Admin</option>
                                <option value="0">non Admin</option>
                            </select>

                            @error('role_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
</div>
<div class="modal-footer">
    <a href="{{ route('MstKaryawan.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
    <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
</div>
</form>
</div>
@endsection
