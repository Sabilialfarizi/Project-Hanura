@extends('layouts.master', ['title' => 'Edit Pengajuan Dana'])
@section('content')
<div class="row">
    <div class="col-sm-5 col-4">
        <h4 class="page-title">Pengajuan Dana</h4>
    </div>
    <div class="col-sm-7 col-8 text-right m-b-30">
        {{-- <div class="btn-group btn-group-sm">
            <button class="btn btn-white">CSV</button>
            <button class="btn btn-white">PDF</button>
            <button class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
        </div> --}}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="card">
            <div class="card-body">
                <div class="row custom-invoice">
                    <div class="col-6 col-sm-6 m-b-20">
                        <div class="dashboard-logo">
                            <img src="{{url('/img/logo/yazfi.png ')}}" alt="Image" />
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 m-b-20">
                        <div class="invoice-details">
                            <h3 class="text-uppercase"></h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sg-4 m-b-4">

                        <h5>Invoice to:</h5>
                        <ul class="list-unstyled">
                            <li>
                                <h5><strong></strong></h5>
                            </li>
                            <li><span></span></li>
                        </ul>
                    </div>
                </div>

                <form action="{{ route('logistik.pengajuan.update', $pengajuan->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-sg-4 m-b-4">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <label for="nama">Nama <span style="color: red">*</span></label>
                                        <input required="" type="text" value="{{auth()->user()->name}}" readonly
                                            class="form-control">
                                        @error('nama')
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
                                        <label for="perusahaan">Perusahaan <span style="color: red">*</span></label>
                                        <select name="id_perusahaan" id="id_perusahaan" class="form-control select2">
                                            <option disabled selected>-- Select Perusahaan --</option>
                                            @foreach($perusahaans as $perusahaan)
                                            <option {{ $perusahaan->id == $pengajuan->id_perusahaan ? 'selected' : '' }} value="{{ $perusahaan->id }}">{{ $perusahaan->nama_perusahaan }}</option>
                                            @endforeach
                                            @error('perusahaan')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-sg-4 m-b-4">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <label for="kwitansi">Nomor Kwitansi <span style="color: red">*</span></label>
                                        <input required="" type="text" name="no_kwitansi" value="{{ $pengajuans->no_kwitansi }}" class="form-control">
                                        @error('kwitansi')
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
                                        <label for="tanggal">Tanggal <span style="color: red">*</span></label>
                                        <input type="datetime-local" name="tanggal_pengajuan" id="tanggal_pengajuan" value="{{Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('Y-m-d').'T'.Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('H:i:s')}}" class=" form-control">
                                        @error('tanggal')
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
                                        <label for="lampiran">Lampiran <span style="color: red">*</span></label>
                                        <input type="file" name="file[]" multiple="true" value="{{ $pengajuan->file }}" class="form-control">
                                        <label for=" lampiran">only pdf and doc</label>
                                        @error('lampiran')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <button type="button" id="add" class="btn btn-primary mb-2">Tambah Row Baru</button>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover border" id="table-show">
                                    <tr class="bg-success">
                                        <th style="width:300px;" class="text-light">Deskripsi</th>
                                        <th style="width:80px;" class="text-light">Qty</th>
                                        <th style="width:110px;" class="text-light">Unit</th>
                                        <th style="width:180px;" class="text-light">Harga Satuan</th>
                                        <th style="width:180px;" class="text-light">Total</th>
                                        <th style="width:180px;" class="text-light">Keterangan</th>
                                        <th class="text-light">#</th>
                                    </tr>
                                    <tbody id="dynamic_field">
                                        <script src="{{ asset('/') }}js/jquery-3.2.1.min.js"></script>
                                        <script src="{{ asset('/') }}js/select2.min.js"></script>

                                        @foreach($rincians as $pengs)
                                        <tr class="rowComponent">
                                            <td hidden>
                                                <input type="hidden" name="barang_id[{{ $loop->iteration }}]" class="barang_id-{{ $loop->iteration }}">
                                            </td>
                                            <td>
                                                <input type="text" value="{{ $pengs->barang_id }}" name="barang_id[{{ $loop->iteration }}]" class="form-control barang_id-{{ $loop->iteration }}" placeholder="Nama Barang">
                                            </td>
                                            <td>
                                                <input type="number" value="{{ $pengs->qty }}" name="qty[{{ $loop->iteration }}]" class="form-control qty-{{ $loop->iteration }}" placeholder="0">
                                            </td>
                                            <td>
                                                <input type="text" value="{{ $pengs->unit }}" name="unit[{{ $loop->iteration }}]" class="form-control unit-{{ $loop->iteration }}" placeholder="0">
                                            </td>
                                            <td>
                                                <input type="number" value="{{ $pengs->harga_beli }}" name="harga_beli[{{ $loop->iteration }}]" class="form-control harga_beli-{{ $loop->iteration }}" data="{{ $loop->iteration }}" onkeyup="hitung(this), HowAboutIt(this)" placeholder="0">
                                            </td>
                                            <td>
                                                <input type="number" disabled value="{{ $pengs->total }}" name="total[{{ $loop->iteration }}]" class="form-control total-{{ $loop->iteration }} total-form" placeholder="0">
                                            </td>
                                            <td>
                                                <input type="text" value="{{ $pengs->keterangan }}" name="keterangan[{{ $loop->iteration }}]" class="form-control keterangan-{{ $loop->iteration }}" data="{{ $loop->iteration }}" placeholder="Keterangan">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="remove(this)">Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <p class="text-info">*Mohon Untuk Input Dengan Benar dan Berurut : <span class="badge badge-primary" id="counter"></span></p>
                    <div class="row invoice-payment">
                        <div class="col-sm-4 offset-sm-8">
                            <h6>Total due</h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input type="text" id="sub_total" readonly class="form-control" value="{{ $pengajuans->sum('total') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Include PPN</label>
                                    <div class="input-group">
                                        <input type="type" id="PPN" onchange="HowAboutIt()" class="form-control" name="PPN" aria-label="Amount (to the nearest dollar)" value="{{ $pengajuans->PPN }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" id="tax" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Grand Total</label>
                                        <input type="text" id="grandtotal" name="grandtotal" readonly class="form-control" value="{{ $pengajuans->grandtotal }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 offset-sm-8">
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    var formatter = function(num) {
        var str = num.toString().replace("", ""),
            parts = false,
            output = [],
            i = 1,
            formatted = null;
        if (str.indexOf(".") > 0) {
            parts = str.split(".");
            str = parts[0];
        }
        str = str.split("").reverse();
        for (var j = 0, len = str.length; j < len; j++) {
            if (str[j] != ",") {
                output.push(str[j]);
                if (i % 3 == 0 && j < (len - 1)) {
                    output.push(",");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };

    // document.getElementById('submit').disabled = true

    function form_dinamic() {
        let index = $('#dynamic_field tr').length + 1
        document.getElementById('counter').innerHTML = index
        let template = `
            <tr class="rowComponent">
                <td hidden>
                        <input type="hidden" name="barang_id[${index}]" class="barang_id-${index}">
                    </td>
                    <td>
                        <input  type="text" name="barang_id[${index}]"  class="form-control barang_id-${index}" placeholder="Tulis Produk">
                    </td>
                    <td>
                        <input type="number" name="qty[${index}]"  class="form-control qty-${index}" placeholder="0">
                    </td>
                    <td>
                        <input type="text" name="unit[${index}]"  class="form-control unit-${index}" placeholder="Unit">
                        </td>
                        <td>
                                <input type="number" id="rupiah" name="harga_beli[${index}]" class="form-control harga_beli-${index} waktu" placeholder="0"  data="${index}" onkeyup="hitung(this), TotalAbout(this)">
                      </td>
                    <td>
                        <input type="number" name="total[${index}]" disabled class="form-control total-${index} total-form"  placeholder="0">
                    </td>
                    <td>
                        <input type="text" name="keterangan[${index}]"  class="form-control keterangan-${index}" placeholder="Keterangan">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="remove(this)">Delete</button>
                    </td>
                </tr>
        `
        $('#dynamic_field').append(template)

        $(`.select-${index}`).select2({
            placeholder: 'Select Product',
            ajax: {
                url: `/admin/where/product`,
                processResults: function(data) {
                    console.log(data)
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


    }

    function remove(q) {
        $(q).parent().parent().remove()
    }
    $('.remove').on('click', function() {
        $(this).parent().parent().remove()
    })

    function hitung(e) {
        let harga = e.value
        let attr = $(e).attr('data')
        let qty = $(`.qty-${attr}`).val()
        let total = parseInt(harga * qty)

        $(`.total-${attr}`).val(total)

    }

    function TotalAbout(e) {
        let sub_total = document.getElementById('sub_total')
        let total = 0;
        let coll = document.querySelectorAll('.total-form')
        for (let i = 0; i < coll.length; i++) {
            let ele = coll[i]
            total += parseInt(ele.value)
        }
        sub_total.value = total
        document.getElementById('grandtotal').value = total;
    }

    function HowAboutIt(e) {
        let sub_total = document.getElementById('sub_total')
        let total = 0;
        let coll = document.querySelectorAll('.total-form')
        for (let i = 0; i < coll.length; i++) {
            let ele = coll[i]
            total += parseInt(ele.value)
        }
        sub_total.value = total
        let SUB = document.getElementById('sub_total').value;
        let PPN = document.getElementById('PPN').value;
        console.log(PPN);
        let tax = PPN / 100 * sub_total.value;
        console.log(tax);
        document.getElementById('tax').value = tax;
        console.log(SUB);
        let grand_total = parseInt(SUB) + parseInt(tax);
        document.getElementById('grandtotal').value = grand_total;
        console.log(grand_total);
    }

    var rupiah = document.getElementById('rupiah');
    if (rupiah) {
        rupiah.addEventListener('keyup', function(e) {
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
    }
    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).ready(function() {
        $('#add').on('click', function() {
            form_dinamic()
        })
    })

</script>
@stop