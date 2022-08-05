@extends('layouts.master', ['title' => 'Informasi'])
@section('content')
<div id="wrapper">
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-list clearfix">
                                @foreach ($info as $item)
                                <div class="blog-box row">
                                    <div class="col-md-4">
                                        <div class="post-media">
                                            <a href="{{ "/dpd/informasi/$item->id" }}" title="">
                                                <img src="{{ asset('/'). 'uploads/img/Information/'. $item->gambar.'' }}" alt="gambar informasi" class="img-fluid">
                                                <div class="hovereffect"></div>
                                            </a>
                                        </div><!-- end media -->
                                    </div><!-- end col -->

                                    <div class="blog-meta big-meta col-md-8">
                                        <h4><a style="color:orange;" href="{{ "/dpd/informasi/$item->id" }}" title="">{{ $item->name }}</a></h4>
                                        <p style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{ $item->content }}</p>
                                        <small><a href="#" title="">{{ $item->created_at }}</a></small> |
                                        <small><a href="#" title="">by {{ $item->getUser->name }}</a></small>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">
                                @endforeach
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>
    </div><!-- end wrapper -->

@stop
@section('footer')

     <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>


@stop