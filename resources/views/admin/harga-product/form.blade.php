<div class="form-group">
    <label for="produk">{{ request()->is('admin/price-product*') ? 'Produk' : 'Service' }}</label>
    <select name="barang_id" id="produk" class="form-control">
        <option disabled selected>-- Choose {{ request()->is('admin/price-product*') ? 'Produk' : 'Service' }} --</option>
        @foreach($products as $product)
        <option {{ $price->barang_id == $product->id ? 'selected' : '' }} value="{{ $product->id }}">{{ $product->nama_barang }}</option>
        @endforeach
    </select>

    @error('barang_id')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="harga">Harga</label>
    <input type="number" name="harga" id="harga" class="form-control" value="{{ $price->harga ?? 1 }}">

    @error('harga')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="qty">Qty</label>
    <input type="number" name="qty" id="qty" class="form-control" value="{{ $price->qty ?? 1 }}">

    @error('qty')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>