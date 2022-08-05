@extends('layouts.master', ['title' => 'Odontogram Pasien'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-title">Odontogram Pasien</h1>

        <x-alert></x-alert>

        <div class="card">
            <div class="card-header" style="display: flex;">
                <h5 class="text-bold card-title mr-auto">Odontogram Pasien / {{ $customer->nama }}</h5>
                <a href="{{ route('admin.pasien.cekfisik', $customer->id) }}" class="btn btn-sm btn-success">Pemeriksaan Fisik</a>
            </div>

            <div class="card-body">
                <table width="100%" style="overflow-x:auto;">
                    <tr>
                        <td>
                            <div id="svgselect" style="width: 710px;height: 300px;">
                                @include('components.gigi', ['customer' => $customer, 'scale' => 1.7])
                            </div>
                        </td>
                        <td style="width: 20%;padding-left: 10px">
                            <span class="gigi">Posisi Gigi : </span><br>
                            <span id="nomorgigi">XX</span>
                            <span class="gigi">-</span>
                            <span id="posisigigi">X</span><br><br>
                            <span>Gigi <span id="kposisi"></span> :</span><br>
                            <span id="kondisi-gigi" value="">--</span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="card">
            <div class="card-header">Keterangan Tambahan</div>

            <div class="card-body">
                <form action="{{ route('ketodonto.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="occlusi">Occlusi</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="occlusi" id="occlusi" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option {{ $ketodonto->occlusi == 'Normal Bite' ? 'selected' : '' }} value="Normal Bite">Normal Bite</option>
                                        <option {{ $ketodonto->occlusi == 'Step Bite' ? 'selected' : '' }} value="Step Bite">Step Bite</option>
                                        <option {{ $ketodonto->occlusi == 'Cross Bite' ? 'selected' : '' }} value="Cross Bite">Cross Bite</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="ket_occlusi" id="ket_occlusi" class="form-control" value="{{ $ketodonto->ket_occlusi ? $ketodonto->ket_occlusi : '' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="t_palatinus">Torus Palatinus</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="t_palatinus" id="t_palatinus" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option {{ $ketodonto->t_palatinus == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $ketodonto->t_palatinus == 'Kecil' ? 'selected' : '' }} value="Kecil">Kecil</option>
                                        <option {{ $ketodonto->t_palatinus == 'Sedang' ? 'selected' : '' }} value="Sedang">Sedang</option>
                                        <option {{ $ketodonto->t_palatinus == 'Besar' ? 'selected' : '' }} value="Besar">Besar</option>
                                        <option {{ $ketodonto->t_palatinus == 'Multiple' ? 'selected' : '' }} value="Multiple">Multiple</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="ket_tp" id="ket_tp" class="form-control" value="{{ $ketodonto->ket_tp ? $ketodonto->ket_tp : '' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="t_mandibularis">Torus Mandibularis</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="t_mandibularis" id="t_mandibularis" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option {{ $ketodonto->t_mandibularis == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $ketodonto->t_mandibularis == 'Sisi Kiri' ? 'selected' : '' }} value="Sisi Kiri">Sisi Kiri</option>
                                        <option {{ $ketodonto->t_mandibularis == 'Sisi Kanan' ? 'selected' : '' }} value="Sisi Kanan">Sisi Kanan</option>
                                        <option {{ $ketodonto->t_mandibularis == 'Kedua Sisi' ? 'selected' : '' }} value="Kedua Sisi">Kedua Sisi</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="ket_tm" id="ket_tm" class="form-control" value="{{ $ketodonto->ket_tm ? $ketodonto->ket_tm : '' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="palatum">Palatum</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="palatum" id="palatum" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option {{ $ketodonto->palatum == 'Dalam' ? 'selected' : '' }} value="Dalam">Dalam</option>
                                        <option {{ $ketodonto->palatum == 'Sedang' ? 'selected' : '' }} value="Sedang">Sedang</option>
                                        <option {{ $ketodonto->palatum == 'Rendah' ? 'selected' : '' }} value="Rendah">Rendah</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="ket_palatum" id="ket_palatum" class="form-control" value="{{ $ketodonto->ket_palatum ? $ketodonto->ket_palatum : '' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="diastema">Diastema</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="diastema" id="diastema" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option {{ $ketodonto->diastema == 'Tidak Ada' ? 'selected' : '' }} value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $ketodonto->diastema == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="ket_diastema" id="ket_diastema" class="form-control" value="{{ $ketodonto->ket_diastema ? $ketodonto->ket_diastema : '' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="anomali">Gigi Anomali</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="anomali" id="anomali" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option {{ $ketodonto->anomali == 'Tidak Ada' ? 'selected' : '' }}value="Tidak Ada">Tidak Ada</option>
                                        <option {{ $ketodonto->anomali == 'Ada' ? 'selected' : '' }} value="Ada">Ada</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="ket_anomali" id="ket_anomali" class="form-control" value="{{ $ketodonto->ket_anomali ? $ketodonto->ket_anomali : '' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="lain">Lain</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="lain" id="lain" class="form-control" value="{{ $ketodonto->lain ? $ketodonto->lain : '' }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ route('admin.pasien.cetakodonto', $customer->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Cetak Pemeriksaan</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Riwayat Pemeriksaan Pasien</div>

            <div class="card-body">
                <a href="{{ route('admin.pasien.cetakriwayat', $customer->id) }}" class="btn btn-sm btn-danger mb-3"><i class="fa fa-print"></i> Cetak Riwayat</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Gigi</th>
                                <th>Kondisi</th>
                                <th>Anamnesa</th>
                                <th>Pemeriksa</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($riwayat as $his)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($his->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $his->no_gigi }}</td>
                                <td><span style="background-color: {{ $his->simbol->warna }}">&nbsp; &nbsp;&nbsp;</span> {{ $his->simbol->nama_simbol }} ({{ $his->simbol->singkatan }})</td>
                                <td>{{ $his->keterangan }}</td>
                                <td>{{ $his->user->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
<script>
    $(document).ready(function() {
        $("polygon").mouseover(function() {
            var a = $(this).attr('id');
            var s = $(this).attr('fill');
            var i = $(this).parent().attr('id');

            $("#nomorgigi").html(i), $("#posisigigi").html(a), $("#kposisi").html(i + "-" + a)

            $.ajax({
                type: 'GET',
                url: '/admin/pasien/simbol/' + s,
                cache: !1,
                success: function(result) {
                    console.log(result)
                    $("#kondisi-gigi").html(result.nama + " (" + result.singkatan + ")")
                },
                error: function(result) {
                    $("#kondisi-gigi").html("Data tidak ditemukan")
                }
            })
        });

        $("polygon").mouseout(function() {
            $("#nomorgigi").html("XX")
            $("#posisigigi").html("X")
            $("#kondisi-gigi").html("--")
            $("#kposisi").html("")
        });

        $("polygon").click(function(t) {
            const o = $(this).attr("data-id");

            var i = $(this).parent().attr('id');
            var a = $(this).attr('id');
            var s = i + a;

            window.location.href = "/rekam-medis/create?pasien=" + o + "&gigi=" + s;
        })

    });
</script>
@stop