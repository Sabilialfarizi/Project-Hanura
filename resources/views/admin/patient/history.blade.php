@extends('layouts.master', ['title' =>'History Pembayaran'])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">History Pembayaran {{ $customer->nama }}</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered report custom-table" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Tanggal</th>
                        <th>No App</th>
                        <th>Cabang</th>
                        <th>Metode Pembayaran</th>
                        <th>Change</th>
                        <th>Dibayar</th>
                        <th>Biaya Payment</th>
                        <th>Kasir</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                @php
                $total = 0;
                $kembali = 0;
                $dibayar = 0;
                $biaya = 0;
                $nominal = 0;
                @endphp
                <tbody>
                    @foreach($histories as $history)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ Carbon\Carbon::parse($history->payment->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $history->booking->no_booking }}</td>
                        <td>{{ $history->booking->cabang->nama }}</td>
                        <td>{{ $history->payment->nama_metode }}</td>
                        <td>@currency($history->change)</td>
                        <td>@currency($history->dibayar)</td>
                        <td>@currency($history->biaya_kartu)</td>
                        <td>{{ $history->kasir->name }}</td>
                        <td>@currency($history->nominal)</td>
                    </tr>
                    @php
                    $kembali += $history->change;
                    $dibayar += $history->dibayar;
                    $biaya += $history->biaya_kartu;
                    $nominal += $history->nominal;
                    @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>Grand Total</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>@currency($kembali)</td>
                        <td>@currency($dibayar)</td>
                        <td>@currency($biaya)</td>
                        <td></td>
                        <td>@currency($nominal)</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@stop

@section('footer')
<script>
    $('.report').DataTable({
        dom: 'Bfrtip',
        buttons: [{
                extend: 'copy',
                className: 'btn-default',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                className: 'btn-default',
                title: 'Laporan History Pembayaran Pasien',
                messageTop: '{{ $customer->nama }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan History Pembayaran Pasien',
                messageTop: '{{ $customer->nama }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });
</script>
@stop