@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                Update Form Settings
            </div>

            <div class="card-body">
                <form class="form-material mt-4" action="{{ route('dpp.settings.update', $settings->id) }}"
                    method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group {{ $errors->has('id_ketum') ? 'has-error' : '' }}">
                        <label for="id_ketum">Nama Ketua Umum<span style="color: red">*</span></label>
                        <select required name="id_ketum" id="id_ketum" class="form-control select2" required
                            style="width: 100%; height:36px;">
                            <option value="">Pilih</option>
                            @foreach($anggota as $data => $row)
                            <option {{$settings->id_ketum == $data ? 'selected' : ''}} value="{{ $data }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('id_ketum'))
                        <em class="invalid-feedback">
                            {{ $errors->first('id_ketum') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('id_sekjen') ? 'has-error' : '' }}">
                        <label for="id_sekjen">Nama Sekretaris Jenderal<span style="color: red">*</span></label>
                        <select required name="id_sekjen" id="id_sekjen" class="form-control select2" required
                            style="width: 100%; height:36px;">
                            <option value="">Pilih</option>
                            @foreach($anggota as $data => $row)
                            <option {{$settings->id_sekjen == $data ? 'selected' : ''}} 
                            value="{{ $data }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('id_sekjen'))
                        <em class="invalid-feedback">
                            {{ $errors->first('id_sekjen') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('id_bendum') ? 'has-error' : '' }}">
                        <label for="nama">Nama Bendahara Umum<span style="color: red">*</span></label>
                        <select required name="id_bendum" id="id_bendum" class="form-control select2" required
                            style="width: 100%; height:36px;">
                            <option value="">Pilih</option>
                            @foreach($anggota as $data => $row)
                            <option {{$settings->id_bendum == $data ? 'selected' : ''}} value="{{ $data }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('id_bendum'))
                        <em class="invalid-feedback">
                            {{ $errors->first('id_bendum') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('telp') ? 'has-error' : '' }}">
                        <label for="telp">Nomor Telepon<span style="color: red">*</span></label>
                        <input required type="text" id="telp" name="telp" maxlength="12"  class="form-control"
                            value="{{ old('telp', $settings->telp) }}">
                        @if($errors->has('telp'))
                        <em class="invalid-feedback">
                            {{ $errors->first('telp') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                    <div class="form-group">
                        <label for="Content">Alamat <span style="color: red">*</span></label>
                        <textarea requried rows="10" class="form-control my-editor" name="alamat"
                           id="alamat">{{ old('alamat', $settings->alamat) }} </textarea>
                        @if($errors->has('alamat'))
                        <em class="invalid-feedback">
                            {{ $errors->first('alamat') }}
                        </em>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="Content">About Us <span style="color: red">*</span></label>
                        <textarea requried rows="10" class="form-control my-editor" name="about_as"
                           id="about_as">{{ old('about_as', $settings->about_as) }} </textarea>
                        @if($errors->has('about_as'))
                        <em class="invalid-feedback">
                            {{ $errors->first('about_as') }}
                        </em>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('dpp.settings.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
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
