@extends('layouts.master', ['title' => 'Warehouse'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Add Warehouse Barang</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('admin.warehouse.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow" id="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-sg-4 m-b-4">
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="form-group">

                                                <label for="nama_warehouse">Nama Warehouse</label>
                                                <input type="text" required="" name="nama_warehouse" id="nama_warehouse"
                                                    class="form-control">

                                                @error('nama_warehouse')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12 col-sg-4 m-b-4">
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="form-group">

                                                <label for="alamat">Alamat</label>
                                                <input type="text" required="" name="alamat" id="alamat"
                                                    class="form-control">

                                                @error('alamat')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-sm-12 col-sg-4 m-b-4">
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="form-group">
                                                <label for="perusahaan">Perusahaan</label>
                                                <select name="id_perusahaan" id="perusahaan"
                                                    class="form-control input-lg dynamic" data-dependent="nama_project">
                                                    <option disabled selected>-- Select Perusahaan --</option>
                                                    @foreach($perusahaans as $perusahaan)
                                                    <option value="{{ $perusahaan->id }}">
                                                        {{ $perusahaan->nama_perusahaan }}</option>
                                                    @endforeach
                                                </select>

                                                @error('id_perusahaan')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-sm-12 col-sg-4 m-b-4 text-center">
                                    <ul class="list-unstyled">
                                        <li>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary submit-btn"><i
                                                        class="fa fa-save"></i>
                                                    Save</button>
                                            </div>
                                        </li>
                                    </ul>
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
