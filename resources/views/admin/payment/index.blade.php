@extends('layouts.master', ['title' => 'Payments'])

@section('content')
<div class="row">
    <div class="col-sm-4">
        <h1 class="page-title">Payments</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">
        @can('payment-create')
        <a href="{{ route('admin.payments.create') }}" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Payment</a>
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
                        <th>Nama</th>
                        <th>Cabang</th>
                        <th>Potongan</th>
                        <th>Rekening</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payment->nama_metode }}</td>
                        <td>{{ $payment->cabang->nama }}</td>
                        <td>{{ $payment->potongan }}</td>
                        <td>{{ $payment->rekening }}</td>
                        <td>
                            @can('payment-edit')
                            <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('payment-delete')
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="post" style="display: inline;" class="delete-form">
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