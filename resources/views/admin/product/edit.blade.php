@extends('layouts.master', ['title' => 'Edit Barang'])

@section('content')
<div class="row justify-content-center text-center">
    <div class="col-sm-4 col-3">
        <h4 class="page-title">Edit Produk</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-sm-6">
        <form action="{{ route('admin.product.update', $product->id) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow" id="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kode_barang">Kode Barang <span style="color: red">*</span></label>
                                <input required="" type="text" name="kode_barang"
                                    value="{{$product->kode_barang ?? ''}}" id="kode_barang" class="form-control"
                                    readonly>
                                @error('kode_barang')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" name="nama_barang" id="name" class="form-control"
                                    value="{{ $product->nama_barang ?? '' }}">

                                @error('nama_barang')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description"
                                    class="form-control">{{ $product->description ?? '' }}</textarea>

                                @error('description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis Barang <span style="color: red">*</span></label>
                                <select name="id_jenis" id="id_jenis" class="form-control select2" required="">
                                    <option disabled selected>-- Select Jenis --</option>
                                    @foreach($kategoris as $kategori)
                                    <option {{ $product->id_jenis == $kategori->id ? 'selected' : ''}}
                                        value="{{ $kategori->id }}"> {{ $kategori->nama_kategori }}</option>

                                    @endforeach
                                    @error('jenis')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="created_at">Tanggal</label>
                                <input type="datetime-local" name="created_at" id="created_at" class="form-control"
                                    value="{{Carbon\Carbon::parse($product->created_at)->format('Y-m-d').'T'.Carbon\Carbon::parse($product->created_at)->format('H:i:s')}}">

                                @error('created_at')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="m-t-20 text-center">
                                <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i>
                                    Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@stop
