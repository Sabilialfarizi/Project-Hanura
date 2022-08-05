@extends('layouts.master' )
@section('content')
<div class="row justify-content-center">
 <div class="col-sm-6 col-sg-4 m-b-4">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                Create Jabatan
            </div>
<x-alert></x-alert>
            <div class="card-body">
                <form class="form-material mt-4" action="{{ route('dpp.jabatan.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('kode') ? 'has-error' : '' }}">
                        <label for="nama">Kode <span style="color: red">*</span></label>
                        <input type="text" required id="kode" placeholder="kode" name="kode" class="form-control">
                        @if($errors->has('kode'))
                        <em class="invalid-feedback">
                            {{ $errors->first('kode') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                   
                    <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
                        <label for="nama">Nama <span style="color: red">*</span></label>
                        <input type="text" required id="nama" name="nama" placeholder="nama" class="form-control" value="{{ old('nama', '') }}">
                        @if($errors->has('nama'))
                        <em class="invalid-feedback">
                            {{ $errors->first('nama') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                   
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="nama">Status <span style="color: red">*</span></label>
                            <select required name="status" id="status" class="form-control">
                            <option value="">Pilih Status</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            
                          </select>
                               @if($errors->has('status'))
                        <em class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </em>
                        @endif
                    </div>
                        <div class="form-group {{ $errors->has('tipe_daerah') ? 'has-error' : '' }}">
                        <label for="kategori_id">Tipe Daerah <span style="color: red">*</span></label>
                        <select required name="tipe_daerah" id="tipe_daerah" class="form-control select2" required
                            style="width: 100%; height:36px;">
                            <option value="">Pilih Tipe Daerah</option>
                            @foreach($tipe as $data => $row)
                            <option value="{{ $data }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('tipe_daerah'))
                        <em class="invalid-feedback">
                            {{ $errors->first('tipe_daerah') }}
                        </em>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('urutan') ? 'has-error' : '' }}">
                        <label for="nama">Urutan <span style="color: red">*</span></label>
                        <input type="text" required id="urutan" name="urutan" class="form-control">
                        @if($errors->has('urutan'))
                        <em class="invalid-feedback">
                            {{ $errors->first('urutan') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                   
                    <div class="modal-footer">
                        <a href="{{ route('dpp.jabatan.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                        <button type="submit" class="btn" style="background-color:#D6A62C; color:#ffff; font-weight:bold;" >{{ __('Simpan') }}</button>
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
    tinymce.init({
        selector: 'textarea.my-editor',
        width: 900,
        height: 300
    });

</script>
@stop
