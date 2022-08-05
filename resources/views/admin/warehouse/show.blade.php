@extends('layouts.master', ['title' =>'Detail Product - ' . $product->nama_barang])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Detail Product {{ $product->nama_barang }}</h4>
    </div>
</div>

<form action="{{ route('admin.product.show', $product->id) }}" method="get">
    @csrf
    <div class="row filter-row">
        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">From</label>
                <div class="cal-icon">
                    <input class="form-control floating datetimepicker" type="text" name="from" required>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="form-group form-focus">
                <label class="focus-label">To</label>
                <div class="cal-icon">
                    <input class="form-control floating datetimepicker" type="text" name="to" required>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <button type="submit" class="btn btn-success btn-block">Search</button>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered custom-table report" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Supllier</th>
                        <th>Customer</th>
                        <th>Before</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Last Stok</th>
                        <th>Waktu</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->inout as $inout)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $inout->supplier->nama ?? '-' }}</td>
                        <td>
                            @if($inout->cabang_id)
                            {{ $inout->cabang->nama ?? '-' }}
                            @endif
                            @if($inout->customer_id)
                            {{ $inout->customer->nama ?? '-' }}
                            @endif
                        </td>
                        <td>
                            {{ $inout->in ? $inout->last_stok - $inout->in : $inout->last_stok - $inout->out }}
                        </td>
                        <td>{{ $inout->in ?? '-' }}</td>
                        <td>{{ $inout->out ?? '-' }}</td>
                        <td>{{ $inout->last_stok ?? '-' }}</td>
                        <td>{{ Carbon\Carbon::parse($inout->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $inout->admin->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total : </td>
                        <td></td>
                        <td></td>
                        <td>{{ $product->inout->sum('last_stok') - ($product->inout->sum('out') + $product->inout->sum('in')) ?? 0 }}</td>
                        <td>{{ $product->inout->sum('in') ?? 0 }}</td>
                        <td>{{ $product->inout->sum('out') ?? 0 }}</td>
                        <td>{{ $product->inout->sum('last_stok') ?? 0 }}</td>
                        <td></td>
                        <td></td>
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
                title: 'Laporan Product {{ $product->nama_barang }} ',
                messageTop: 'Tanggal {{ request("from") ?? Carbon\Carbon::now()->format("d/m/Y H:i:s") }}  -  {{ request("to") ?? "" }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Product {{ $product->nama_barang }} ',
                messageTop: 'Tanggal {{ request("from") ?? Carbon\Carbon::now()->format("d/m/Y H:i:s") }}  -  {{ request("to") ?? "" }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });
</script>
@stop