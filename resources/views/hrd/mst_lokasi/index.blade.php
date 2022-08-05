@extends('layouts.master', ['title' => 'Lokasi'])

@section('content')
<!-- Page Heading -->
<div class="row">

    <div class="col-md-4">
        <h1 class="page-title">Lokasi</h1>
    </div>

    <div class="col-sm-8 text-right m-b-20">

        <a href="{{ route('hrd.MstLokasi.create') }}" class="btn btn btn-primary btn-rounded float-right"><i
                class="fa fa-plus"></i> Add Lokasi</a>

    </div>
</div>
<x-alert></x-alert>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table report">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($lokasi as $item)

                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->latitude }}</td>
                        <td>{{ $item->longitude }}</td>
                        {{-- <td>{{ $item->status }}</td> --}}
                        <td>

                            <a href="{{ route('hrd.MstLokasi.edit', $item->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('hrd.MstLokasi.destroy', $item->id) }}" method="post" style="display: inline;" class="delete-form">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>

                        </td>
                        
                    </tr>

                    @endforeach
                </tbody>
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
                title: 'Laporan Lokasi ',
              
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                title: 'Laporan Lokasi ',
                
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    });
</script>
@stop