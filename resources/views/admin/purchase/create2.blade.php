@extends('layouts.master', ['title' => 'Purchase'])

@section('content')
<div class="row">
    <div class="col-sm-5 col-4">
        <h4 class="page-title">Create Purchase</h4>
    </div>
    <div class="col-sm-7 col-8 text-right m-b-30">
        <div class="btn-group btn-group-sm">
            <button class="btn btn-white">CSV</button>
            <button class="btn btn-white">PDF</button>
            <a href="" class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
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
                            <!-- <ul class="list-unstyled">
                                <li>Date booking: <span></span></li>
                                <li>No Rekam Medik: <span></span></li>
                            </ul> -->
                        </div>
                    </div>
                </div>
                <h5>Invoice to:</h5>
                <form action="{{ route('admin.purchase.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-lg-4 m-b-20">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="form-group">
                                        <label for="supplier">Supplier *</label>
                                        <select name="supplier_id" id="supplier" class="form-control select2">
                                            <option disabled selected>-- Select Supplier --</option>
                                            @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>ITEM</th>
                                    <th>QUANTITY</th>
                                    <th>HARGA BELI</th>
                                    <th>TOTAL</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="target">
                                <tr>
                                    <td>
                                        <select name="barang_id[]" id="barang" class="form-control select2">
                                            <option selected disabled>-- Select Item --</option>
                                            @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" name="qty[]" id="qty" class="form-control">
                                    </td>

                                    <td>
                                        <input type="number" name="harga_beli[]" id="harga_beli" class="form-control">
                                    </td>

                                    <td>
                                        <input type="number" name="total[]" id="total" class="form-control">
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-success btn-plus"><i class="fa fa-plus"></i></button>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td><button type="submit" class="btn btn-primary">Create</button></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js" integrity="sha512-poSrvjfoBHxVw5Q2awEsya5daC0p00C8SKN74aVJrs7XLeZAi+3+13ahRhHm8zdAFbI2+/SUIrKYLvGBJf9H3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })

    $(document).ready(function() {
        $(".btn-plus").live('click', function() {
            let index = $('#target tr').length + 1
            let form = `<tr>
                            <td>
                                <select name="barang_id[]" id="barang" class="form-control select-${index}">
                                    <option selected disabled>-- Select Item --</option>
                                    @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="number" name="qty[]" id="qty" class="form-control">
                            </td>

                            <td>
                                <input type="number" name="harga_beli[]" id="harga_beli" class="form-control">
                            </td>

                            <td>
                                <input type="number" name="total[]" id="total" class="form-control">
                            </td>

                            <td>
                                <button type="button" class="btn btn-danger btn-remove"><i class="fa fa-times"></i></button>
                            </td>
                        </tr>`
            $("#target").append(form)

            $(`.select-${index}`).select2()
        })

        $(".btn-remove").live('click', function() {
            $(this).parent().parent().remove();
        })
    })
</script>
@stop