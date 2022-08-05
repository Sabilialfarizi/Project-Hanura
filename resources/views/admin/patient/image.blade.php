@extends('layouts.master', ['title' =>'History Pemeriksaan'])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">History Pemeriksaan - {{ $customer->nama }}</h4>
    </div>
</div>

<div class="row">
    @foreach($customer->booking as $booking)
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                {{ $booking->no_booking }}
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($booking->images as $image)
                    <div class="col-md-6 mb-3">
                        <img src="{{ asset('/storage/' . $image->image) }}" class="rounded" alt="..." style="height: 220px; width: 220px; object-fit: cover; object-position: center;">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>


@stop

@section('footer')
<!-- <script>
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
</script> -->
@stop