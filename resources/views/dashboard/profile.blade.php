@extends('layouts.master', ['title' => 'Profile'])

@section('content')
<div class="row">
    <div class="col-sm-7 col-6">
        <h4 class="page-title">My Profile</h4>
    </div>

</div>
<div class="card-box profile-header">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-view">
                <div class="profile-img-wrap">
                    <img class="rounded-circle" src="{{ asset('/uploads/img/users/' . auth()->user()->image ) }}"
                        width="80px" height="30px">

                </div>
                <div class="profile-basic">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="profile-info-left">
                                <h3 class="user-name m-t-0 mb-0">{{ $profile->name }}</h3>
                                <small class="text-muted">
                                    <span style="font-weight:bold; color:black;">{{ $model->key }}</span>
                                    </small>
                                <br>
                                <br>

                                <table width="315" border="0px" cellpadding="0px" cellspacing="0px" class="bold">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">Username</td>
                                            <td class="font-kartu">:</td>
                                            <td style="color:#D6A62C;"class="font-kartu">
                                              {{$profile->username}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">KTA ANGGOTA</td>
                                            <td class="font-kartu">:</td>
                                            <td class="font-kartu">
                                              {{$detail->no_member}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">NIK</td>
                                            <td class="font-kartu">:</td>
                                            <td class="font-kartu">
                                              {{$detail->nik}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">PROVINSI</td>
                                            <td class="font-kartu">:</td>
                                            <td class="font-kartu">
                                               @php
                                                $name = \App\Provinsi::getProv($detail->provinsi_domisili);
                                                @endphp
                                                {{ $name->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">KABUPATEN</td>
                                            <td class="font-kartu">:</td>
                                            <td class="font-kartu">
                                              @php
                                                $namo = \App\Kabupaten::getKab($detail->kabupaten_domisili);
                                                @endphp {{ $namo->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">KECAMATAN</td>
                                            <td class="font-kartu">:</td>
                                            <td class="font-kartu">
                                           @php
                                                $namw = \App\Kecamatan::getKec($detail->kecamatan_domisili);
                                                @endphp
                                                {{ $namw->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">KELURAHAN</td>
                                            <td class="font-kartu">:</td>
                                            <td class="font-kartu">
                                             @php
                                                $name_kel = \App\Kelurahan::getKel($detail->kelurahan_domisili);
                                                @endphp
                                                {{ $name_kel->name ?? '' }}</td>
                                        </tr>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-4 col-sg-6 m-b-6">
                           
                                <table width="315" border="0px" cellpadding="0px" cellspacing="0px" class="bold">
                                    <tbody>
                                     
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">TEMPAT LAHIR
                                            </td>
                                             <td class="font-kartu">:</td>
                                            <td class="font-kartu"> {{$detail->birth_place ? : '-'}}  </td>
            
                            
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">TANGGAL LAHIR
                                            </td>
                                           <td class="font-kartu"> :</td>
                                           <td class="font-kartu">  {{Carbon\Carbon::parse($detail->tgl_lahir ? : '-')->isoFormat('dddd, D MMMM Y')}}  </td>
            
                            
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">NOMOR TELEPON
                                            </td>
                                             <td class="font-kartu"> :</td>
                                             <td class="font-kartu">  {{$detail->no_hp ? : '-'}}  </td>
            
                            
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">GENDER
                                            </td>
                                         <td class="font-kartu"> :</td>
                                             <td class="font-kartu">  @php
                                        $nams = \App\Gender::getGender($detail->gender);
                                        @endphp
                                        {{ $nams->name ?? '-' }} </td>
            
                            
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">AGAMA
                                            </td>
                                         <td class="font-kartu"> :</td>
                                             <td class="font-kartu">  @php
                                        $name_agama = \App\Agama::getAgama($detail->agama);
                                        @endphp
                                        {{ $name_agama->nama ?? '-' }} </td>
            
                            
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">STATUS PERNIKAHAN
                                            </td>
                                         <td class="font-kartu"> :</td>
                                             <td class="font-kartu">  @php
                                        $name_kawin = \App\Perkawinan::getMer($detail->status_kawin);
                                        @endphp
                                        {{ $name_kawin->nama ?? '-' }} </td>
            
                            
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">STATUS PEKERJAAN
                                            </td>
                                         <td class="font-kartu"> :</td>
                                             <td class="font-kartu">  @php
                                        $name_job = \App\Job::getJob($detail->pekerjaan);
                                        @endphp
                                        {{ $name_job->name ?? '-' }} </td>
            
                            
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">RT / RW
                                            </td>
                                         <td class="font-kartu"> :</td>
                                             <td class="font-kartu">  
                                        {{ $detail->rt_rw ? : '-' }} </td>
            
                            
                                        </tr>
                                        <!--<tr>-->
                                        <!--    <td style="font-weight:bold; font-size:12px;" class="font-kartu">KODE POS-->
                                        <!--    </td>-->
                                        <!-- <td class="font-kartu"> :</td>-->
                                        <!--     <td class="font-kartu">  -->
                                        <!--{{ $detail->kode_pos ? : '-' }} </td>-->
            
                            
                                        <!--</tr>-->
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px;" class="font-kartu">ALAMAT
                                            </td>
                                         <td class="font-kartu"> :</td>
                                             <td class="font-kartu">  
                                        {{ $detail->alamat ?  : '-' }} </td>
            
                            
                                        </tr>
                                     
                                    </tbody>
            
                                </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop