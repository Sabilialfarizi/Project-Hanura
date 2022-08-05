@extends('layouts.master', ['title' => 'Edit Gaji'])

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex flex-row justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-info">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('hrd.gaji.update',$penggajian->id) }}" method="post">
                    @csrf
                    @method('put')
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
                                            <select name="pegawai" id="pegawai" class="form-control select2-ajax">
                                                <option value="{{ $penggajian->pegawai->id }}">
                                                    {{ $penggajian->pegawai->name }} -
                                                    {{ $penggajian->pegawai->no_ktp }}
                                                </option>
                                            </select>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>:</th>
                                        <th>
                                            <input name="tanggal" type="date" class="form-control"
                                                value="{{ Carbon\Carbon::parse($penggajian->tamggal)->format('Y-m-d') }}">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Bulan dan Tahun</th>
                                        <th>:</th>
                                        <th>
                                            <input type="month"
                                                value="{{ Carbon\Carbon::parse($penggajian->bulan_tahun)->format("F/Y") }}"
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

                                            <input type="text" name="roles"
                                                value="{{ $penggajian->divisi}}" id="roles"
                                                class="form-control" readonly>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <th>:</th>
                                        <th>

                                            <input type="text" name="jabatans" value="{{ $penggajian->jabatan }}"
                                                id="jabatans" class="form-control" readonly>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Nama Perusahaan</th>
                                        <th>:</th>
                                        <th>

                                            <input type="text" name="perusahaans" id="perusahaans"
                                                value="{{ $penggajian->perusahaan}}" class="form-control" readonly>
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
                                    @foreach($penggajian->penerimaan as $terima)
                                    <tr>
                                        <th>{{ $terima->nama }}</th>
                                        <th>:</th>
                                        <th>
                                            <input type="text" onkeyup="penerimaan(this)"
                                                value="{{ number_format($terima->nominal) }}"
                                                name="penerimaan[{{ $terima->nama }}]" class="form-control penerimaan">
                                        </th>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total Penerimaan</th>
                                        <th>:</th>
                                        <th>
                                            <input type="text" name="total_penerimaan" readonly
                                                value="{{ number_format($penggajian->penerimaan->sum('nominal')) }}"
                                                id="total_penerimaan" class="form-control">
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
                                    @foreach($penggajian->potongan as $potong)
                                    <tr>
                                        <th>{{ $potong->nama }}</th>
                                        <th>:</th>
                                        <th>
                                            <input type="text" onkeyup="potongan(this)"
                                                value="{{ number_format($potong->nominal) }}"
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
                                            <input type="text" name="total_potongan" readonly
                                                value="{{ number_format($penggajian->potongan->sum('nominal')) }}"
                                                id="total_potongan" class="form-control">
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
                                        <input type="text"
                                            value="{{ number_format($penggajian->penerimaan->sum('nominal') - $penggajian->potongan->sum('nominal')) }}"
                                            readonly name="total" id="total" class="form-control">
                                    </th>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    // function rupiah(e) {
    //     $(e).val(formatter($(e).val()))
    // }

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

</script>
