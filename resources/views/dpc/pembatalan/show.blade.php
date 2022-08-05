@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-10 col-sg-10 m-b-10">
        <div class="card">
            <div class="card-header">
                <div class="card-header">

                    @php
                    $name = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                    @endphp
                    @php
                    $name_prov = \App\Provinsi::getProv($detail->provinsi_domisili);
                    @endphp
                    <a style="font-size:16px; font-weight:bold;">DPC {{ $name->name ?? '' }}</a>
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
                      <div class="panel-heading" style="background-color:#D6A62C; color:#FFFF; font-weight:bold;">Informasi Anggota</div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            No. KTA
                                        </th>
                                        <td>
                                             <input type="text" required="" value="{{$detail->no_member ?? '-'}}" 
                                            class="form-control" readonly>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Nama
                                        </th>
                                        <td>
                                             <input type="text" required="" value="{{$detail->nickname ?? '-'}}" 
                                            class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Jabatan
                                        </th>
                                        <td>
                                             <input type="text" required="" value="{{$detail->key ?? '-'}}" 
                                            class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            NIK
                                        </th>
                                        <td>
                                             <input type="text" required="" value="{{$detail->nik ?? '-'}}"
                                            class="form-control" readonly>
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                    <th>Tempat Lahir</th>
                                
                                    <th>

                                        <input type="text" required="" value="{{$detail->birth_place ?? '-'}}"
                                            id="birth_place" class="form-control" readonly>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                               
                                    <th>

                                        <input type="text" required="" id="tgl_lahir"
                                            value="{{Carbon\Carbon::parse($detail->tgl_lahir)->format('d/m/Y')}}" class="form-control" readonly>
                                    </th>
                                </tr>
                                    <tr>
                                        <th>
                                            Agama
                                        </th>
                                        <td>
                                          @php
                                        $nama_agama= \App\Agama::getAgama($detail->agama);
                                        @endphp

                                        <input type="text" required="" value="{{$nama_agama->nama ?? '-'}}" id="agama"
                                            class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Status Pekerjaan
                                        </th>
                                        <td>
                                         
                                        @php
                                        $nama_job= \App\Job::getJob($detail->pekerjaan);
                                        @endphp

                                        <input type="text" required="" value="{{$nama_job->name ?? '-'}}" id="pekerjaan"
                                            class="form-control" readonly>
                                    
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Status Perkawinan
                                        </th>
                                        <td>
                                           @php
                                        $nama_kawin= \App\Perkawinan::getMer($detail->status_kawin);
                                        @endphp

                                        <input type="text" required="" value="{{$nama_kawin->nama ?? '-'}}" id="nik"
                                            class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            No. Hp
                                        </th>
                                        <td>
                                             <input type="text" required="" value="{{$detail->no_hp ?? '-'}}" 
                                            class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Email
                                        </th>
                                        <td>
                                         
                                             <input type="text" required="" value="{{$member->key ?? '-'}}" 
                                            class="form-control" readonly>
                                  
                                        </td>
                                    </tr>
                                     <tr>
                                        <th>
                                            Jenis Kelamin
                                        </th>
                                        <td>
                                            @php
                                            $name_gen = \App\Gender::getGender($detail->gender);
                                            @endphp
                                           
                                             <input type="text" required="" value="{{$name_gen->name ?? '-'}}" 
                                            class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Alamat
                                        </th>
                                      <td>
                                             <input type="text" required="" value="{{$detail->alamat ?? '-'}}" 
                                            class="form-control" readonly>
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
                                          
                                             <input type="text" required="" value="{{$name->name ?? '-'}}" 
                                            class="form-control" readonly>
                                    
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Kabupaten/Kota
                                        </th>
                                        <td>
                                            @php
                                            $name_kab = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                                            @endphp
                                           
                                             <input type="text" required="" value="{{$name_kab->name ?? '-'}}" 
                                            class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Kecamatan
                                        </th>
                                        <td>
                                            @php
                                            $name_kec = \App\Kecamatan::getKec($detail->kecamatan_domisili);
                                            @endphp
                                            <input type="text" required="" value="{{$name_kec->name ?? '-'}}" 
                                            class="form-control" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Kelurahan
                                        </th>
                                        <td>
                                            @php
                                            $name_kel = \App\Kelurahan::getKel($detail->kelurahan_domisili);
                                            @endphp
                                             <input type="text" required="" value="{{$name_kel->name ?? ''}}" 
                                            class="form-control" readonly>
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