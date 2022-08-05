@extends('layouts.master', ['title' => 'Lokasi'])

@section('content')
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
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Lokasi') }}</h5>
    </div>

    <form method="POST" action="{{ route('hrd.MstLokasi.store') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class="modal-body">

            <div class="row">

                <div class="col-lg-12 order-lg-4">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="nama">Nama Kantor<span
                                            class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama"
                                        required="">

                                    @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="alamat">Alamat<span
                                            class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="alamat" class="form-control" name="alamat"
                                        placeholder="Alamat" required="">

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
                                    <label class="form-control-label" for="latitude">Latitude<span
                                            class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="latitude" class="form-control" name="latitude"
                                        placeholder="Latitude" required="">

                                    @error('latitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group focused">
                                    <label class="form-control-label" for="longitude">Longitude<span
                                            class="small text-danger">*</span>
                                    </label>
                                    <input type="text" id="longitude" class="form-control" name="longitude"
                                        placeholder="Latitude" required="">

                                    @error('longitude')
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

        </div>
        <div class="modal-footer">
            <a href="{{ route('hrd.MstLokasi.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
        </div>
    </form>
</div>
@endsection
