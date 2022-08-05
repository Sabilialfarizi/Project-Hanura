<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="kode_barang">Kode Barang <span style="color: red">*</span></label>
                    <input required="" type="text" name="kode_barang" value="{{$nourut }}" id="kode_barang"
                        class="form-control" readonly>
                    {{-- <input type="text" name="kode_barang" id="name" class="form-control" value="{{ $product->kode_barang ?? '' }}">
                    --}}

                    @error('kode_barang')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" required="" name="nama_barang" id="nama_barang" class="form-control"
                        value="{{ $product->nama_barang ?? '' }}">

                    @error('nama_barang')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" required="" id="description" class="form-control"></textarea>

                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jenis_barang">Jenis Barang <span style="color: red">*</span></label>
                    <select required="" name="id_jenis" id="id_jenis" class="form-control">
                        <option disabled selected>-- Select Jenis --</option>
                        @foreach($kategoris as $kategori)
                        <option {{ $product->jenis == $kategori->id ? 'selected' : ''}} value="{{ $kategori->id }}">
                            {{ $kategori->nama_kategori }}</option>

                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="created_at">Tanggal</label>
                    <input type="datetime-local" name="created_at" id="created_at" class="form-control">

                    @error('created_at')
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
