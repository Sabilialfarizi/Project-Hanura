@extends('layouts.master', ['title' => 'Show Reinburst'])
@section('content')
<div class="row">
    <div class="col-sm-5 col-4">
        <h4 class="page-title">Show Reinburst</h4>
    </div>
    <div class="col-sm-7 col-8 text-right m-b-30">
        <div class="btn-group btn-group-sm ">
            <a href="{{ route('logistik.pengajuan.pdf',$reinbursts->id) }}" class="btn btn-success btn-sm">Export to PDF</a>
        </div>
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
                                <h6><span style="font-size: 15px; color:white; background-color:blue;">{{$reinbursts->nomor_reinburst}}</span>
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h2><span style="color:blue; text-decoration: underline; font-size: 20px">Pengajuan Reimburse</span></h2>
                            </div>
                        </div> <br />
                        <table class="table table-borderless">
                            <tr>
                                <td style="padding-right: 100px;">
                                    <table cellspacing="5" cellpadding="5">
        
                                        <tbody style="font-size: 14px; 	font-family: 'Rubik', sans-serif;">
        
                                            <tr>
                                                <td>Nama </td>
                                                <td>:</td>
                                                <td> {{ $reinbursts->admin->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jabatan </td>
                                                <td>:</td>
                                                <td> {{ $reinbursts->jabatan->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td>Divisi </td>
                                                <td>:</td>
                                                <td>  {{ $reinbursts->roles->name }}</td>
                                            </tr>
        
        
                                        </tbody>
                                    </table>
                                </td>
                                <td style="padding-right: 150px;">
        
                                </td>
                                <td>
                                    <table cellspacing="5" cellpadding="5">
        
                                        <tbody style="font-size: 14px; 	font-family: 'Rubik', sans-serif;">
        
                                            <tr>
                                                <td>Tanggal</td>
                                                <td>:</td>
                                                <td>{{ Carbon\Carbon::parse($reinbursts->tanggal_reinburst)->format('d/m/Y H:i:s') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Lampiran</td>
                                                <td>:</td>
                                                <td>{{ $reinbursts->file }}</td>
                                            </tr>
        
                                        </tbody>
        
                                    </table>
                                </td>
                            </tr>
                        </table>
      
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered  ">
                                        <tr class="bg-success">
                                            <th class="text-light">No.</th>
                                            <th class="text-light">Nota / BON / Kwitansi</th>
                                            <th class="text-light">Jumlah</th>
                                            <th class="text-light">Catatan</th>
                                        </tr>
                                        <tbody>

                                            @php
                                            $total = 0
                                            @endphp
                                            @foreach(App\RincianReinburst::where('nomor_reinburst', $reinburst->nomor_reinburst)->get() as $rein)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $rein->no_kwitansi }}</td>
                                                <td>@currency($rein->harga_beli)</td>
                                                <td>{{ $rein->catatan }}</td>
                                            </tr>
                                            @php
                                            $total += $rein->total
                                            @endphp
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"><strong>Total Reimburse<strong> </td>
                                                <td><b>@currency($total)</b></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1">
                                                    <p class="text-center">Diajukan Oleh,</p>
                                                </td>
                                                <td colspan="2">
                                                    <p class="text-center">DiPeriksa dan DiSetujui,</p>
                                                    <br>
                                                    <br>
                                                    <p class="text-left">Manager</p>
                                                    <p class="text-right" style="margin-top: -37px;">Keuangan</p>
                                                </td>
                                                <td colspan="1">
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