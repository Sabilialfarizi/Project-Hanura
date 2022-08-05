<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-sg-4 m-b-4">
                        <ul class="list-unstyled">
                            <li>
                                <div class="form-group">
                                    <label for="type">Nama Type</label>
                                    <input required="" type="text" name="type" value="{{$unit ? $unit->type : ''}}"
                                        class="form-control">

                                    @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-6 col-sg-4 m-b-4">
                        <ul class="list-unstyled">
                            <li>
                                <div class="form-group">
                                    <label for="blok">Blok</label>
                                    <input required="" type="text" name="blok" value="{{$unit ? $unit->blok : ''}}"
                                        class="form-control">

                                    @error('blok')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-sg-4 m-b-4">
                        <ul class="list-unstyled">
                            <li>
                                <div class="form-group">
                                    <label for="no">No</label>
                                    <input type="text" required="" name="no" value="{{$unit ? $unit->no : ''}}"
                                        class="form-control">

                                    @error('no')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-sg-4 m-b-4">
                        <ul class="list-unstyled">
                            <li>
                                <div class="form-group">
                                    <label for="lb">lb</label>
                                    <input type="number" name="lb" required="" value="{{$unit ? $unit->lb : ''}}"
                                        class="form-control">

                                    @error('lb')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-sg-4 m-b-4">
                        <ul class="list-unstyled">
                            <li>
                                <div class="form-group">
                                    <label for="lt">lt</label>
                                    <input type="number" name="lt" required="" value="{{$unit ? $unit->lt : ''}}"
                                        class="form-control">

                                    @error('lt')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-6 col-sg-4 m-b-4">
                        <ul class="list-unstyled">
                            <li>
                                <div class="form-group">
                                    <label for="nstd">Nstd</label>
                                    <input type="text" name="nstd" value="{{$unit ? $unit->nstd : ''}}"
                                        class="form-control">

                                    @error('nstd')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-sg-4 m-b-4">
                        <ul class="list-unstyled">
                            <li>
                                <div class="form-group">
                                    <label for="nama">Total</label>
                                    <input type="number" required="" name="total" value="{{$unit ? $unit->total : ''}}"
                                        class="form-control">

                                    @error('total')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-sg-4 m-b-4">
                        <ul class="list-unstyled">
                            <li>
                                <div class="form-group">
                                    <label for="jual">Harga Jual</label>
                                    <input type="text"  required="" name="jual"
                                        value="{{$unit ? $unit->harga_jual : ''}}" class="form-control">

                                    @error('jual')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="m-t-20 text-center offset-sm-12">
                        <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i>
                            Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var rupiah = document.getElementById('rupiah');
        rupiah.addEventListener('keyup', function (e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

    </script>
