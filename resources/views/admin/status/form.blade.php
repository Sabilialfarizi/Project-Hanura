<div class="form-group">
    <label for="status">Status</label>
    <input type="text" name="status" id="status" class="form-control" value="{{ $status->status }}">

    @error('status')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="warna">Warna</label>
    <input type="text" name="warna" id="warna" class="form-control" value="{{ $status->warna }}">

    @error('warna')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="m-t-20 text-center">
    <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
</div>