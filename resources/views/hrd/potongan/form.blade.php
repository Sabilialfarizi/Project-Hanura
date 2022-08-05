<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" autofocus class="form-control" name="nama" id="nama"
                            value="{{ $potongan->nama ?? old('nama') }}">
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
