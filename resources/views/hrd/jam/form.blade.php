<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="card">
            <div class="card-body">

                <div class="form-group">
                    <label for="kode">Nama</label>  
                    <input type="text" autofocus class="form-control" name="kode" id="kode"
                    value="{{ $jam->kode ?? old('kode')}}">
                </div>
                <div class="form-group">
                    <label for="waktu_mulai">Jam Masuk</label>  
                    <input type="time" autofocus class="form-control" name="waktu_mulai" id="waktu_mulai"
                    value="{{ Carbon\Carbon::parse($jam->waktu_mulai ?? old('waktu_mulai'))->format('h:i') }}">
                </div>
                <div class="form-group">
                    <label for="waktu_selesai">Jam Pulang</label>
                    <input type="time" autofocus class="form-control" name="waktu_selesai" id="waktu_selesai"
                    value="{{ Carbon\Carbon::parse($jam->waktu_selesai ?? old('waktu_selesai'))->format('h:i') }}">
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
