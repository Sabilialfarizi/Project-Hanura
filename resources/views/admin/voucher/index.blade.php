@extends('layouts.master', ['title' => 'Voucher'])

@section('content')
<div class="row">
    <div class="col-sm-4">
        <h1 class="page-title">Voucher</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        @can('voucher-create')
        <a href="{{ route('admin.voucher.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Voucher</a>
        @endcan
    </div>
</div>

<x-alert></x-alert>

<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Voucher</th>
                        <th>Mulai</th>
                        <th>Akhir</th>
                        <th>Min Trx</th>
                        <th>Min or Per</th>
                        <th>Nominal</th>
                        <th>Per (%)</th>
                        <th>Kuota</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($vouchers as $voucher)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $voucher->kode_voucher }}</td>
                        <td>{{ $voucher->tgl_mulai }}</td>
                        <td>{{ $voucher->tgl_akhir }}</td>
                        <td>@currency($voucher->min_transaksi)</td>
                        <td>{{ $voucher->type }}</td>
                        <td>@currency($voucher->nominal)</td>
                        <td>{{ $voucher->persentase }}%</td>
                        <td>
                            @if($voucher->is_active == 1)
                            <span class="custom-badge status-green d-flex justify-content-between">
                                Available
                                <span>{{ $voucher->kuota }}</span>
                            </span>
                            @else
                            <span class="custom-badge status-red d-flex justify-content-center text-center">
                                Used
                            </span>
                            @endif
                        </td>
                        <td>
                            @can('voucher-edit')
                            <a href="{{ route('admin.voucher.edit', $voucher->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('voucher-delete')
                            <form action="{{ route('admin.voucher.destroy', $voucher->id) }}" method="post" style="display: inline;" class="delete-form">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop