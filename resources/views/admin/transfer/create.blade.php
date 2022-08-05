@extends('layouts.master', ['title' => 'Create Purchase'])
@section('content')
<div class="row">
    <div class="col-sm-5 col-4">
        <h4 class="page-title">Purchase</h4>
    </div>
    <div class="col-sm-7 col-8 text-right m-b-30">
        <div class="btn-group btn-group-sm">
            <button class="btn btn-white">CSV</button>
            <button class="btn btn-white">PDF</button>
            <button class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow" id="card">
            <div class="card-body">
                <div class="row custom-invoice">
                    <div class="col-6 col-sm-6 m-b-20">
                        <img src="{{ asset('/storage/' . \App\Setting::find(1)->logo) }}" class="inv-logo" alt="">
                        <ul class="list-unstyled">
                            <li>{{ \App\Setting::find(1)->web_name }}</li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="col-6 col-sm-6 m-b-20">
                        <div class="invoice-details">
                            <h3 class="text-uppercase"></h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-lg-6 m-b-20">
                        <h5>Cabang Asal : {{ auth()->user()->cabang->nama }}</h5>
                    </div>
                </div>

                <form action="{{ route('admin.transfer.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-lg-4 m-b-20">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <label for="cabang">Cabang Tujuan *</label>
                                        <select name="cabang_id" id="cabang" class="form-control select2">
                                            <option disabled selected>-- Select Cabang Tujuan --</option>
                                            @foreach($cabangs as $cabang)
                                            <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-4 m-b-20">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <label for="invoice">No Invoice *</label>
                                        <input type="text" name="invoice" id="invoice" class="form-control">
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-4 m-b-20">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal *</label>
                                        <input type="datetime-local" name="tanggal" id="tanggal" class="form-control">
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
                                        <th class="text-light">ITEM</th>
                                        <th class="text-light">QTY</th>
                                        <th class="text-light">#</th>
                                    </tr>
                                    <tbody id="dynamic_field">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <p class="text-info">*Mohon Untuk Input Dengan Benar dan Berurut : <span class="badge badge-primary" id="counter"></span></p>
                    <div class="row invoice-payment">
                        <div class="col-sm-4 offset-sm-8">
                        </div>
                        <div class="col-sm-1 offset-sm-10">
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
                        <select required name="barang_id[${index}]" id="${index}" class="form-control select-${index}"></select>
                    </td>
                    <td>
                        <input type="text" name="qty[${index}]"  class="form-control qty-${index}" placeholder="0">
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
                url: `/admin/transfer/where/product`,
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
        let quantity = e.value
        let attr = $(e).attr('data')
        let harga = $(`.price-${attr}`)
        let durasi = $(`.duration-${attr}`)
        let total = $(`.total-${attr}`)
        let waktu = $(`.time-${attr}`)
        total.val(quantity * harga.val())
        waktu.val(quantity * durasi.val())
    }
    $(document).ready(function() {
        $('#add').on('click', function() {
            form_dinamic()
        })
    })
</script>
@stop