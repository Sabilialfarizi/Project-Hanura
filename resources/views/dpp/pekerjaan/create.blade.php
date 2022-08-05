@extends('layouts.master' )
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6 col-sg-4 m-b-4">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                Create Pekerjaan
            </div>
            <x-alert></x-alert>
            <div class="card-body">
                <form class="form-material mt-4" action="{{ route('dpp.pekerjaan.store') }}" method="POST">
                    @csrf

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Nama <span style="color: red">*</span></label>
                        <input type="text" required id="name" name="name" placeholder="name" class="form-control"
                            value="{{ old('name', '') }}">
                        @if($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>

                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="nama">Status <span style="color: red">*</span></label>
                        <select required name="status" id="status" class="form-control">
                            <option value="">Pilih Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non Aktif</option>

                        </select>
                        @if($errors->has('status'))
                        <em class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </em>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <a href="{{ route('dpp.pekerjaan.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                        <button type="submit" class="btn"
                            style="background-color:#D6A62C; color:#ffff; font-weight:bold;">{{ __('Simpan') }}</button>
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