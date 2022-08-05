<table class="table" id="table">
    <tr>
        <td>
            <div class="form-group">
                <label for="supplier">Supplier</label>
                <select name="supplier_id[]" id="supplier" class="form-control">
                    <option disabled selected>-- Select Supplier --</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                    @endforeach
                </select>

                @error('supplier_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </td>
        <td>
            <div class="form-group">
                <label for="barang">Product</label>
                <select name="barang_id[]" id="barang" class="form-control">
                    <option disabled selected>-- Select Barang --</option>
                    @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                    @endforeach
                </select>

                @error('barang_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </td>
        <td>
            <div class="form-group">
                <label for="qty">Qty</label>
                <input type="number" name="qty[]" id="qty" class="form-control" value="{{ $purchase->qty ?? old('qty') }}">

                @error('qty')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </td>
        <td>
            <div class="form-group">
                <label for="harga_beli">Harga Beli</label>
                <input type="number" name="harga_beli[]" id="harga_beli" class="form-control" value="{{ $purchase->harga_beli ?? old('harga_beli') }}">

                @error('harga_beli')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </td>
        <td class="align-items-center">
            <button type="button" class="btn btn-success btn-plus" style="margin-top: 28px;"><i class="fa fa-plus"></i></button>
        </td>
    </tr>
</table>

<div class="m-t-20 text-center">
    <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
</div>