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
                    <div class="col-4 col-sm-4 m-b-20">
                        <img src="{{ asset('/storage/' . \App\Setting::find(1)->logo) }}" class="inv-logo" alt="">
                        <table>
                            <tr>
                                <td width="150px">Invoice</td>
                                <td> : </td>
                                <td><b>{{ $purchase->invoice }}</b></td>
                            </tr>
                            <tr>
                                <td width="150px">Tanggal</td>
                                <td> : </td>
                                <td>{{ Carbon\Carbon::parse($purchase->created_at)->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td width="150px">Supplier</td>
                                <td> : </td>
                                <td>{{ $purchase->supplier->nama }}</td>
                            </tr>
                            <tr>
                                <td width="150px">Admin</td>
                                <td> : </td>
                                <td>{{ $purchase->admin->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover border" id="table-show">
                                <tr class="bg-success">
                                    <th class="text-light">NO</th>
                                    <th class="text-light">ITEM</th>
                                    <th class="text-light">QTY</th>
                                    <th class="text-light">HARGA BELI</th>
                                    <th class="text-light">TOTAL</th>
                                </tr>
                                <tbody>
                                    @php
                                    $total = 0
                                    @endphp
                                    @foreach(App\Purchase::where('invoice', $purchase->invoice)->get() as $barang)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $barang->barang->nama_barang }}</td>
                                        <td>{{ $barang->qty }}</td>
                                        <td>@currency($barang->harga_beli)</td>
                                        <td>@currency($barang->total)</td>
                                    </tr>
                                    @php
                                    $total += $barang->total
                                    @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Total Pembelian : </td>
                                        <td><b>@currency($total)</b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop