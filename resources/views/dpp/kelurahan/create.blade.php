@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/file-choose.css">

    <div class="card">
        <div class="card-header">
            <strong>Form Tambah Kelurahan / Desa</strong>
        </div>

        <div class="card-body">
            <form action="{{ "/dpp/kecamatan/$kecamatan->id_kec/kelurahan" }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="id_kec" class="col-sm-2 col-form-label">Kode Kecamatan</label>
                            <div class="col-sm-10">
                                <input type="number" name="id_kec" class="form-control" id="id_kec" value={{ $kecamatan->id_kec }}  readonly>
                                @if($errors->has('id_kec'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_kec') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_kel" class="col-sm-2 col-form-label">Kode Kelurahan / Desa</label>
                            <div class="col-sm-10">
                                <input type="number" name="id_kel" class="form-control" id="id_kel" value={{ $id_kel }} value="{{ $id_kel }}"  data-fixedValue="{{ $kecamatan->id_kec }}">
                                @if($errors->has('id_kel'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_kel') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama Kelurahan / Desa</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" >
                                @if($errors->has('name'))
                                <strong class="text-danger">
                                    {{ $errors->first('name') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_kpu" class="col-sm-2 col-form-label">Kode KPU</label>
                            <div class="col-sm-10">
                                <input type="number" name="id_kpu" class="form-control" placeholder="Kode KPU" id="id_kpu" required>
                                @if($errors->has('id_kpu'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_kpu') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_wilayah" class="col-sm-2 col-form-label">Wilayah</label>
                            <div class="col-sm-10">
                                <select name="id_wilayah" id="provinsi" class="form-control select2" style="width: 100%; height:36px;" >
                                    
                                    <option value="3">Desa</option>
                                    <option value="4">Kelurahan</option>
                                </select>
                                @if($errors->has('id_wilayah'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_wilayah') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" style="background-color:#D6A62C; color:#FFFF;" class="btn">
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
    function lockValue(e){
        var thisObj = e.currentTarget;
        var fixedValue = thisObj.getAttribute( "data-fixedvalue" );
        if ( thisObj.value.indexOf( fixedValue )  != 0 )
        {
            console.log(thisObj.value, fixedValue);
            e.preventDefault();
            thisObj.value = fixedValue;
        }
    } 

    $('#id_kel').keyup(lockValue);
    $('#id_kel').blur(lockValue);
    </script>
@stop