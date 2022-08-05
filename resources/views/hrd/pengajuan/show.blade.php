@extends('layouts.master', ['title' => 'Show Pengajuan Dana'])
@section('content')
<div class="row">
    <div class="col-sm-5 col-4">
        <h4 class="page-title">Show Pengajuan Dana</h4>
    </div>
</div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-3 body-main">
            <div class="col-md-12">
                <div class="card shadow" id="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-logo">
                                    <img src="{{url('/img/logo/yazfi.png ')}}" alt="Image" />
                                </div>
                            </div>
                            <div class="col-md-8 text-right">
                                <h6><span style="font-size: 15px; color:white; background-color:blue;">{{$pengajuan->nomor_pengajuan}}</span>
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h2><span style="color:blue; text-decoration: underline; font-size: 20px">Pengajuan Dana</span></h2>
                            </div>
                        </div> <br />
                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered  ">
                                        <tr class="bg-success">
                                            <th class="text-light">No.</th>
                                            <th class="text-light">Keterangan</th>
                                            <th style="width:15%;" class="text-light">Harga Satuan</th>
                                            <th class="text-light">Kwitansi</th>
                                            <th style="width:5%;" class="text-light">Qty</th>
                                            <th style="width:5%;" class="text-light">Unit</th>
                                            <th style="width:20%;" class="text-light">Deskripsi</th>
                                            <th style="width:20%;" class="text-light">Jumlah</th>
                                        </tr>
                                        <tbody>

                                            @php
                                            $total = 0
                                            @endphp
                                            @foreach(App\RincianPengajuan::where('nomor_pengajuan', $pengajuan->nomor_pengajuan)->get() as $barang)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $barang->barang_id }}</td>
                                                <td>@currency($barang->harga_beli)</td>
                                                <td>{{$barang->no_kwitansi}}</td>
                                                <td>{{$barang->qty}}</td>
                                                <td>{{$barang->unit}}</td>
                                                <td>{{ $barang->keterangan }}</td>
                                                <td>@currency($barang->total)</td>
                                            </tr>

                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7"><strong>Total<strong> </td>
                                                <td colspan="2"><b>@currency($barang->grandtotal)</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" rowspan="1">Cat :</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p class="text-center">Diajukan Oleh,</p>
                                                </td>
                                                <td colspan="2">
                                                    <p class="text-center">DiPeriksa,</p>
                                                    <br>
                                                    <br>
                                                    <p class="text-left">Manager</p>
                                                    <p class="text-right" style="margin-top: -37px;">Keuangan</p>
                                                </td>
                                                <td colspan="2">
                                                    <p class="text-center">DiSetujui,</p>
                                                    <br>
                                                    <br>
                                                    <p class="text-center">Direktur</p>
                                                </td>
                                                <td colspan="2">
                                                    <p class="text-center">DiKetahui,</p>
                                                    <br>
                                                    <br>
                                                    <p class="text-center">Komisaris</p>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                            <td colspan="6" rowspan="2">Cat :</td>
                                        </tr> -->

                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop