@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                Update Informasi
            </div>

            <div class="card-body">
                <form class="form-material mt-4" action="{{ route('dpp.about.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="about_us">About Us <span style="color: red">*</span></label>
                        <textarea requried rows="10" class="form-control my-editor" name="about_us"
                           id="about_us">{{ old('about_us', $settings->about_us) }} </textarea>
                        @if($errors->has('about_us'))
                        <em class="invalid-feedback">
                            {{ $errors->first('about_us') }}
                        </em>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('pic_login') ? 'has-error' : '' }}">
                        <label for="pic_login">Foto Login<span style="color: red">*</span></label>
                        <input required type="file" id="pic_login" name="pic_login" class="form-control" >
                        @if($errors->has('pic_login'))
                        <em class="invalid-feedback">
                            {{ $errors->first('pic_login') }}
                        </em>
                        @endif
                        <p class="helper-block">
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('pic_after_login') ? 'has-error' : '' }}">
                        <label for="pic_after_login">Foto After Login<span style="color: red">*</span></label>
                        <input required type="file" id="pic_after_login" name="pic_after_login" class="form-control">
                        @if($errors->has('pic_after_login'))
                        <em class="invalid-feedback">
                            {{ $errors->first('pic_after_login') }}
                        </em>
                        @endif
                        <p class="helper-block">
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('pic_tentang_kami') ? 'has-error' : '' }}">
                        <label for="pic_tentang_kami">Foto Tentang Kami<span style="color: red">*</span></label>
                        <input required type="file" id="pic_tentang_kami" name="pic_tentang_kami" class="form-control" >
                        @if($errors->has('pic_tentang_kami'))
                        <em class="invalid-feedback">
                            {{ $errors->first('pic_tentang_kami') }}
                        </em>
                        @endif
                        <p class="helper-block">
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('pic_kta_depan') ? 'has-error' : '' }}">
                        <label for="pic_kta_depan">Foto KTA Depan<span style="color: red">*</span></label>
                        <input required type="file" id="pic_kta_depan" name="pic_kta_depan" class="form-control" >
                        @if($errors->has('pic_kta_depan'))
                        <em class="invalid-feedback">
                            {{ $errors->first('pic_kta_depan') }}
                        </em>
                        @endif
                        <p class="helper-block">
                        </p>
                    </div>
                   
                    <div class="modal-footer">
                        <a href="{{ route('dpp.about.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                        <button type="submit" class="btn" style="background-color:#D6A62C; color:#ffff; font-weight:bold;">{{ __('Simpan') }}</button>
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
@endsection
@section('footer')

<script>
    tinymce.init({
        selector: 'textarea.my-editor',
        width: 900,
        height: 300
    });

</script>
@endsection


