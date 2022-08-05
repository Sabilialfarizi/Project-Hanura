@extends('layouts.master', ['title' => 'Create Pengajian'])

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        </div>
        @endif
        <div class="card">
            <div class="card-header d-flex flex-row justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-info">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('hrd.gaji.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th colspan="3">Penggajian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Pegawai</th>
                                        <th>:</th>
                                        <th>
                                            {{-- <select name="pegawai" id="pegawai"
                                                class="form-control select2-ajax"></select> --}}

                                          
                                            <select required="" name="pegawai_id" id="id"
                                                class="form-control input-lg dynamic" data-dependent="id_jabatans"
                                                required="">
                                                <option disabled selected>-- Select Pegawai --</option>
                                                @foreach($pegawais as $pegawai)
                                                <option value="{{ $pegawai->id }}">{{ $pegawai->name }}
                                                </option>
                                                @endforeach
                                                @error('perusahaan')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </select>


                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>:</th>
                                        <th>
                                            <input name="tanggal" type="date" required="" class="form-control"
                                                value="{{ Carbon\Carbon::parse()->format('Y-m-d') }}">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Bulan Tahun</th>
                                        <th>:</th>
                                        <th>
                                            <input type="month" required="" value="{{ Carbon\Carbon::parse()->format('Y-m') }}"
                                                name="bulan_tahun" class="form-control">
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Pegawai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Divisi</th>
                                        <th>:</th>
                                        <th>

                                            <input type="text" required="" name="roles" id="roles" class="form-control" readonly>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <th>:</th>
                                        <th>

                                            <input type="text" required="" name="jabatans" id="jabatans" class="form-control"
                                                readonly>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Nama Perusahaan</th>
                                        <th>:</th>
                                        <th>

                                            <input type="text" required="" name="perusahaans" id="perusahaans" class="form-control"
                                                readonly>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th colspan="3">Penerimaan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($penerimaan as $terima)
                                    <tr>
                                        <th>{{ $terima->nama }}</th>
                                        <th>:</th>
                                        <th>
                                            <input type="text" onkeyup="penerimaan(this)" value="{{ number_format(0)}}"
                                                name="penerimaan[{{ $terima->nama }}]" id="gajian"
                                                class="form-control penerimaan">
                                        </th>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total Penerimaan</th>
                                        <th>:</th>
                                        <th>
                                            <input type="text" name="total_penerimaan" value="0" id="total_penerimaan"
                                                class="form-control">
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th colspan="3">Potongan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($potongan as $potong)
                                    <tr>
                                        <th>{{ $potong->nama }}</th>
                                        <th>:</th>
                                        <th>
                                            <input type="text" onkeyup="potongan(this)" value="0"
                                                name="potongan[{{ $potong->nama }}]" class="form-control potongan">
                                        </th>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total Potongan</th>
                                        <th>:</th>
                                        <th>
                                            <input type="text" name="total_potongan" value="0" id="total_potongan"
                                                class="form-control">
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th colspan="3">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <th>Total</th>
                                    <th>:</th>
                                    <th>
                                        <input type="text" name="total" id="total" class="form-control">
                                    </th>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

</html>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(document).ready(function () {
        $('.dynamic').change(function () {
            var id = $(this).val();
            var div = $(this).parent();
            var op = " ";

            $.ajax({
                url: `/hrd/where/searchPegawai`,
                method: "get",
                data: {
                    'id': id
                },
                success: function (data) {
                    console.log(data);
                    op += '<input value="0" disabled>';
                    for (var i = 0; i < data.length; i++) {
                        var jabatan = data[i].id_jabatans;
                        document.getElementById('jabatans').value = jabatan;

                        var role = data[i].id_roles;
                        document.getElementById('roles').value = role;

                        var perusahaan = data[i].id_perusahaan;
                        document.getElementById('perusahaans').value = perusahaan;

                        let coll = $('.penerimaan')
                        var gaji = data[i].gaji;
                        document.getElementById('gajian').value = gaji;


                    };
                },
                error: function () {}
            })
        })
    })

    function WeCanSumSallary() {
        $('#total').val(parseFloat($('#total_penerimaan').val().replace(/,/g, '')) - parseFloat($(
            '#total_potongan').val().replace(/,/g, '')))
    }

    function potongan(e) {
        let total = 0;
        let coll = $('.potongan')
        for (let i = 0; i < $(coll).length; i++) {
            let ele = $(coll)[i]
            console.log($(ele).val())
            total += parseFloat($(ele).val().replace(/,/g, ''))
        }
        $('#total_potongan').val(total)
        WeCanSumSallary()
    }

    function penerimaan(e) {
        let total = 0;
        let coll = $('.penerimaan')
        for (let i = 0; i < $(coll).length; i++) {
            let ele = $(coll)[i]
            console.log($(ele).val())
            total += parseFloat($(ele).val().replace(/,/g, ''))
        }
        $('#total_penerimaan').val(total)
        WeCanSumSallary()
    }



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
