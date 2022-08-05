<div class="form-group">
    <label for="nama">Nama Metode</label>
    <input type="text" name="nama_metode" id="nama" class="form-control" value="{{ $payment->nama_metode }}">

    @error('nama_metode')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="cabang">Cabang</label>
    <select name="cabang_id" id="cabang" class="form-control">
        <option disabled selected>-- Pilih Cabang --</option>
        @foreach($cabangs as $cabang)
        <option {{ $cabang->id == $payment->cabang_id ? 'selected' : '' }} value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
        @endforeach
    </select>

    @error('cabang_id')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="potongan">Potongan</label>
    <input type="text" name="potongan" id="potongan" class="form-control" value="{{ $payment->potongan }}">

    @error('potongan')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="rekening">Rekening</label>
    <input type="text" name="rekening" id="rekening" class="form-control" value="{{ $payment->rekening }}">

    @error('rekening')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="m-t-20 text-center">
    <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
</div>