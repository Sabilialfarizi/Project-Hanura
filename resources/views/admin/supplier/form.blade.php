<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                        value="{{ $supplier->nama ?? old('nama') }}">

                    @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telpon">Telpon</label>
                    <input type="number" name="telpon" id="telpon" class="form-control"
                        value="{{ $supplier->telpon ?? old('telpon') }}">

                    @error('telpon')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="form-control">{{ $supplier->alamat ?? old('alamat') }}</textarea>
                    @error('alamat')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="m-t-20 text-center">
                    <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
