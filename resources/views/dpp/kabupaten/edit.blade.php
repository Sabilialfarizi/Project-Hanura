@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/file-choose.css">

    <div class="card">
        <div class="card-header">
            <strong>Form Edit Kabupaten/Kota</strong>
        </div>

        <div class="card-body">
            <form action="{{ "/dpp/kabupaten/$kabupaten->id" }}" method="post">
                @csrf
                @method('patch')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row mb-4">
                            <label for="id_prov" class="col-sm-2 col-form-label">Pilih Provinsi</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control"  value="{{ $provinsi->name}}" data-fixedValue="{{ $kabupaten->id_prov }}" required>
                                <input type="hidden" name="id_prov" class="form-control" id="id_prov" value="{{ $provinsi->id_prov ?? '0'}}" data-fixedValue="{{ $kabupaten->id_prov }}" >
                                @if($errors->has('id_prov'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_prov') }}
                                </strong>
                                @endif
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_kab" class="col-sm-2 col-form-label">Kode Kabupaten/Kota</label>
                            <div class="col-sm-10">
                                <input type="number" name="id_kab" class="form-control" id="id_kab" value="{{ $kabupaten->id_kab ?? '0'}}" data-fixedValue="{{ $kabupaten->id_prov }}" required>
                                @if($errors->has('id_kab'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_kab') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama Kabupaten/Kota</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" value="{{ $kabupaten->name ?? '' }}" required>
                                @if($errors->has('name'))
                                <strong class="text-danger">
                                    {{ $errors->first('name') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_wilayah" class="col-sm-2 col-form-label">Wilayah</label>
                            <div class="col-sm-10">
                                <select name="id_wilayah" id="provinsi" class="form-control select2" style="width: 100%; height:36px;" required>
                                    <option value="" selected hidden disabled>-- Pilih --</option>
                                    <option value="1" {{ $kabupaten->id_wilayah == 1 ? 'selected' : '' }}>Kabupaten</option>
                                    <option value="2" {{ $kabupaten->id_wilayah == 2 ? 'selected' : '' }}>Kota</option>
                                </select>
                                @if($errors->has('id_wilayah'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_wilayah') }}
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

@section('footer')
    <script>
    function lockValue(e)
    {

        var thisObj = e.currentTarget;
        var fixedValue = thisObj.getAttribute( "data-fixedvalue" );
        if ( thisObj.value.indexOf( fixedValue )  != 0 )
        {
            console.log(thisObj.value, fixedValue);
            e.preventDefault();
            thisObj.value = fixedValue;
        }
    }

    $("#id_prov").change(function () {
        let val = $(this).val();
        $.ajax({
            url: '/dpp/ajax/kab',
            data: {
                val: val
            },
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                var len = response.length;
                if (len > 1) {
                    const allIdKab = response.map(({ id_kab }) => id_kab);
                    const idKab = allIdKab.reduce((a, b) => Math.max(a, b)) + 1;
                    $('#id_kab').val(idKab);
                    $('#id_kab').attr('data-fixedValue', response[0].id_prov);
                }
            }
        });
    });

    $('#id_kab').keyup(lockValue);
    $('#id_kab').blur(lockValue);
    </script>
@stop