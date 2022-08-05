@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/file-choose.css">

    <div class="card">
        <div class="card-header">
            <strong>Form Edit Kuota Kecamatan {{$detail->name}}</strong>
        </div>

        <div class="card-body">
            <form action="{{ "/dpc/kecamatan/$kecamatan->id" }}" method="post">
                @csrf
                @method('patch')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="id_prov" class="col-sm-2 col-form-label">Kode Kecamatan</label>
                            <div class="col-sm-10">
                                <input type="number" readonly="" class="form-control"  value="{{ $kecamatan->id_kec ?? '' }}" required>
                                @if($errors->has('id_kec'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_kec') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama Kecamatan</label>
                            <div class="col-sm-10">
                                <input type="text" readonly="" class="form-control" value="{{ $kecamatan->name ?? '' }}" required>
                                @if($errors->has('name'))
                                <strong class="text-danger">
                                    {{ $errors->first('name') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Jumlah Kuota</label>
                            <div class="col-sm-10">
                                <input type="text" name="kuota" id="kuota"  class="form-control" value="{{ $kecamatan->kuota ?? '' }}" required>
                                @if($errors->has('kuota'))
                                <strong class="text-danger">
                                    {{ $errors->first('kuota') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                       

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" style="background-color:#D6A62C; color:white;" class="btn">
                            <i class="fa fa-save"></i> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop