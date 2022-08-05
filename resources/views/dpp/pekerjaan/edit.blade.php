
@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('global.create') }} {{ trans('cruds.information.title_singular') }} -->
                Update Jabatan
            </div>

            <div class="card-body">
                <form class="form-material mt-4" action="{{ route('dpp.pekerjaan.update', $pekerjaan->id) }}"
                    method="POST">
                    @csrf
                    @method('put')
                  
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Nama <span style="color: red">*</span></label>
                        <input required type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $pekerjaan->name) }}">
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
                            <option {{$pekerjaan->status == '1' ? 'selected' : ''}} value="1">Aktif</option>
                            <option {{$pekerjaan->status == '0' ? 'selected' : ''}} value="0">Non Aktif</option>
                           
                          </select>
                               @if($errors->has('status'))
                        <em class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </em>
                        @endif
                    </div>
                
                    <div class="modal-footer">
                        <a href="{{ route('dpp.pekerjaan.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
                        <button type="submit" class="btn"style="background-color:#D6A62C; color:#ffff; font-weight:bold;" >{{ __('Simpan') }}</button>
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
