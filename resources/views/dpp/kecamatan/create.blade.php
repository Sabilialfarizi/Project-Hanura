@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/file-choose.css">

    <div class="card">
        <div class="card-header">
            <strong>Form Tambah Kecamatan</strong>
        </div>

        <div class="card-body">

            <form action="{{"/dpp/kecamatan"}}" method="post">
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row mb-4">
                            <label for="id_kab" class="col-sm-2 col-form-label">Pilih Kabupaten/Kota</label>
                            <div class="col-sm-10">
                                <select name="id_kab" id="id_kab" class="form-control select2" style="width: 100%; height:36px;">
                                    <option value="">-- Pilih --</option>
                                    @foreach($kabupaten as $data => $row)
                                    <option value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('id_kab'))
                                <strong class="text-danger">
                                    {{ $errors->first('id_kab') }}
                                </strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_kec" class="col-sm-2 col-form-label">Kode Kecamatan</label>
                            <div class="col-sm-10">
                                <input type="number" name="id_kec" class="form-control" id="id_kec" data-fixedValue="" required>
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
                                <input type="text" name="name" class="form-control" id="name" required>
                                @if($errors->has('name'))
                                <strong class="text-danger">
                                    {{ $errors->first('name') }}
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

    $("#id_kab").change(function () {
        let val = $(this).val();
        $.ajax({
            url: '/dpp/ajax/kec',
            data: {
                val: val
            },
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                var len = response.length;
                if (len > 1) {
                    const allIdKec = response.map(({ id_kec }) => id_kec);
                    const idKec = allIdKec.reduce((a, b) => Math.max(a, b)) + 1;

                    $('#id_kec').attr('data-fixedValue', response[0].id_kab);
                    $("#id_kec").val(idKec ?? response[0].id_kab);
                }
            }
        });
    });

    $('#id_kec').keyup(lockValue);
    $('#id_kec').blur(lockValue);
    </script>
@stop