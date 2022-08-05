@extends('layouts.master', ['title' => 'Informasi'])
@section('content')
<div id="wrapper">
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 border-right" style="min-height: 100vh">
                        <h3 class="font-weight-bold mb-5">Informasi</h3>
                        <h4 class="font-weight-bold" style="color:#C3792B;">{{ $info->name }}</h4>
                        <div class="d-flex mb-5">
                            <span class="badge badge-pill badge-secondary mr-2">{{ $info->created_at ?? '' }}</span>
                            <span class="badge badge-pill badge-warning">by {{ $info->getUser->name ?? '' }}</span>
                        </div>
                        <img src="{{ asset('/'). 'uploads/img/Information/'. $info->gambar.'' }}" class="img-fluid mb-5 pr-5" alt="Gambar Informasi">
                        <p class="pr-5 text-justify">{{ $info->content }}</p>

                    </div>
                    <div class="col-lg-3">
                        <h4 class="font-weight-bold">Kategori</h4>
                        <span class="badge badge-pill badge-warning">{{ $info->getCategory->name }}</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
@section('footer')

     <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>


@stop