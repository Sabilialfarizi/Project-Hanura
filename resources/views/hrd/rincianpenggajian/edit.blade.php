@extends('layouts.master', ['title' => 'Edit Rincian Gaji'])
@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Edit Rincian Gaji</h4>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('hrd.rincianpenggajian.update', $gajian->id) }}" method="post" id="form">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow" id="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_role">Nama Roles </label>
                                    <select name="id_role" id="roles" class="form-control">
                                        {{-- @foreach($gajian->roles as $rol)
                                            <option selected value="{{ $rol->id }}">{{ $rol->key }}</option>
                                        @endforeach --}}
                                        @foreach($roles as $role)
                                        <option {{ $gajian->id_role == $role->id ? 'selected' : '' }}
                                            value="{{ $role->id }}">
                                            {{ $role->key }}</option>
                                        @endforeach
                                    </select>

                                    @error('id_role')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="gaji">Gaji</label>
                                    <input type="text" id="gaji" required="" name="gaji"
                                        value="{{$gajian ? $gajian->gaji : ''}}" class="form-control">

                                    @error('gaji')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-1 offset-sm-0">
                                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@stop
