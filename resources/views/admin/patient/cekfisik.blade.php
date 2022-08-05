@extends('layouts.master', ['title' => 'Pemeriksaan Fisik Pasien'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-title">Pemeriksaan Fisik Pasien</h1>

        <x-alert></x-alert>

        <div class="card">
            <div class="card-header d-flex">
                <h5 class="text-bold card-title mr-auto">Pemeriksaan Fisik Pasien / {{ $customer->nama }}</h5>
                <a href="{{ route('admin.pasien.odontogram', $customer->id) }}" class="btn btn-sm btn-success">Back</a>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.pasien.storefisik', $customer->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="gol_darah">Golongan Darah</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="gol_darah" id="gol_darah" class="form-control" value="{{ $customer->fisik->gol_darah ?? '-' }}" placeholder="Golongan Darah">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="tekanan_darah">Tekanan Darah</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="tekanan_darah" id="tekanan_darah" class="form-control" value="{{ $customer->fisik->tekanan_darah ?? '-' }}" placeholder="120/70">
                                </div>
                                <div class="col-md-6">
                                    <select name="ket_tekanan" id="ket_tekanan" class="form-control">
                                        <option disabled selected>-- Keterangan --</option>
                                        <option {{ $customer->fisik->ket_tekanan == 'Normal' ? 'selected' : '' }} value="Normal">Normal</option>
                                        <option {{ $customer->fisik->ket_tekanan == 'Hypertensi' ? 'selected' : '' }} value="Hypertensi">Hypertensi</option>
                                        <option {{ $customer->fisik->ket_tekanan == 'Hypotensi' ? 'selected' : '' }} value="Hypotensi">Hypotensi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="pny_jantung">Penyakit Jantung</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="pny_jantung" id="pny_jantung" class="form-control">
                                        <option {{ $customer->fisik->pny_jantung == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $customer->fisik->pny_jantung == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="diabetes">Diabetes</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="diabetes" id="diabetes" class="form-control">
                                        <option {{ $customer->fisik->diabetes == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $customer->fisik->diabetes == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="haemopilia">Haemopilia</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="haemopilia" id="haemopilia" class="form-control">
                                        <option {{ $customer->fisik->haemopilia == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $customer->fisik->haemopilia == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="hepatitis">Hepatitis</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="hepatitis" id="hepatitis" class="form-control">
                                        <option {{ $customer->fisik->hepatitis == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $customer->fisik->hepatitis == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="gastring">Gastring</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="gastring" id="gastring" class="form-control">
                                        <option {{ $customer->fisik->gastring == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $customer->fisik->gastring == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="pny_lainnya">Penyakit Lainnya</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="pny_lainnya" id="pny_lainnya" class="form-control">
                                        <option {{ $customer->fisik->pny_lainnya == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $customer->fisik->pny_lainnya == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="ket_lainnya" id="ket_lainnya" class="form-control" placeholder="Keterangan" value="{{ $customer->fisik->ket_lainnya ?? '-' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="alergi_obat">Alergi Obat-Obatan</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="alergi_obat" id="alergi_obat" class="form-control">
                                        <option {{ $customer->fisik->alergi_obat == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $customer->fisik->alergi_obat == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="ket_obat" id="ket_obat" class="form-control" placeholder="Keterangan" value="{{ $customer->fisik->ket_obat ?? '-' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="alergi_obat">Alergi Makanan</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="alergi_makanan" id="alergi_makanan" class="form-control">
                                        <option {{ $customer->fisik->alergi_makanan == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $customer->fisik->alergi_makanan == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="ket_makanan" id="ket_makanan" class="form-control" placeholder="Keterangan" value="{{ $customer->fisik->ket_makanan ?? '-' }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop