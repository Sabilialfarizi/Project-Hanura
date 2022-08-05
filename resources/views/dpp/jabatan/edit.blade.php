
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
                <form class="form-material mt-4" action="{{ route('dpp.jabatan.update', $jabatan->id) }}"
                    method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group {{ $errors->has('kode') ? 'has-error' : '' }}">
                        <label for="kode">Kode <span style="color: red">*</span></label>
                        <input required type="text" id="kode" name="kode" class="form-control"
                            value="{{ old('kode', $jabatan->kode) }}">
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
                        <input required type="text" id="nama" name="nama" class="form-control"
                            value="{{ old('nama', $jabatan->nama) }}">
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
                            <option {{$jabatan->status == 'A' ? 'selected' : ''}} value="A">A</option>
                            <option {{$jabatan->status == 'B' ? 'selected' : ''}} value="B">B</option>
                           
                          </select>
                               @if($errors->has('status'))
                        <em class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </em>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('tipe_daerah') ? 'has-error' : '' }}">
                        <label for="tipe_daerah">Tipe Daerah <span style="color: red">*</span></label>
                        <select required name="tipe_daerah" id="tipe_daerah" class="form-control select2" required
                            style="width: 100%; height:36px;">
                            <option value="">Pilih Tipe Daerah</option>
                            @foreach($tipe as $data => $row)
                            <option {{$jabatan->tipe_daerah == $data ? 'selected' : ''}} value="{{ $data }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('tipe_daerah'))
                        <em class="invalid-feedback">
                            {{ $errors->first('tipe_daerah') }}
                        </em>
                        @endif
                    </div>
                     <div class="form-group {{ $errors->has('urutan') ? 'has-error' : '' }}">
                        <label for="urutan">Urutan <span style="color: red">*</span></label>
                        <input required type="text" id="urutan" name="urutan" class="form-control"
                            value="{{ old('urutan', $jabatan->urutan) }}">
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
