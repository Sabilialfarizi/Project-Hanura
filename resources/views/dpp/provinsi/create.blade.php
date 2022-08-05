@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/file-choose.css">

    <div class="card">
        <div class="card-header">
            <strong>Form Tambah Provinsi</strong>
        </div>

        <div class="card-body">
            <form action="{{ "/dpp/provinsi" }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="id_prov" class="col-sm-2 col-form-label">Kode Provinsi</label>
                            <div class="col-sm-10">
                                <input type="number" name="id_prov" class="form-control" id="id_prov" required>
                                @if($errors->has('id_prov'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_prov') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama Provinsi</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" required>
                                @if($errors->has('name'))
                                <strong class="text-danger">
                                    {{ $errors->first('name') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zona_waktu" class="col-sm-2 col-form-label">Zona Waktu</label>
                            <div class="col-sm-10">
                                <select name="zona_waktu" id="provinsi" class="form-control select2" style="width: 100%; height:36px;" required>
                                    <option value="" selected hidden disabled>-- Pilih --</option>
                                    <option value="01">WIB</option>
                                    <option value="02">WITA</option>
                                    <option value="03">WIT</option>
                                </select>
                                @if($errors->has('zona_waktu'))
                                <strong class="text-danger">
                                    {{ $errors->first('zona_waktu') }}
                                </strong>
                                @endif
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