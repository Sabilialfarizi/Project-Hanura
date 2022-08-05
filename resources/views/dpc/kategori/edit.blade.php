@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
               Edit Kategori Informasi
            </div>

            <div class="card-body">
                <form class="form-material mt-4" action="{{ route('dpp.kategori.update',$category->id) }}"method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="nama">Nama <span style="color: red">*</span></label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $category->name) }}">
                        @if($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                        @endif
                        <p class="helper-block">

                        </p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('dpp.informasi.index') }}" class="btn btn-link">{{ __('Kembali') }}</a>
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
