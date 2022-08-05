@extends('layouts.master', ['title' => 'Purchase'])

@section('content')
<div class="row">
    <div class="col-md-4">
        <h1 class="page-title">Purchase</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">

        <a href="{{ route('admin.purchase.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Purchase</a>

    </div>
</div>

<x-alert></x-alert>

<form action="{{ route('admin.purchase.index') }}" method="get">
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
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table report">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Invoice</th>
                        <th>Supplier</th>
                        <th>Tanggal</th>
                        <th>Total Item</th>
                        <th>Total Pembelian</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('admin.purchase.show', $purchase->id) }}">{{ $purchase->invoice }}</a>
                        </td>
                        <td>{{ $purchase->supplier->nama }}</td>
                        <td>{{ Carbon\Carbon::parse($purchase->created_at)->format("d/m/Y H:i:s") }}</td>
                        <td>{{ \App\Purchase::where('invoice', $purchase->invoice)->count() }}</td>
                        <td>@currency(\App\Purchase::where('invoice', $purchase->invoice)->sum('total'))</td>
                        <td>
                            <!-- @can('purchase-edit')
                            <a href="{{ route('admin.purchase.edit', $purchase->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan -->
                            @can('purchase-delete')
                            <form action="{{ route('admin.purchase.destroy', $purchase->id) }}" method="post" style="display: inline;" class="delete-form">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td>Total : </td>
                        <td colspan="3"></td>
                        <td>{{ request('from') && request('to') ? \App\Purchase::whereBetween('created_at', [Carbon\Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d H:i:s'), Carbon\Carbon::createFromFormat('d/m/Y', request('to'))->format('Y-m-d H:i:s')])->where('invoice', $purchase->invoice)->count() : \App\Purchase::where('invoice', $purchase->invoice)->count() }}</td>
                        <td>@currency( request('from') && request('to') ? \App\Purchase::whereBetween('created_at', [Carbon\Carbon::createFromFormat('d/m/Y', request('from'))->format('Y-m-d H:i:s'), Carbon\Carbon::createFromFormat('d/m/Y', request('to'))->format('Y-m-d H:i:s')])->where('invoice', $purchase->invoice)->sum('total') : \App\Purchase::where('invoice', $purchase->invoice)->sum('total') )</td>
                        <td>&nbsp;</td>
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
                title: 'Laporan Pembelian ',
                messageTop: 'Tanggal  {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Pembelian ',
                messageTop: 'Tanggal {{ request("from") }} - {{ request("to") }}',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });
</script>
@stop