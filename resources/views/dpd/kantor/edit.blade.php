@extends('layouts.master', ['title' => 'Provinsi'])

@section('content')
<div class="row">
    <div class="col-md-6">
        <h4 class="page-title">Edit Kantor DPC Kabupaten/Kota {{ $daerah->name }}</h4>
    </div>

    <div class="col-sm-6 text-right m-b-20">
        
    </div>
</div>
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
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <!-- {{ trans('cruds.information.title_singular') }} {{ trans('global.list') }} -->
                <!-- Informasi -->
            </div>

            <div class="card-body pl-4">
                <form method="post" action="{{ "/dpd/kabupaten/$daerah->id_kab/kantor/$kantor->id_kantor" }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_daerah" value="{{ $daerah->id_kab }}">

                    <div class="row mb-4">
                        <label for="alamat" class="col-sm-2 col-form-label" placeholder="Alamat">Alamat</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="alamat" name="alamat" rows="5">{{ $kantor->alamat }}</textarea>
                            @if($errors->has('alamat'))
                            <strong class="text-danger">
                                {{ $errors->first('alamat') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">
                            <select name="provinsi" id="provinsi" class="form-control select2" style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                 @foreach($provinsi as $data => $row)
                                <option value="{{ $data }}" @if($kantor->provinsi == $data) selected @endif>{{ $row }}</option>
                                 @endforeach
                                <!--@foreach($provinsi as $data => $row)-->
                                <!--<option {{ $data == $kantor->provinsi ? 'selected' : '' }} value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>-->
                                <!--@endforeach-->
                            </select>
                            @if($errors->has('provinsi'))
                            <strong class="text-danger">
                                {{ $errors->first('provinsi') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="kab_kota" class="col-sm-2 col-form-label">Kab/Kota</label>
                        <div class="col-sm-10">
                            <select name="kab_kota" id="kab_kota" class="form-control select2" 
                                style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                 @foreach($kabupaten as $data => $row)
                                <option value="{{ $data }}" @if($kantor->kab_kota == $data) selected @endif>{{ $row }}</option>
                                 @endforeach
                                <!--@foreach($kabupaten as $data => $row)-->
                                <!--<option {{ $data == $kantor->kab_kota ? 'selected' : '' }} value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>-->
                                <!--@endforeach-->
                            </select>
                            @if($errors->has('kab_kota'))
                            <strong class="text-danger">
                                {{ $errors->first('kab_kota') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="kec" class="col-sm-2 col-form-label">Kecamatan</label>
                        <div class="col-sm-10">
                            <select name="kec" id="kec" class="form-control select2" 
                                style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                 @foreach($kecamatan as $data => $row)
                                <option value="{{ $data }}" @if($kantor->kec == $data) selected @endif>{{ $row }}</option>
                                 @endforeach
                                <!--@foreach($kecamatan as $data => $row)-->
                                <!--<option {{ $data == $kantor->kec ? 'selected' : '' }} value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>-->
                                <!--@endforeach-->
                            </select>
                            @if($errors->has('kec'))
                            <strong class="text-danger">
                                {{ $errors->first('kec') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="kel" class="col-sm-2 col-form-label">Kelurahan</label>
                        <div class="col-sm-10">
                            <select name="kel" id="kel" class="form-control select2" 
                                style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                 @foreach($kelurahan as $data => $row)
                                <option value="{{ $data }}" @if($kantor->kel == $data) selected @endif>{{ $row }}</option>
                                 @endforeach
                                <!--@foreach($kelurahan as $data => $row)-->
                                <!--<option {{ $data == $kantor->kel ? 'selected' : '' }} value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>-->
                                <!--@endforeach-->
                            </select>
                            @if($errors->has('kel'))
                            <strong class="text-danger">
                                {{ $errors->first('kel') }}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="rt_rw" class="col-sm-2 col-form-label">RT/RW</label>
                        <div class="col-sm-10">
                            <input type="text" name="rt_rw" class="form-control" id="rt_rw" placeholder="RT/RW" value="{{ $kantor->rt_rw }}">
                            @if($errors->has('rt_rw'))
                                <strong class="text-danger">
                                    {{ $errors->first('rt_rw') }}
                                </strong>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="kode_pos" class="col-sm-2 col-form-label">Kode Pos</label>
                        <div class="col-sm-10">
                            <input type="text" name="kode_pos" class="form-control" id="kode_pos" placeholder="Kode Pos" value="{{ $kantor->kode_pos }}">
                            @if($errors->has('kode_pos'))
                                <strong class="text-danger">
                                    {{ $errors->first('kode_pos') }}
                                </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="15" name="no_telp" class="form-control" id="no_telp" placeholder="Nomor Telepon" value="{{ $kantor->no_telp }}">
                            @if($errors->has('no_telp'))
                                <strong class="text-danger">
                                    {{ $errors->first('no_telp') }}
                                </strong>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="wa_kantor" class="col-sm-2 col-form-label">WhatsApp Kantor</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="15"name="wa_kantor" class="form-control" id="wa_kantor" placeholder="WhatsApp Kantor" value="{{$kantor->wa_kantor}}">
                            @if($errors->has('wa_kantor'))
                            <strong class="text-danger">
                                {{ $errors->first('wa_kantor')}}
                            </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="fax" class="col-sm-2 col-form-label">Nomor Fax</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="15" name="fax" class="form-control" id="fax" placeholder="Nomor Fax" value="{{ $kantor->fax }}">
                            @if($errors->has('fax'))
                                <strong class="text-danger">
                                    {{ $errors->first('fax') }}
                                </strong>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Alamat Email" value="{{ $kantor->email }}">
                            @if($errors->has('email'))
                            <strong class="text-danger">
                                {{ $errors->first('email') }}
                            </strong>
                        @endif
                        </div>
                    </div>
                    <!-- <div class="row mb-4">-->
                    <!--    <label for="koordinat" class="col-sm-2 col-form-label">Koordinat</label>-->
                    <!--    <div class="col-10">-->
                    <!--        <input type="koordinat" name="koordinat" class="form-control" id="koordinat" placeholder="Koordinat" value="{{ $kantor->koordinat }}">-->
                    <!--        @if($errors->has('koordinat'))-->
                    <!--        <strong class="text-danger">-->
                    <!--            {{ $errors->first('koordinat') }}-->
                    <!--        </strong>-->
                    <!--    @endif-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="row mb-4">
                            <label for="tanggal_pengesahan_sk" class="col-sm-2 col-form-label">Tanggal Pengesahan SK</label>
                            <div class="col-sm-10">
                                <input type="date"   value="{{ Carbon\Carbon::parse($kantor->tanggal_pengesahan_sk)->format('Y-m-d') }}" id="tanggal_pengesahan_sk" name="tanggal_pengesahan_sk" class="form-control"
                                     >
                                @if($errors->has('tanggal_pengesahan_sk'))
                                <strong class="text-danger">
                                    {{ $errors->first('tanggal_pengesahan_sk') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                      <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">SK. Kepengurusan</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->no_sk))
                            <a style="font-size:14px;" href="{{asset('/uploads/file/no_sk/'.$kantor->no_sk)}}">Download
                                SK. Kepengurusan</a>
                            @endif
                            <input type="hidden" name="no_sk_lama" value="{{ $kantor->no_sk ?? '' }}">
                            <input type="file" id="no_sk" accept=".pdf,.doc" name="no_sk" class="form-control" value="">
                            @if($errors->has('no_sk'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran SK. Kepengurusan Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Surat Ket Domisili</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->domisili))
                            <a style="font-size:14px;" href="{{asset('/uploads/file/domisili/'.$kantor->domisili)}}">Download
                                Domisili</a>
                            @endif
                            <input type="hidden" name="domisili_lama" value="{{ $kantor->domisili ?? '' }}">
                            <input type="file" id="domisili" accept=".pdf,.doc" name="domisili" class="form-control"
                                value="">
                            @if($errors->has('domisili'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Domisili Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>
                     <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Surat Keterangan Status Kantor</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->surat_keterangan_kantor))
                            <a style="font-size:14px;" href="{{asset('/uploads/file/surat_keterangan_kantor/'.$kantor->surat_keterangan_kantor)}}">Download
                                Surat Keterangan Status Kantor</a>
                            @endif
                            <input type="hidden" name="surat_keterangan_kantor_lama" value="{{ $kantor->surat_keterangan_kantor ?? '' }}">
                            <input type="file" id="surat_keterangan_kantor" accept=".pdf,.doc" name="surat_keterangan_kantor" class="form-control"
                                value="">
                            @if($errors->has('surat_keterangan_kantor'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Surat Keterangan Kantor Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>
                     <div class="row mb-4">
                        <label for="nomor_rekening_bank" class="col-sm-2 col-form-label">Input Rekening Bank</label>
                        <div class="col-sm-10">
                            <input type="text" name="nomor_rekening_bank" class="form-control" id="nomor_rekening_bank" placeholder="Nomor Rekening Bank" value="{{ $kantor->nomor_rekening_bank }}">
                            @if($errors->has('nomor_rekening_bank'))
                                <strong class="text-danger">
                                    {{ $errors->first('nomor_rekening_bank') }}
                                </strong>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="email" class="col-sm-2 col-form-label">Rekening Bank</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->rekening_bank))
                            <a style="font-size:14px;" href="{{asset('/uploads/file/rekening_bank/'.$kantor->rekening_bank)}}">Download
                                Rekening Bank</a>
                            @endif
                            <input type="hidden" name="rekening_bank_lama" value="{{ $kantor->rekening_bank ?? '' }}">
                            <input type="file" id="rekening_bank" accept=".pdf,.doc" name="rekening_bank" class="form-control"
                                value="">
                            @if($errors->has('rekening_bank'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Rekening Bank Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                pdf/doc</label>
                        </div>
                    </div>
                     <div class="row mb-4">
                        <label for="provinsi" class="col-sm-2 col-form-label">Nama Bank</label>
                        <div class="col-sm-10">
                            <select name="nama_bank" id="nama_bank" class="form-control select2"
                                style="width: 100%; height:36px;">
                                <option value="">-- Pilih --</option>
                                @foreach($nama_bank as $data => $row)
                                <option  {{ $data == $kantor->nama_bank ? 'selected' : '' }} value="{{ $data }}" name="{{ $row }}">{{ $row }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('nama_bank'))
                            <strong class="text-danger">
                                {{ $errors->first('nama_bank') }}
                            </strong>
                            @endif
                        </div>
                    </div>
                   

                    <div class="row mb-4">
                        <label for="cap_kantor" class="col-sm-2 col-form-label">Upload Cap Kantor (Stempel)</label>
                        <div class="col-sm-10">
                            @if(!empty($kantor->cap_kantor))
                            <br>
                            <div class='click-zoom'>
                                <label>
                                    <input type='checkbox'>
                                    <img src="{{asset('uploads/img/cap_kantor/'.$kantor->cap_kantor)}}" alt='noimage'
                                        width='150px' height='100px'>
                                </label>
                            </div>
                            <input type="hidden" name="cap_kantor_lama" value="{{ $kantor->cap_kantor ?? '' }}">
                            <input type="file" accept="image/png, image/jpg, image/jpeg" id="cap_kantor" name="cap_kantor"
                                class="form-control" value="">
                            @else
                            <input type="hidden" name="cap_kantor_lama" value="{{ $kantor->cap_kantor ?? '' }}">
                            <input type="file" accept="image/png, image/jpg, image/jpeg" id="cap_kantor" name="cap_kantor"
                                class="form-control" value="">
                            @if($errors->has('cap_kantor'))
                            <strong style="font-size:12px;" class="text-danger">
                                Silakan Pilih Ukuran Cap Kantor Kurang Dari 10 MB
                            </strong>
                            <br>
                            @endif
                            @endif
                            <label style="font-size:12px; " for="password"> <i
                                    class="fa-solid fa-triangle-exclamation"></i> Maksimum 10mb, format
                                jpg/jpeg/png</label>
                            <br>    
                             <a class="btn"
                            style="background-color:#D6A62C; color:#ffff; font-weight:bold;" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Contoh stempel
                            </a> 
                            <div class="collapse" id="collapseExample">
                            
                            <div class="card card-body">
                            <img src="https://siap.partaihanura.or.id/uploads/img/cap_kantor/1654525316.png" alt='noimage'
                                        width='150px' height='100px'>
                             </div>
                            </div>
                                
                        </div>
                    </div>
                     <div class="row mb-4">
                        <label for="cap_kantor" class="col-sm-2 col-form-label">Target Anggota (masukkan tanpa koma)</label>
                        <div class="col-sm-10">
                            <input type="number" name="target_dpc" value="{{$kantor->target_dpc }}" class="form-control" id="target_dpc" placeholder="Target Anggota">
                            @if($errors->has('target_dpc'))
                            <strong class="text-danger">
                                {{ $errors->first('target_dpc') }}
                            </strong>
                        @endif
                        </div>
                    </div>
                     <div class="row mb-4">
                        <label for="cap_kantor" class="col-sm-2 col-form-label">Status Kantor</label>
                        <div class="col-sm-10">
                            <select name="status_kantor" id="status_kantor" class="form-control"
                                onchange="showDiv(this)">
                                <option value="">--- Pilih Status Kantor ---</option>
                                <option {{$kantor->status_kantor == '1' ? 'selected' : ''}}  value="1">Milik Sendiri</option>
                                <option {{$kantor->status_kantor == '2' ? 'selected' : ''}} value="2">Sewa</option>
                                <option {{$kantor->status_kantor == '3' ? 'selected' : ''}} value="3">Pinjam Pakai</option>

                            </select>
                            @if($errors->has('status_kantor'))
                            <strong class="text-danger">
                                {{ $errors->first('status_kantor') }}
                            </strong>
                            @endif
                        </div>
                    </div>
                    @if($kantor->status_kantor == 2)
                    <div id="hidden_div">
                        <div class="row mb-4">
                            <label for="tgl_awal" class="col-sm-2 col-form-label">Tanggal Mulai Sewa</label>
                            <div class="col-sm-10">
                                <input type="date" id="tgl_awal" name="tgl_awal" class="form-control"
                                        value="{{ Carbon\Carbon::parse($kantor->tgl_awal)->format('Y-m-d') }}">
                                @if($errors->has('tgl_awal'))
                                <strong class="text-danger">
                                    {{ $errors->first('tgl_awal') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="tgl_selesai" class="col-sm-2 col-form-label">Tanggal Sewa Selesai</label>
                            <div class="col-sm-10">
                                <input type="date" id="tgl_selesai" name="tgl_selesai" class="form-control"
                                        value="{{ Carbon\Carbon::parse($kantor->tgl_selesai)->format('Y-m-d') }}">
                                @if($errors->has('tgl_selesai'))
                                <strong class="text-danger">
                                    {{ $errors->first('tgl_selesai') }}
                                </strong>
                                @endif
                            </div>

                        </div>

                    </div>
                    @elseif($kantor->status_kantor == 3)
                     <div id="hidden_div">
                        <div class="row mb-4">
                            <label for="tgl_awal" class="col-sm-2 col-form-label">Tanggal Mulai Pinjam Pakai</label>
                            <div class="col-sm-10">
                                <input type="date" id="tgl_awal" name="tgl_awal" class="form-control"
                                        value="{{ Carbon\Carbon::parse($kantor->tgl_awal)->format('Y-m-d') }}">
                                @if($errors->has('tgl_awal'))
                                <strong class="text-danger">
                                    {{ $errors->first('tgl_awal') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="tgl_selesai" class="col-sm-2 col-form-label">Tanggal Pinjam Pakai Selesai</label>
                            <div class="col-sm-10">
                                <input type="date" id="tgl_selesai" name="tgl_selesai" class="form-control"
                                        value="{{ Carbon\Carbon::parse($kantor->tgl_selesai)->format('Y-m-d') }}">
                                @if($errors->has('tgl_selesai'))
                                <strong class="text-danger">
                                    {{ $errors->first('tgl_selesai') }}
                                </strong>
                                @endif
                            </div>

                        </div>

                    </div>
                    @else
                    <div id="hidden_div" style="display:none;">
                        <div class="row mb-4">
                            <label for="tgl_awal" class="col-sm-2 col-form-label">Tanggal Mulai Sewa</label>
                            <div class="col-sm-10">
                                <input type="date" id="tgl_awal" name="tgl_awal" class="form-control"
                                     >
                                @if($errors->has('tgl_awal'))
                                <strong class="text-danger">
                                    {{ $errors->first('tgl_awal') }}
                                </strong>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="tgl_selesai" class="col-sm-2 col-form-label">Tanggal Sewa Selesai</label>
                            <div class="col-sm-10">
                                <input type="date" id="tgl_selesai" name="tgl_selesai" class="form-control"
                                        value="{{ old('tgl_selesai', Carbon\Carbon::parse($kantor->tgl_selesai)->format('Y-m-d')) }}">
                                @if($errors->has('tgl_selesai'))
                                <strong class="text-danger">
                                    {{ $errors->first('tgl_selesai') }}
                                </strong>
                                @endif
                            </div>

                        </div>

                    </div>
                    @endif
              
                    <div class="row mb-4">
                      
                        <div class="col-sm-10">
                            <input type="hidden" name="is_active" class="form-control" id="is_active" placeholder="Status Kantor" value="{{ $kantor->is_active }}">
                            @if($errors->has('is_active'))
                            <strong class="text-danger">
                                {{ $errors->first('is_active') }}
                            </strong>
                             @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <!--<label for="is_active" class="col-sm-2 col-form-label">Status Kantor</label>-->
                        <div class="col-10">
                             <button style="background-color:#D6A62C; color:#FFFF;"type="submit" class="btn btn-lg">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    function showDiv(select) {

        if (select.value != 1 ) {
            document.getElementById('hidden_div').style.display = "block";
        } else {
            document.getElementById('hidden_div').style.display = "none";
               var name = $("#tgl_awal").val('');
               var name = $("#tgl_selesai").val('');
                     console.log(name)//return true
        }
    }
</script>
<script>
  
  
     $("#provinsi").change(function() {
        let val = $(this).val();
        $.ajax({
            url: '/dpd/ajax/kantor/kab',
            data: {
                val : val
            },
            dataType:'json',
            type:'GET',
            success: function(response) {
                var len = response.length;
                $("#kab_kota").empty();
               $("#kab_kota").append('<option value="">--Pilih--</option>');
              
                    for( var i = 0; i<len; i++){
                        var code = response[i]['id_kab'];
                        var name = response[i]['name'];
                        $("#kab_kota").append("<option value='"+code+"'>"+name+"</option>");
                    }
                
            }
        });
    });

    $("#kab_kota").change(function() {
        let val = $(this).val();
        $.ajax({
           url: '/dpd/ajax/kantor/kec',
            data: {
                val : val
            },
            dataType:'json',
            type:'GET',
            success: function(response) {
                var len = response.length;
                $("#kec").prop('disabled', false);
                $("#kec").empty();
               $("#kec").append('<option value="">--Pilih--</option>');
            
                    for( var i = 0; i<len; i++){
                        var code = response[i]['id_kec'];
                        var name = response[i]['name'];
                        $("#kec").append("<option value='"+code+"'>"+name+"</option>");
                    }
                
            }
        });
    });


     $("#kec").change(function() {
        let val = $(this).val();
        $.ajax({
            url: '/dpd/ajax/kantor/kel',
            data: {
                val : val
            },
            dataType:'json',
            type:'GET',
            success: function(response) {
                var len = response.length;
                $("#kel").prop('disabled', false);
                $("#kel").empty();
                 $("#kel").append('<option value="">--Pilih--</option>');
           
                    for( var i = 0; i<len; i++){
                        var code = response[i]['id_kec'];
                        var name = response[i]['name'];
                        $("#kel").append("<option value='"+code+"'>"+name+"</option>");
                    }
                
            }
        });
    });

    function numericFilter(txb) {
        txb.value = txb.value.replace(/[^\0-9]/ig, "");
    }

</script>
@stop

