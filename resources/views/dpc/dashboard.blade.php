<div class="row">
    <div class="col-md-12">
        <h1 class="page-title" style="font-weight:bold;">Dashboard DPC : {{$kab->name}}</h1>
      
    </div>
</div>
<style>
    .panel-blink>.panel-heading {

        color: #fff;
        border-radius: 4px;
        text-align: center;
        font-size: 15px;
        background-color:
            #fe0000;
        border-color: #0000;
        animation: blinkingBackground 2s infinite;
    }

    @keyframes blinkingBackground {
        0% {
            background-color: #10c018;
        }

        25% {
            background-color: #1056c0;
        }

        50% {
            background-color: #ef0a1a;
        }

        75% {
            background-color: #254878;
        }

        100% {
            background-color: #04a1d5;
        }
    }
</style>
<div class="row">
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>TOTAL ANGGOTA</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> {{ $total_anggota }} </h1>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        @if($total_anggota < ($target->target_dpc ?? ''))
            <div class="panel panel-blink">
                <div class="panel-heading"style="background-color:#DC8E08;"><label>TARGET ANGGOTA</label></div>
                <div class="panel-bodybg2" style="text-align:center;">
                    <h1> {{ $target->target_dpc ?? '0' }} </h1>
                </div>
            </div>
            @else
            <div class="panel panel-green">
                <div class="panel-heading"style="background-color:#DC8E08;"><label>TARGET ANGGOTA</label></div>
                <div class="panel-bodybg2" style="text-align:center;">
                    <h1> {{ $target->target_dpc ?? '0' }} </h1>
                </div>
            </div>
            @endif
    </div>
    @php
    $target = $target->target_dpc ?? '0' ;
    $total = $target - $total_anggota;
    @endphp
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        @if($total > 0)
        <div class="panel panel-blink">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>SISA TARGET ANGGOTA</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> {{ $total}}</h1>
            </div>
        </div>
        @else
        <div class="panel panel-green">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>SISA TARGET ANGGOTA</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> {{ $total ? '0' : '0' }} </h1>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>ANGGOTA PENDING DPC</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> {{ $hrd_pending }} </h1>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        @if($total > 0)
        <div class="panel panel-blink">
            <div class="panel-heading"><label>PRESENTASE SISA TARGET ANGGOTA</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> @if (!empty($target))
                    {{ round( $total * 120/ $target) }}% 
                     @endif
                </h1>
            </div>
        </div>
        @else
        <div class="panel panel-green">
            <div class="panel-heading"><label>PRESENTASE SISA TARGET ANGGOTA</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1>  @if (!empty($target))
                    0%
                    @else
                    0%
                    @endif
                </h1>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        @if($total > 0)
        <div class="panel panel-blink">
            <div class="panel-heading"><label>PRESENTASE PENCAPAIAN TARGET ANGGOTA</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> @if (!empty($target))
                    {{ round( $total_anggota * 120/ $target) }}% 
                     @endif
                </h1>
            </div>
        </div>
        @else
        <div class="panel panel-green">
            <div class="panel-heading"><label>PRESENTASE PENCAPAIAN TARGET ANGGOTA</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1>  @if (!empty($target))
                    100%
                    @else
                    0%
                    @endif
                </h1>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>ANGGOTA PEREMPUAN</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> {{ $perempuan }} </h1>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>ANGGOTA LAKI-LAKI</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> {{ $laki }} </h1>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>TOTAL USER</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> {{ $total_user }} </h1>
            </div>
        </div>
    </div>

</div>
   
 @if ( $target ==  0)
<div class="row">
    <div class="col-sm-6 col-sg-4 m-b-4">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
           <a style="font-weight:bold;" href="https://www.hanura.net/dpd/kabupaten/{{$detail->kabupaten_domisili}}/kantor">BELUM MENGISI TARGET ANGGOTA DPC</a>
        </div>
    </div>

</div>
@else

@endif

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
    <div class="col-md-2 col-sm-2 col-lg-2 col-xl-2">
        @foreach($penguruspusat as $data)
        <div class="panel panel-orange">
            <div class="panel-heading" style="background-color:#DC8E08;"><label>
                    <h5>{{$data->nama}}</h5>
                </label></div>
            <div class="panel-bodybg2" style="text-align:center; "> <br>
                <div class='click-zoom'>
                    <label>
                        <input type='checkbox'>
                        <img src="{{asset('uploads/img/foto_kepengurusan/'.$data->foto)}}" class="img img-responsive"
                            alt='noimage'>
                        {{$data->name}}
                    </label>
                </div>

            </div>
        </div>
        @endforeach
    </div>
    <div class="col-md-10 col-sm-10 col-lg-10 col-xl-10">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>
                    <h5>Selamat Datang Di Sistem Informasi Keanggotaan Partai Hanura</h5>
                </label></div>
            <div class="panel-bodybg2" style="text-align:justify;"> <br>


                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingATAS">
                            <h5 class="mb-0">
                                <button class="btn btn-link" style="color:#DC8E08;" data-toggle="collapse"
                                    data-target="#collapseatas" aria-expanded="true" aria-controls="collapseatas">
                                    PEMBUKAAN
                                </button>
                            </h5>
                        </div>
                        <div id="collapseatas" class="collapse show" aria-labelledby="headingATAS"
                            data-parent="#accordion">
                            <div class="card-body">

                                <blockquote>
                                    Guna mendukung pendaftaran dan verifikasi partai politik yang
                                    akan dimulai
                                    pada tanggal 1 Agustus 2022, kami menyediakan fasilitas sistem informasi yang
                                    digunakan untuk mendukung DPC Kabupaten / kota dalam melakukan pendataan keanggotaan
                                    di setiap wilayah.
                                    Dalam sistem informasi keanggotan partai Hanura ini, terbagi menjadi 2 bagian
                                    prosedur yang akan
                                    didukung oleh 2 aplikasi yang terintegrasi yang terdiri dari 2 platform.

                                </blockquote>

                            </div>
                        </div>
                    </div>



                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" style="color:#DC8E08;" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        PLATFORM : ANDROID
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <blockquote>
                                        Aplikasi pertama adalah APLIKASI ANDROID KEANGGOTAAN yang berbasis android dan
                                        dilaksanakan
                                        serta digunakan untuk menginput dan mengupload data-data dari KTP melalui
                                        handphone untuk disimpan
                                        di server aplikasi KTA, sehingga memudahkan pengurus DPC dalam merekrut anggota
                                        secara mobile.
                                    </blockquote>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" style="color:#DC8E08;" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        PLATFORM WEB
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <blockquote>
                                        Sedangkan APLIKASI WEB KEANGGOTAAN yang berbasis windows dan dilaksanakan serta
                                        digunakan
                                        untuk mengambil data dari server aplikasi KTA untuk kemudian diolah untuk
                                        pembuatan KTA partai Hanura.
                                        Aplikasi web keanggotaan ini akan memproduksi data dan dokumen sbb: <p></p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>



                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"
                                        style="color:#DC8E08;">
                                        OUTPUT SISTEM INFORMASI
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <blockquote>
                                        <ol>
                                            <li>Kartu Tanda Anggota (KTA) di media blanko kertas </li>
                                            <li>Kartu Tanda Anggota (KTA) di media kartu plastik.</li>
                                            <li>Daftar dan Alamat Anggota Parpol Dalam Wilayah Kab/Kota (MODEL
                                                F2-PARPOL/untuk KPU) beserta
                                                Hasil Perbaikan-nya.</li>
                                            <li>Rekapitulasi Jumlah Anggota Parpol Dalam Wilayah Kab/Kota (MODEL
                                                F2-PARPOL/untuk KPU) berserta
                                                Hasil Perbaikan-nya.</li>
                                            <li>Daftar/List image KTA + KTP (untuk KPUD)</li>
                                            <li>File KTA dalam template dengan format excel, data keanggotaan Sipol).
                                            </li>
                                            <li>Dalam halaman-halaman berikut-nya akan ditampilkan data flow dalam
                                                sistem informasi keanggotaan partai
                                                Hanura.</li>
                                        </ol>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                </div>
            </div>
        </div>

    </div>
</div>