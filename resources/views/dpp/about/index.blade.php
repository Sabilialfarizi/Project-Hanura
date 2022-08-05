@extends('layouts.master')
@section('content')

<style>
    .click-zoom input[type=checkbox] {
        display: none
    }

    .click-zoom img {
        transition: transform 0.25s ease;
        cursor: zoom-in
    }

    .click-zoom input[type=checkbox]:checked~img {
        transform: scale(3);
        cursor: zoom-out
    }

</style>

<div class="row">
    <div class="col-md-4">
        <h4 class="page-title">About Us</h4>
    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover report" id="kabupaten" width="100%">
                        <thead>
                            <tr style="font-size:16px; text-align:center;">
                                <th>
                                    No.
                                </th>
                                <th width="50">About Us</th>
                                <th>Pic Login</th>
                                <th>Pic After Login</th>
                                <th>Pic Tentang Kami</th>
                                <th>Pic KTA Depan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($settings as $data)
                            @if ($data !== null)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td style="width: 20%; text-align:left;">{{ substr($data->about_us,0, 500) ?? ''}}</td>
                                <td>
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="{{ asset('uploads/img/pic_login/'.($data->pic_login)) }}"
                                                alt='noimage' width='150px' height='100px'>
                                        </label>
                                    </div>

                                </td>
                                <td>
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="{{ asset('uploads/img/pic_login/'.($data->pic_after_login)) }}"
                                                alt='noimage' width='150px' height='100px'>
                                        </label>
                                    </div>

                                </td>
                                <td>
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="{{ asset('uploads/img/pic_tentang_kami/'.($data->pic_tentang_kami)) }}"
                                                alt='noimage' width='150px' height='100px'>
                                        </label>
                                    </div>

                                </td>
                                <td>
                                    <div class='click-zoom'>
                                        <label>
                                            <input type='checkbox'>
                                            <img src="{{ asset('uploads/img/pic_kta/'.($data->pic_kta_depan)) }}"
                                                alt='noimage' width='150px' height='100px'>
                                        </label>
                                    </div>

                                </td>
                                <td>

                                    <a data-toggle="tooltip" data-placement="top" title="Perbaiki Tentang" style="background-color:#D6A62C; color:#FFFF;"
                                        href="{{ route('dpp.about.edit', $data->id) }}" class="btn btn-sm "><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a data-toggle="tooltip" data-placement="top" title="Cetak KTA Depan" style="background-color:#D6A62C; color:#FFFF;"
                                        href="{{ route('dpp.about.show', $data->id) }}"  class="btn btn-sm "><i class="fa-solid fa-print"></i></a>
            
                                </td>

                            </tr>
                            @else
                            <tr>
                                <td colspan="4" class="text-center">Belum Ada Data</td>
                                <td>
                                    <a style="background-color:#D6A62C; color:#FFFF;"
                                        href="{{ route('dpp.about.create') }}" class="btn btn-sm">Tambah</a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
