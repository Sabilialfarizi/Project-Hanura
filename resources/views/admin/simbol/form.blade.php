<div class="form-group">
    <label for="nama_simbol">Nama Simbol</label>
    <input type="text" name="nama_simbol" id="nama_simbol" class="form-control" value="{{ $simbol->nama_simbol }}">

    @error('nama_simbol')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="singkatan">Singkatan</label>
    <input type="text" name="singkatan" id="singakatan" class="form-control" value="{{ $simbol->singkatan }}">

    @error('singkatan')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="warna">Warna</label>
    <input type="text" name="warna" id="warna" class="form-control" value="{{ $simbol->warna }}">

    @error('warna')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="m-t-20 text-center">
    <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
</div>