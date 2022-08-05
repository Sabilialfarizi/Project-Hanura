@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
 <div class="col-sm-6 col-sg-4 m-b-4">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                Create Informasi
            </div>

            <div class="card-body">
                <form class="form-material mt-4" action="{{ route('dpp.informasi.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
                        <label for="nama">Nama <span style="color: red">*</span></label>
                        <input type="text" required id="nama" name="nama" class="form-control" value="{{ old('nama', '') }}">
                        @if($errors->has('nama'))
                        <em class="invalid-feedback">
                            {{ $errors->first('nama') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('kategori_id') ? 'has-error' : '' }}">
                        <label for="kategori_id">Kategori Informasi <span style="color: red">*</span></label>
                        <select required name="kategori_id" id="kategori_id" class="form-control select2" required
                            style="width: 100%; height:36px;">
                            <option value="">Pilih</option>
                            @foreach($category as $data => $row)
                            <option value="{{ $data }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('kategori_id'))
                        <em class="invalid-feedback">
                            {{ $errors->first('kategori_id') }}
                        </em>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('foto') ? 'has-error' : '' }}">
                        <label for="foto">Foto <span style="color: red">*</span></label>
                        <input required type="file" id="foto" name="foto" class="form-control" value="{{ old('foto', '') }}">
                        @if($errors->has('foto'))
                        <em class="invalid-feedback">
                            {{ $errors->first('foto') }}
                        </em>
                        @endif
                        <p class="helper-block">
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="Content">Content <span style="color: red">*</span></label>
                        <textarea requried rows="10"class="form-control my-editor" name="content" value="{{ old('content', '') }}"
                            id="editor"> </textarea>
                        @if($errors->has('content'))
                        <em class="invalid-feedback">
                            {{ $errors->first('content') }}
                        </em>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('dpp.informasi.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
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
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: 'textarea#editor',
    skin: 'bootstrap',
    plugins: 'lists, link, image, media',
    toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
    menubar: false,
    });
</script>
@stop
