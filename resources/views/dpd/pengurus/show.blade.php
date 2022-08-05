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
        transform: scale(2);
        cursor: zoom-out
    }
</style>
<div class="row">
    <div class="col-md-4">

    </div>

    <div class="col-sm-8 text-right m-b-20">

    </div>
</div>
<div class="row justify-content-center">
    <div class="col-sm-8 col-sg-8 col-md-11">
        <div class="card">
            <div class="card-header">
                <h4 class="page-title" style="font-weight:bold;">
                  
                   Kabupaten / Kota DPC {{$kabupaten->name}}</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="panel panel-default">
                        <div class="panel-heading"
                            style="background-color:#D6A62C;  font-size:15px; color:#FFFF; font-weight:bold;">
                            Pengurus Pusat Partai Hanura</div>
                        <div class="panel-body">
                             @if(count($penguruspusat) != 0)
                            @foreach($penguruspusat as $data)
                            <div style=" display: inline-block; margin-top:40px; margin-left:10px;">
                                <div class="col-sm-8 col-sg-8 col-md-10">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap">
                                            <div class='click-zoom'>
                                                <label>
                                                    <input type='checkbox'>
                                                    <img src="{{asset('uploads/img/foto_kepengurusan/'.$data->foto)}}"
                                                        alt='noimage' width='80px' height='80px'>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="profile-basic">
                                            <h3 class="user-name m-t-0 mb-2">{{ $data->nama }}</h3>
                                            <table width="315" border="0px" cellpadding="0px" cellspacing="0px"
                                                class="bold">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">Nama</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->name}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">No. Anggota</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->kta}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">NIK</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->nik}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">TTD</td>
                                                        <td class="font-kartu">:</td>
                                                        <td>
                                                            <div class='click-zoom'>
                                                                <label>
                                                                    <input type='checkbox'>
                                                                    <img src="{{asset('uploads/img/ttd_kta/'.$data->ttd)}}"
                                                                        alt='noimage' width='80px' height='80px'>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             @endforeach
                             @else
                               
                                   <a style="font-weight:bold; text-align:center; font-size:14px;" class="text-center">Data Belum Ada</a>
                            
                         
                                @endif
                          
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"
                            style="background-color:#D6A62C;  font-size:15px; color:#FFFF; font-weight:bold;">
                            Pengurus DPC </div>
                        <div class="panel-body">
                            @if(count($detail) != 0)
                            @foreach($detail as $data)
                            <div style=" display: inline-block; margin-top:40px; margin-left:10px;">
                                <div class="col-sm-8 col-sg-8 col-md-10">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap">
                                            <div class='click-zoom'>
                                                <label>
                                                    <input type='checkbox'>
                                                    <img src="{{asset('uploads/img/foto_kepengurusan/'.$data->foto)}}"
                                                        alt='noimage' width='80px' height='80px'>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="profile-basic">
                                            <h3 class="user-name m-t-0 mb-2">{{ $data->nama }}</h3>
                                            <table width="315" border="0px" cellpadding="0px" cellspacing="0px"
                                                class="bold">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">Nama</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->name}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">No. Anggota</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->kta}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">NIK</td>
                                                        <td class="font-kartu">:</td>
                                                        <td class="font-kartu">
                                                            {{$data->nik}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold; font-size:14px;"
                                                            class="font-kartu">TTD</td>
                                                        <td class="font-kartu">:</td>
                                                        <td>
                                                            <div class='click-zoom'>
                                                                <label>
                                                                    <input type='checkbox'>
                                                                    <img src="{{asset('uploads/img/ttd_kta/'.$data->ttd)}}"
                                                                        alt='noimage' width='80px' height='80px'>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                             @else
                               
                                   <a style="font-weight:bold; text-align:center; font-size:14px;" class="text-center">Data Belum Ada</a>
                            
                         
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop