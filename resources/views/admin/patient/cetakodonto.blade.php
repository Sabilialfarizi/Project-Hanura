@extends('layouts.doc', ['title' => 'Cetak Odontogram - eClinic'])

@section('body')

<body onload="" class="A4">

    <!-- Halaman 1 Formulir Odontogram -->
    <section class="sheet padding-15mm">
        <div class="header-doc" style="display: flex; margin-top: -20px;">
            <div class="img" style="margin-right: auto;">
                <img src="{{ asset('/storage/' . \App\Setting::find(1)->logo) }}" alt="" width="120px">
            </div>
            <div class="title" style="margin-right: auto;">
                <h3 align="center">REKAM MEDIK</h3>
            </div>
            <div class="box" style="border: 1px solid black; border-radius: 20px; height: 60px; width: 150px; text-align: center;">
                <h5>No. Rekam Medik : {{ $customer->rekam_medik }}</h5>
            </div>
        </div>



        <div class="header-doc" style="display: flex; margin-top: 10px; margin-bottom: 30px;">
            <div class="img" style="margin-right: auto;">
            </div>
            <div class="dokter">
                <table class="tabel-nama">
                    <tr>
                        <td>Nama Klinik</td>
                        <td>:</td>
                        <td>{{ \App\Setting::find(1)->web_name }} - {{ $customer->cabang->nama }}</td>
                    </tr>
                    <tr>
                        <td>Alamat Praktek</td>
                        <td>:</td>
                        <td>{{ $customer->cabang->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>:</td>
                        <td>{{ $customer->cabang->telpon }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div><strong><u>DATA PASIEN</u> </strong></div>
        <div style="margin-top: 20px;">
            <table class="tabel-nama">
                <tr>
                    <td>1.</td>
                    <td style="width: 250px;">Nama</td>
                    <td>:</td>
                    <td>{{ $customer->nama }}</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $customer->tempat_lahir }}, {{ $customer->tgl_lahir }}</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>No. Induk Kependudukan</td>
                    <td>:</td>
                    <td>{{ $customer->nik_ktp }}</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $customer->jk }}</td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Suku/Ras</td>
                    <td>:</td>
                    <td>{{ $customer->suku }}</td>
                </tr>

                <tr>
                    <td>6.</td>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $customer->alamat }}</td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>{{ $customer->pekerjaan }}</td>
                </tr>
            </table>
        </div><br>

        <div style="margin-top: 40px;"><strong><u>DATA MEDIK YANG DIPERLUKAN</u> </strong></div>
        <div style="margin-top: 20px;">
            <table class="tabel-nama">
                <tr>
                    <td>1.</td>
                    <td style="width: 250px;">Golongan Darah</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->gol_darah }}</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Tekanan Darah</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->tekanan_darah }} / {{ $customer->fisik->ket_tekanan }}</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Penyakit Jantung</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->pny_jantung }}</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Diabetes</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->diabetes }}</td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Haemopilia</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->haemopilia }}</td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>Hepatitis</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->hepatitis }}</td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>Gastring</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->gastring }}</td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td>Penyakit Lainnya</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->pny_lainnya }}</td>
                </tr>
                <tr>
                    <td>9.</td>
                    <td>Alergi terhadap obat-obatan</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->alergi_obat }} / {{ $customer->fisik->ket_obat }}</td>
                </tr>
                <tr>
                    <td>10.</td>
                    <td>Alergi terhadap makanan</td>
                    <td>:</td>
                    <td>{{ $customer->fisik->alergi_makanan }} / {{ $customer->fisik->ket_makanan }}</td>
                </tr>
            </table>
        </div><br>
    </section>

    <section class="sheet padding-15mm">
        <div class="header-doc" style="display: flex; margin-top: -20px;">
            <div class="img" style="margin-right: auto;">
                <img src=" {{ asset('/storage/' . \App\Setting::find(1)->logo) }}" alt="" width="80px">
            </div>
            <div class="box" style="border: 1px solid black; border-radius: 20px; height: 60px; width: 150px; text-align: center;">
                <h5>No. Rekam Medik :</h5>
            </div>
        </div>

        <h3 align="center">FORMULIR PEMERIKSAAN ODONTOGRAM</h3>
        <table style="display: inline-block">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $customer->nama }}</td>
            </tr>
            <tr>
                <td>Cabang</td>
                <td>:</td>
                <td>{{ $customer->cabang->nama }}</td>
            </tr>
        </table>
        <table style="float: right;">
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $customer->jk }}</td>
            </tr>
            <tr>
                <td>TTL</td>
                <td>:</td>
                <td>{{ $customer->tempat_lahir }}, {{ $customer->tgl_lahir }}</td>
            </tr>
        </table>
        <hr>

        <table border="1" width="100%" style="border-collapse: collapse;">
            <tr>
                <td width="15%" align="center">11 [51]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p11c == $customer->gigi->p11t && $customer->gigi->p11c == $customer->gigi->p11r && $customer->gigi->p11c == $customer->gigi->p11b && $customer->gigi->p11c == $customer->gigi->p11l)
                    {{ $customer->gigi->p11c }}
                    @else
                    {{ $customer->gigi->p11c . "," . $customer->gigi->p11t . "," . $customer->gigi->p11b . "," . $customer->gigi->p11r . "," . $customer->gigi->p11l }}
                    @endif - @if($customer->gigi->p51c == $customer->gigi->p51t && $customer->gigi->p51c == $customer->gigi->p51r && $customer->gigi->p51c == $customer->gigi->p51b && $customer->gigi->p51c == $customer->gigi->p51l)
                    {{ $customer->gigi->p51c }}
                    @else
                    {{ $customer->gigi->p51c . "," . $customer->gigi->p51t . "," . $customer->gigi->p51b . "," . $customer->gigi->p51r . "," . $customer->gigi->p51l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p61c == $customer->gigi->p61t && $customer->gigi->p61c == $customer->gigi->p61r && $customer->gigi->p61c == $customer->gigi->p61b && $customer->gigi->p61c == $customer->gigi->p61l)
                    {{ $customer->gigi->p61c }}
                    @else
                    {{ $customer->gigi->p61c . "," . $customer->gigi->p61t . "," . $customer->gigi->p21b. "," . $customer->gigi->p61r . "," . $customer->gigi->p61r }}
                    @endif - @if($customer->gigi->p21c == $customer->gigi->p21t && $customer->gigi->p21c == $customer->gigi->p21r && $customer->gigi->p21c == $customer->gigi->p21b && $customer->gigi->p21c == $customer->gigi->p21l)
                    {{ $customer->gigi->p21c }}
                    @else
                    {{ $customer->gigi->p21c . "," . $customer->gigi->p21t . "," . $customer->gigi->p21b . "," . $customer->gigi->p21r . "," . $customer->gigi->p21l }}
                    @endif
                </td>
                <td width="15%" align="center">[61] 21</td>
            </tr>
            <tr>
                <td width="15%" align="center">12 [52]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p12c == $customer->gigi->p12t && $customer->gigi->p12c == $customer->gigi->p12r && $customer->gigi->p12c == $customer->gigi->p12b && $customer->gigi->p12c == $customer->gigi->p12l)
                    {{ $customer->gigi->p12c }}
                    @else
                    {{ $customer->gigi->p12c . "," . $customer->gigi->p12t . "," . $customer->gigi->p12b . "," . $customer->gigi->p12r . "," . $customer->gigi->p12r }}
                    @endif - @if($customer->gigi->p52c == $customer->gigi->p52t && $customer->gigi->p52c == $customer->gigi->p52r && $customer->gigi->p52c == $customer->gigi->p52b && $customer->gigi->p52c == $customer->gigi->p52l)
                    {{ $customer->gigi->p52c }}
                    @else
                    {{ $customer->gigi->p52c . "," . $customer->gigi->p52t . "," . $customer->gigi->p52b . "," . $customer->gigi->p52r . "," . $customer->gigi->p52l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p62c == $customer->gigi->p62t && $customer->gigi->p62c == $customer->gigi->p62r && $customer->gigi->p62c == $customer->gigi->p62b&& $customer->gigi->p62c == $customer->gigi->p62l)
                    {{ $customer->gigi->p62c }}
                    @else
                    {{ $customer->gigi->p62c . "," . $customer->gigi->p62t . "," . $customer->gigi->p22b. "," . $customer->gigi->p62r . "," . $customer->gigi->p62r }}
                    @endif - @if($customer->gigi->p22c == $customer->gigi->p22t && $customer->gigi->p22c == $customer->gigi->p22r && $customer->gigi->p22c == $customer->gigi->p22b && $customer->gigi->p22c == $customer->gigi->p22l)
                    {{ $customer->gigi->p22c }}
                    @else
                    {{ $customer->gigi->p22c . "," . $customer->gigi->p22t . "," . $customer->gigi->p22b . "," . $customer->gigi->p22r . "," . $customer->gigi->p22l }}
                    @endif
                </td>
                <td width="15%" align="center">[62] 22</td>
            </tr>
            <tr>
                <td width="15%" align="center">43 [83]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p13c == $customer->gigi->p13t && $customer->gigi->p13c == $customer->gigi->p13r && $customer->gigi->p13c == $customer->gigi->p13b && $customer->gigi->p13c == $customer->gigi->p13l)
                    {{ $customer->gigi->p13c }}
                    @else
                    {{ $customer->gigi->p13c . "," . $customer->gigi->p13t . "," . $customer->gigi->p13b . "," . $customer->gigi->p13r . "," . $customer->gigi->p11l }}
                    @endif - @if($customer->gigi->p83c == $customer->gigi->p83t && $customer->gigi->p83c == $customer->gigi->p83r && $customer->gigi->p83c == $customer->gigi->p83b && $customer->gigi->p83c == $customer->gigi->p83l)
                    {{ $customer->gigi->p83c }}
                    @else
                    {{ $customer->gigi->p83c . "," . $customer->gigi->p83t . "," . $customer->gigi->p83b . "," . $customer->gigi->p83r . "," . $customer->gigi->p83l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p63c == $customer->gigi->p63t && $customer->gigi->p63c == $customer->gigi->p63r && $customer->gigi->p63c == $customer->gigi->p63b&& $customer->gigi->p63c == $customer->gigi->p63l)
                    {{ $customer->gigi->p63c }}
                    @else
                    {{ $customer->gigi->p63c . "," . $customer->gigi->p63t . "," . $customer->gigi->p23b. "," . $customer->gigi->p63r . "," . $customer->gigi->p63l }}
                    @endif - @if($customer->gigi->p23c == $customer->gigi->p23t && $customer->gigi->p23c == $customer->gigi->p23r && $customer->gigi->p23c == $customer->gigi->p23b && $customer->gigi->p23c == $customer->gigi->p23l)
                    {{ $customer->gigi->p23c }}
                    @else
                    {{ $customer->gigi->p23c . "," . $customer->gigi->p23t . "," . $customer->gigi->p23b . "," . $customer->gigi->p23r . "," . $customer->gigi->p23l }}
                    @endif
                </td>
                <td width="15%" align="center">[63] 23</td>
            </tr>
            <tr>
                <td width="15%" align="center">14 [54]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p14c == $customer->gigi->p14t && $customer->gigi->p14c == $customer->gigi->p14r && $customer->gigi->p14c == $customer->gigi->p14b && $customer->gigi->p14c == $customer->gigi->p14l)
                    {{ $customer->gigi->p14c }}
                    @else
                    {{ $customer->gigi->p14c . "," . $customer->gigi->p14t . "," . $customer->gigi->p14b . "," . $customer->gigi->p14r . "," . $customer->gigi->p11l }}
                    @endif - @if($customer->gigi->p54c == $customer->gigi->p54t && $customer->gigi->p54c == $customer->gigi->p54r && $customer->gigi->p54c == $customer->gigi->p54b && $customer->gigi->p54c == $customer->gigi->p54l)
                    {{ $customer->gigi->p54c }}
                    @else
                    {{ $customer->gigi->p54c . "," . $customer->gigi->p54t . "," . $customer->gigi->p54b . "," . $customer->gigi->p54r . "," . $customer->gigi->p54l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p64c == $customer->gigi->p64t && $customer->gigi->p64c == $customer->gigi->p64r && $customer->gigi->p64c == $customer->gigi->p64b && $customer->gigi->p64c == $customer->gigi->p64l)
                    {{ $customer->gigi->p64c }}
                    @else
                    {{ $customer->gigi->p64c . "," . $customer->gigi->p64t . "," . $customer->gigi->p24b. "," . $customer->gigi->p64r . "," . $customer->gigi->p64l }}
                    @endif - @if($customer->gigi->p24c == $customer->gigi->p24t && $customer->gigi->p24c == $customer->gigi->p24r && $customer->gigi->p24c == $customer->gigi->p24b && $customer->gigi->p24c == $customer->gigi->p24l)
                    {{ $customer->gigi->p24c }}
                    @else
                    {{ $customer->gigi->p24c . "," . $customer->gigi->p24t . "," . $customer->gigi->p24b . "," . $customer->gigi->p24r . "," . $customer->gigi->p24l }}
                    @endif
                </td>
                <td width="15%" align="center">[64] 24</td>
            </tr>
            <tr>
                <td width="15%" align="center">15 [55]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p15c == $customer->gigi->p15t && $customer->gigi->p15c == $customer->gigi->p15r && $customer->gigi->p15c == $customer->gigi->p15b && $customer->gigi->p15c == $customer->gigi->p15l)
                    {{ $customer->gigi->p15c }}
                    @else
                    {{ $customer->gigi->p15c . "," . $customer->gigi->p15t . "," . $customer->gigi->p15b . "," . $customer->gigi->p15r . "," . $customer->gigi->p11l }}
                    @endif - @if($customer->gigi->p55c == $customer->gigi->p55t && $customer->gigi->p55c == $customer->gigi->p55r && $customer->gigi->p55c == $customer->gigi->p55b && $customer->gigi->p55c == $customer->gigi->p55l)
                    {{ $customer->gigi->p55c }}
                    @else
                    {{ $customer->gigi->p55c . "," . $customer->gigi->p55t . "," . $customer->gigi->p55b . "," . $customer->gigi->p55r . "," . $customer->gigi->p55l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p65c == $customer->gigi->p65t && $customer->gigi->p65c == $customer->gigi->p65r && $customer->gigi->p65c == $customer->gigi->p65b && $customer->gigi->p65c == $customer->gigi->p65l)
                    {{ $customer->gigi->p65c }}
                    @else
                    {{ $customer->gigi->p65c . "," . $customer->gigi->p65t . "," . $customer->gigi->p25b. "," . $customer->gigi->p65r . "," . $customer->gigi->p65l }}
                    @endif - @if($customer->gigi->p25c == $customer->gigi->p25t && $customer->gigi->p25c == $customer->gigi->p25r && $customer->gigi->p25c == $customer->gigi->p25b && $customer->gigi->p25c == $customer->gigi->p25l)
                    {{ $customer->gigi->p25c }}
                    @else
                    {{ $customer->gigi->p25c . "," . $customer->gigi->p25t . "," . $customer->gigi->p25b . "," . $customer->gigi->p25r . "," . $customer->gigi->p25l }}
                    @endif
                </td>
                <td width="15%" align="center">[65] 25</td>
            </tr>
            <tr>
                <td width="15%" align="center">16</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p16c == $customer->gigi->p16t && $customer->gigi->p16c == $customer->gigi->p16r && $customer->gigi->p16c == $customer->gigi->p16b && $customer->gigi->p16c == $customer->gigi->p16l)
                    {{ $customer->gigi->p16c }}
                    @else
                    {{ $customer->gigi->p16c . "," . $customer->gigi->p16t . "," . $customer->gigi->p16b . "," . $customer->gigi->p16r . "," . $customer->gigi->p16l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p26c == $customer->gigi->p26t && $customer->gigi->p26c == $customer->gigi->p26r && $customer->gigi->p26c == $customer->gigi->p26b && $customer->gigi->p26c == $customer->gigi->p26l)
                    {{ $customer->gigi->p26c }}
                    @else
                    {{ $customer->gigi->p26c . "," . $customer->gigi->p26t . "," . $customer->gigi->p26b. "," . $customer->gigi->p26r . "," . $customer->gigi->p26r }}
                    @endif
                </td>
                <td width="15%" align="center">26</td>
            </tr>
            <tr>
                <td width="15%" align="center">17</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p17c == $customer->gigi->p17t && $customer->gigi->p17c == $customer->gigi->p17r && $customer->gigi->p17c == $customer->gigi->p17b && $customer->gigi->p17c == $customer->gigi->p17l)
                    {{ $customer->gigi->p17c }}
                    @else
                    {{ $customer->gigi->p17c . "," . $customer->gigi->p17t . "," . $customer->gigi->p17b . "," . $customer->gigi->p17r . "," . $customer->gigi->p17l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p27c == $customer->gigi->p27t && $customer->gigi->p27c == $customer->gigi->p27r && $customer->gigi->p27c == $customer->gigi->p27b && $customer->gigi->p27c == $customer->gigi->p27l)
                    {{ $customer->gigi->p27c }}
                    @else
                    {{ $customer->gigi->p27c . "," . $customer->gigi->p27t . "," . $customer->gigi->p27b. "," . $customer->gigi->p27r . "," . $customer->gigi->p27l }}
                    @endif
                </td>
                <td width="15%" align="center">27</td>
            </tr>
            <tr>
                <td width="15%" align="center">18</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p18c == $customer->gigi->p18t && $customer->gigi->p18c == $customer->gigi->p18r && $customer->gigi->p18c == $customer->gigi->p18b && $customer->gigi->p18c == $customer->gigi->p18l)
                    {{ $customer->gigi->p18c }}
                    @else
                    {{ $customer->gigi->p18c . "," . $customer->gigi->p18t . "," . $customer->gigi->p18b . "," . $customer->gigi->p18r . "," . $customer->gigi->p18l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p28c == $customer->gigi->p28t && $customer->gigi->p28c == $customer->gigi->p28r && $customer->gigi->p28c == $customer->gigi->p28b && $customer->gigi->p28c == $customer->gigi->p28l)
                    {{ $customer->gigi->p28c }}
                    @else
                    {{ $customer->gigi->p28c . "," . $customer->gigi->p28t . "," . $customer->gigi->p25b. "," . $customer->gigi->p28r . "," . $customer->gigi->p28l }}
                    @endif
                </td>
                <td width="15%" align="center">28</td>
            </tr>
        </table><br>

        <div id="svgselect" style="margin-left: 115px; height: 180px;">
            @include('components.gigi', ['customer' => $customer, 'scale' => 1.1])
        </div>

        <table border="1" width="100%" style="border-collapse: collapse;">
            <tr>
                <td width="15%" align="center">48</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p48c == $customer->gigi->p48t && $customer->gigi->p48c == $customer->gigi->p48r && $customer->gigi->p48c == $customer->gigi->p48b && $customer->gigi->p48c == $customer->gigi->p48l)
                    {{ $customer->gigi->p48c }}
                    @else
                    {{ $customer->gigi->p48c . "," . $customer->gigi->p48t . "," . $customer->gigi->p48b . "," . $customer->gigi->p48r . "," . $customer->gigi->p48l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p38c == $customer->gigi->p38t && $customer->gigi->p38c == $customer->gigi->p38r && $customer->gigi->p38c == $customer->gigi->p38b && $customer->gigi->p38c == $customer->gigi->p38l)
                    {{ $customer->gigi->p38c }}
                    @else
                    {{ $customer->gigi->p38c . "," . $customer->gigi->p38t . "," . $customer->gigi->p25b. "," . $customer->gigi->p38r . "," . $customer->gigi->p38l }}
                    @endif
                </td>
                <td width="15%" align="center">38</td>
            </tr>
            <tr>
                <td width="15%" align="center">47</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p47c == $customer->gigi->p47t && $customer->gigi->p47c == $customer->gigi->p47r && $customer->gigi->p47c == $customer->gigi->p47b && $customer->gigi->p47c == $customer->gigi->p47l)
                    {{ $customer->gigi->p47c }}
                    @else
                    {{ $customer->gigi->p47c . "," . $customer->gigi->p47t . "," . $customer->gigi->p47b . "," . $customer->gigi->p47r . "," . $customer->gigi->p47l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p37c == $customer->gigi->p37t && $customer->gigi->p37c == $customer->gigi->p37r && $customer->gigi->p37c == $customer->gigi->p37b && $customer->gigi->p37c == $customer->gigi->p37l)
                    {{ $customer->gigi->p37c }}
                    @else
                    {{ $customer->gigi->p37c . "," . $customer->gigi->p37t . "," . $customer->gigi->p37b. "," . $customer->gigi->p37r . "," . $customer->gigi->p37l }}
                    @endif
                </td>
                <td width="15%" align="center">37</td>
            </tr>
            <tr>
                <td width="15%" align="center">46</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p46c == $customer->gigi->p46t && $customer->gigi->p46c == $customer->gigi->p46r && $customer->gigi->p46c == $customer->gigi->p46b && $customer->gigi->p46c == $customer->gigi->p46l)
                    {{ $customer->gigi->p46c }}
                    @else
                    {{ $customer->gigi->p46c . "," . $customer->gigi->p46t . "," . $customer->gigi->p46b . "," . $customer->gigi->p46r . "," . $customer->gigi->p46l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p36c == $customer->gigi->p36t && $customer->gigi->p36c == $customer->gigi->p36r && $customer->gigi->p36c == $customer->gigi->p36b && $customer->gigi->p36c == $customer->gigi->p36l)
                    {{ $customer->gigi->p36c }}
                    @else
                    {{ $customer->gigi->p36c . "," . $customer->gigi->p36t . "," . $customer->gigi->p36b. "," . $customer->gigi->p36r . "," . $customer->gigi->p36l }}
                    @endif
                </td>
                <td width="15%" align="center">36</td>
            </tr>
            <tr>
                <td width="15%" align="center">45 [85]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p45c == $customer->gigi->p45t && $customer->gigi->p45c == $customer->gigi->p45r && $customer->gigi->p45c == $customer->gigi->p45b && $customer->gigi->p45c == $customer->gigi->p45l)
                    {{ $customer->gigi->p45c }}
                    @else
                    {{ $customer->gigi->p45c . "," . $customer->gigi->p45t . "," . $customer->gigi->p45b . "," . $customer->gigi->p45r . "," . $customer->gigi->p45l }}
                    @endif - @if($customer->gigi->p85c == $customer->gigi->p85t && $customer->gigi->p85c == $customer->gigi->p85r && $customer->gigi->p85c == $customer->gigi->p85b && $customer->gigi->p85c == $customer->gigi->p85l)
                    {{ $customer->gigi->p85c }}
                    @else
                    {{ $customer->gigi->p85c . "," . $customer->gigi->p85t . "," . $customer->gigi->p85b . "," . $customer->gigi->p85r . "," . $customer->gigi->p85l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p75c == $customer->gigi->p75t && $customer->gigi->p75c == $customer->gigi->p75r && $customer->gigi->p75c == $customer->gigi->p75b&& $customer->gigi->p75c == $customer->gigi->p75l)
                    {{ $customer->gigi->p75c }}
                    @else
                    {{ $customer->gigi->p75c . "," . $customer->gigi->p75t . "," . $customer->gigi->p21b. "," . $customer->gigi->p75r . "," . $customer->gigi->p75l }}
                    @endif - @if($customer->gigi->p35c == $customer->gigi->p35t && $customer->gigi->p35c == $customer->gigi->p35r && $customer->gigi->p35c == $customer->gigi->p35b && $customer->gigi->p35c == $customer->gigi->p35l)
                    {{ $customer->gigi->p35c }}
                    @else
                    {{ $customer->gigi->p35c . "," . $customer->gigi->p35t . "," . $customer->gigi->p35b . "," . $customer->gigi->p35r . "," . $customer->gigi->p35l }}
                    @endif
                </td>
                <td width="15%" align="center">[75] 35</td>
            </tr>
            <tr>
                <td width="15%" align="center">44 [84]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p44c == $customer->gigi->p44t && $customer->gigi->p44c == $customer->gigi->p44r && $customer->gigi->p44c == $customer->gigi->p44b && $customer->gigi->p44c == $customer->gigi->p44l)
                    {{ $customer->gigi->p44c }}
                    @else
                    {{ $customer->gigi->p44c . "," . $customer->gigi->p44t . "," . $customer->gigi->p44b . "," . $customer->gigi->p44r . "," . $customer->gigi->p44l }}
                    @endif - @if($customer->gigi->p84c == $customer->gigi->p84t && $customer->gigi->p84c == $customer->gigi->p84r && $customer->gigi->p84c == $customer->gigi->p84b && $customer->gigi->p84c == $customer->gigi->p84l)
                    {{ $customer->gigi->p84c }}
                    @else
                    {{ $customer->gigi->p84c . "," . $customer->gigi->p84t . "," . $customer->gigi->p84b . "," . $customer->gigi->p84r . "," . $customer->gigi->p84l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p74c == $customer->gigi->p74t && $customer->gigi->p74c == $customer->gigi->p74r && $customer->gigi->p74c == $customer->gigi->p74b&& $customer->gigi->p74c == $customer->gigi->p74l)
                    {{ $customer->gigi->p74c }}
                    @else
                    {{ $customer->gigi->p74c . "," . $customer->gigi->p74t . "," . $customer->gigi->p22b. "," . $customer->gigi->p74r . "," . $customer->gigi->p74l }}
                    @endif - @if($customer->gigi->p34c == $customer->gigi->p34t && $customer->gigi->p34c == $customer->gigi->p34r && $customer->gigi->p34c == $customer->gigi->p34b && $customer->gigi->p34c == $customer->gigi->p34l)
                    {{ $customer->gigi->p34c }}
                    @else
                    {{ $customer->gigi->p34c . "," . $customer->gigi->p34t . "," . $customer->gigi->p34b . "," . $customer->gigi->p34r . "," . $customer->gigi->p34l }}
                    @endif
                </td>
                <td width="15%" align="center">[74] 34</td>
            </tr>
            <tr>
                <td width="15%" align="center">43 [83]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p43c == $customer->gigi->p43t && $customer->gigi->p43c == $customer->gigi->p43r && $customer->gigi->p43c == $customer->gigi->p43b && $customer->gigi->p43c == $customer->gigi->p43l)
                    {{ $customer->gigi->p43c }}
                    @else
                    {{ $customer->gigi->p43c . "," . $customer->gigi->p43t . "," . $customer->gigi->p43b . "," . $customer->gigi->p43r . "," . $customer->gigi->p11l }}
                    @endif - @if($customer->gigi->p83c == $customer->gigi->p83t && $customer->gigi->p83c == $customer->gigi->p83r && $customer->gigi->p83c == $customer->gigi->p83b && $customer->gigi->p83c == $customer->gigi->p83l)
                    {{ $customer->gigi->p83c }}
                    @else
                    {{ $customer->gigi->p83c . "," . $customer->gigi->p83t . "," . $customer->gigi->p83b . "," . $customer->gigi->p83r . "," . $customer->gigi->p83l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p73c == $customer->gigi->p73t && $customer->gigi->p73c == $customer->gigi->p73r && $customer->gigi->p73c == $customer->gigi->p73b&& $customer->gigi->p73c == $customer->gigi->p73l)
                    {{ $customer->gigi->p73c }}
                    @else
                    {{ $customer->gigi->p73c . "," . $customer->gigi->p73t . "," . $customer->gigi->p23b. "," . $customer->gigi->p73r . "," . $customer->gigi->p73l }}
                    @endif - @if($customer->gigi->p23c == $customer->gigi->p23t && $customer->gigi->p23c == $customer->gigi->p33r && $customer->gigi->p33c == $customer->gigi->p33b && $customer->gigi->p33c == $customer->gigi->p33l)
                    {{ $customer->gigi->p33c }}
                    @else
                    {{ $customer->gigi->p33c . "," . $customer->gigi->p33t . "," . $customer->gigi->p33b . "," . $customer->gigi->p33r . "," . $customer->gigi->p33l }}
                    @endif
                </td>
                <td width="15%" align="center">[73] 33</td>
            </tr>
            <tr>
                <td width="15%" align="center">42 [82]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p42c == $customer->gigi->p42t && $customer->gigi->p42c == $customer->gigi->p42r && $customer->gigi->p42c == $customer->gigi->p42b && $customer->gigi->p42c == $customer->gigi->p42l)
                    {{ $customer->gigi->p42c }}
                    @else
                    {{ $customer->gigi->p42c . "," . $customer->gigi->p42t . "," . $customer->gigi->p42b . "," . $customer->gigi->p42r . "," . $customer->gigi->p11l }}
                    @endif - @if($customer->gigi->p82c == $customer->gigi->p82t && $customer->gigi->p82c == $customer->gigi->p82r && $customer->gigi->p82c == $customer->gigi->p82b && $customer->gigi->p82c == $customer->gigi->p82l)
                    {{ $customer->gigi->p82c }}
                    @else
                    {{ $customer->gigi->p82c . "," . $customer->gigi->p82t . "," . $customer->gigi->p82b . "," . $customer->gigi->p82r . "," . $customer->gigi->p82l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p72c == $customer->gigi->p72t && $customer->gigi->p72c == $customer->gigi->p72r && $customer->gigi->p72c == $customer->gigi->p72b && $customer->gigi->p72c == $customer->gigi->p72l)
                    {{ $customer->gigi->p72c }}
                    @else
                    {{ $customer->gigi->p72c . "," . $customer->gigi->p72t . "," . $customer->gigi->p24b. "," . $customer->gigi->p72r . "," . $customer->gigi->p72l }}
                    @endif - @if($customer->gigi->p32c == $customer->gigi->p32t && $customer->gigi->p32c == $customer->gigi->p32r && $customer->gigi->p32c == $customer->gigi->p32b && $customer->gigi->p32c == $customer->gigi->p32l)
                    {{ $customer->gigi->p32c }}
                    @else
                    {{ $customer->gigi->p32c . "," . $customer->gigi->p32t . "," . $customer->gigi->p32b . "," . $customer->gigi->p32r . "," . $customer->gigi->p32l }}
                    @endif
                </td>
                <td width="15%" align="center">[72] 32</td>
            </tr>
            <tr>
                <td width="15%" align="center">41 [81]</td>
                <td width="35%" style="padding-left: 10px">@if ($customer->gigi->p41c == $customer->gigi->p41t && $customer->gigi->p41c == $customer->gigi->p41r && $customer->gigi->p41c == $customer->gigi->p41b && $customer->gigi->p41c == $customer->gigi->p41l)
                    {{ $customer->gigi->p41c }}
                    @else
                    {{ $customer->gigi->p41c . "," . $customer->gigi->p41t . "," . $customer->gigi->p41b . "," . $customer->gigi->p41r . "," . $customer->gigi->p41l }}
                    @endif - @if($customer->gigi->p81c == $customer->gigi->p81t && $customer->gigi->p81c == $customer->gigi->p81r && $customer->gigi->p81c == $customer->gigi->p81b && $customer->gigi->p81c == $customer->gigi->p81l)
                    {{ $customer->gigi->p81c }}
                    @else
                    {{ $customer->gigi->p81c . "," . $customer->gigi->p81t . "," . $customer->gigi->p81b . "," . $customer->gigi->p81r . "," . $customer->gigi->p81l }}
                    @endif
                </td>
                <td width="35%" align="right" style="padding-right: 10px">@if($customer->gigi->p71c == $customer->gigi->p71t && $customer->gigi->p71c == $customer->gigi->p71r && $customer->gigi->p71c == $customer->gigi->p71b && $customer->gigi->p71c == $customer->gigi->p71l)
                    {{ $customer->gigi->p71c }}
                    @else
                    {{ $customer->gigi->p71c . "," . $customer->gigi->p71t . "," . $customer->gigi->p25b. "," . $customer->gigi->p71r . "," . $customer->gigi->p71l }}
                    @endif - @if($customer->gigi->p31c == $customer->gigi->p31t && $customer->gigi->p31c == $customer->gigi->p31r && $customer->gigi->p31c == $customer->gigi->p31b && $customer->gigi->p31c == $customer->gigi->p31l)
                    {{ $customer->gigi->p31c }}
                    @else
                    {{ $customer->gigi->p31c . "," . $customer->gigi->p31t . "," . $customer->gigi->p31b . "," . $customer->gigi->p31r . "," . $customer->gigi->p31l }}
                    @endif
                </td>
                <td width="15%" align="center">[71] 31</td>
            </tr>
        </table><br>

        <table>
            <tr>
                <td>Occlusi</td>
                <td>:</td>
                <td>{{ $customer->ketodonto->occlusi ? $customer->ketodonto->occlusi : '' }}</td>
                <td>-</td>
                <td>{{ $customer->ketodonto->ket_occlusi ? $customer->ketodonto->ket_occlusi : '' }}</td>
            </tr>
            <tr>
                <td>Torus Palatinus</td>
                <td>:</td>
                <td>{{ $customer->ketodonto->t_palatinus ? $customer->ketodonto->t_palatinus : '' }}</td>
                <td>-</td>
                <td>{{ $customer->ketodonto->ket_tp ? $customer->ketodonto->ket_tp : '' }}</td>
            </tr>
            <tr>
                <td>Torus Mandibularis</td>
                <td>:</td>
                <td>{{ $customer->ketodonto->t_mandibularis ? $customer->ketodonto->t_mandibularis : '' }}</td>
                <td>-</td>
                <td>{{ $customer->ketodonto->ket_tm ? $customer->ketodonto->ket_tm : '' }}</td>
            </tr>
            <tr>
                <td>Palatum</td>
                <td>:</td>
                <td>{{ $customer->ketodonto->palatum ? $customer->ketodonto->palatum : '' }}</td>
                <td>-</td>
                <td>{{ $customer->ketodonto->ket_palatum ? $customer->ketodonto->ket_palatum : '' }}</td>
            </tr>
            <tr>
                <td>Diastema</td>
                <td>:</td>
                <td>{{ $customer->ketodonto->diastema ? $customer->ketodonto->diastema : '' }}</td>
                <td>-</td>
                <td>{{ $customer->ketodonto->ket_diastema ? $customer->ketodonto->ket_diastema : '' }}</td>
            </tr>
            <tr>
                <td>Gigi Anomali</td>
                <td>:</td>
                <td>{{ $customer->ketodonto->anomali ? $customer->ketodonto->anomali : '' }}</td>
                <td>-</td>
                <td>{{ $customer->ketodonto->ket_anomali ? $customer->ketodonto->ket_anomali : '' }}</td>
            </tr>
            <tr>
                <td>Lain - Lain</td>
                <td>:</td>
                <td>{{ $customer->ketodonto->lain ? $customer->ketodonto->lain : '' }}</td>
            </tr>
            <tr>
                <td>D : ..... M : ..... F : .....</td>
            </tr>
        </table><br>

        Jumlah photo yang diambil ............. (digital/intraoral)*
        <br>
        Jumlah rontgen photo yang diambil ............. (Dental/PA/OPG/Ceph)*

        <div style="margin-top:20px;border:1px solid black">
            <table width="100%">
                <tr>
                    <td align="center" width="30%"><strong>Diperiksa Oleh</strong></td>
                    <td align="center" width="30%"><strong>Tanggal Pemeriksaan</strong></td>
                    <td align="center" width="30%"><strong>Tanda Tangan Pemeriksa</strong></td>
                </tr>
                <tr>
                    <td><br></td>
                    <td><br></td>
                    <td><br></td>
                </tr>
                <tr>
                    <td align="center" width="30%">{{ auth()->user()->name }}</td>
                    <td align="center" width="30%">{{ date('d/m/Y') }}</td>
                    <td align="center" width="30%">.............</td>
                </tr>
            </table>
        </div>

    </section>


</body>
@stop