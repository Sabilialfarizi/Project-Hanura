@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-8 col-sg-8 m-b-10">
        <div class="card">
            <div class="card-header">
                <div class="card-header">

                    @php
                    $name = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                    @endphp
                    @php
                    $name_prov = \App\Provinsi::getProv($detail->provinsi_domisili);
                    @endphp
                    <a style="font-size:16px; font-weight:bold;">DPD {{ $name->name ?? '' }}</a>
                    <br>
                    <a style="font-size:16px; font-weight:bold;">Provinsi {{ $name_prov->name ?? '' }}</a>


                </div>
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h2 style="font-size:15px; font-weight:bold;">Foto Profil</h2>
                                <a href="#myModal" data-toggle="modal" data-gallery="example-gallery" class="col-sm-6"
                                    data-img-url="{{asset('/uploads/img/users/'.$detail->avatar)}}">

                                    <img src="{{asset('/uploads/img/users/' .$detail->avatar  ) }}"
                                        style="margin-left:-20px; width: 150px; height: 100px;"
                                        class="img-fluid image-control" alt="shortcut">

                                </a>
                            </div>
                            <div class="col">
                                <h2 style="font-size:15px; font-weight:bold;">Foto KTP</h2>
                                <a href="#myModal2" data-toggle="modal" data-gallery="example-gallery" class="col-sm-6"
                                    data-img-url="{{asset('/uploads/img/foto_ktp/'.$detail->foto_ktp)}}">
                                    <img src="{{asset('/uploads/img/foto_ktp/' .$detail->foto_ktp  ) }}"
                                        style=" margin-left:-10px; width: 150px; height: 100px;"
                                        class="img-fluid image-control" alt="shortcut">
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color:#D6A62C; color:#FFFF; font-weight:bold;">
                            Informasi Anggota</div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            No. KTA
                                        </th>
                                        <td>
                                            {{ $detail->no_member ?? '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Nama
                                        </th>
                                        <td>
                                            {{ $detail->nickname ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            NIK
                                        </th>
                                        <td>
                                            {{ $detail->nik }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            No. Hp
                                        </th>
                                        <td>
                                            {{ $detail->no_hp ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Email
                                        </th>
                                        <td>
                                            {{ $member->email ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Jenis Kelamin
                                        </th>
                                        @if ($detail->gender == 0)
                                        <td>
                                            Wanita
                                        </td>
                                        @elseif ($detail->gender == 1)
                                        <td>
                                            Pria
                                        </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th>
                                            Alamat
                                        </th>
                                        <td>
                                            {{ $detail->alamat ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Provinsi
                                        </th>
                                        <td>
                                            @php
                                            $name = \App\Provinsi::getProv($detail->provinsi_domisili);
                                            @endphp
                                            {{ $name->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Kabupaten/Kota
                                        </th>
                                        <td>
                                            @php
                                            $name = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                                            @endphp
                                            {{ $name->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Kecamatan
                                        </th>
                                        <td>
                                            @php
                                            $name = \App\Kecamatan::getKec($detail->kecamatan_domisili);
                                            @endphp
                                            {{ $name->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Kelurahan
                                        </th>
                                        <td>
                                            @php
                                            $name = \App\Kelurahan::getKel($detail->kelurahan_domisili);
                                            @endphp
                                            {{ $name->name ?? '' }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                        Kembali
                    </a>
                </div>
                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a style="font-weight:bold; font-size:16px;">Foto Profile</a>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{asset('/uploads/img/users/'.$detail->avatar)}}"
                                    style="width: 400px; height: 264px;" class="img-fluid image-control">
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <a style="font-weight:bold; font-size:16px;">Foto KTP</a>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{asset('/uploads/img/foto_ktp/'.$detail->foto_ktp)}}"
                                    style="width: 400px; height: 264px;" class="img-fluid image-control">
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="mb-3">
                    <div class="nav nav-tabs">

                    </div>
                </nav>
                <div class="tab-content">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection