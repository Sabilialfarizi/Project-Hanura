<div class="row">
    <div class="col-md-12">
        <h1 class="page-title">Dashboard | Selamat Datang di Dewan Pimpinan Pusat Partai Hanura</h1>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xl-12">
        <div class="panel panel-orange" >
            <div class="panel-heading" style="background-color:#DC8E08;">
                <label>Persebaran Anggota</label>
            </div>
            <div class="panel-default">
                <div class="wraper-map">
                    <div class="map">
                        <span>Alternative content for the map</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;">
                <label>Range Umur</label>
            </div>
            <div class="panel-default">
                <canvas id="speedCanvas" height="280" width="600"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xl-6">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;">
                <label>Pertumbuhan Anggota</label>
            </div>
            <div class="panel-default">
                <canvas id="canvas" height="280" width="600"></canvas>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>ANGGOTA PENDING</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1>{{ $hrd_pending }} </h1>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>ANGGOTA PEREMPUAN</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1>{{ $perempuan }}</h1>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>ANGGOTA LAKI-LAKI</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1>{{ $laki }} </h1>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>TOTAL ANGGOTA</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                @php 
                $total_all = $total_anggota - 1;
                @endphp
                <h1>{{ $total_all }}</h1>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>TOTAL USER</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1>{{ $total_user }}</h1>
            </div>
        </div>
    </div>
    @php
    $dbDate = \Carbon\Carbon::parse('2022-06-20');
    $diffYears = Carbon\Carbon::now()->diffInDays($dbDate);
 
    @endphp
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>Released 20 June 2022</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1>{{$diffYears}} Days</h1>
            </div>
        </div>
    </div>

    
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading" style="background-color:#DC8E08;"><label>PROVINSI</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1>{{ $provinsi }}</h1>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-lg-3 col-xl-3">
        <div class="panel panel-orange">
            <div class="panel-heading"style="background-color:#DC8E08;"><label>KABUPATEN</label></div>
            <div class="panel-bodybg2" style="text-align:center;">
                <h1> {{ $kabupatens }} </h1>
            </div>
        </div>
    </div>
</div>
<style>
    .mapael .map {
        position: relative;
    }

    .mapael .mapTooltip {
        position: absolute;
        background-color: #fff;
        moz-opacity: 0.70;
        opacity: 0.70;
        filter: alpha(opacity=70);
        border-radius: 10px;
        padding: 10px;
        z-index: 1000;
        max-width: 200px;
        display: none;
        color: #343434;
    }

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js" charset="utf-8">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script>
<script src="{{ asset('/') }}js/jquery.mousewheel.min.js" charset="utf-8"></script>
<script src="{{ asset('/') }}js/raphael.min.js" charset="utf-8"></script>
<script src="{{ asset('/') }}js/jquery.mapael.js" charset="utf-8"></script>
<script src="{{ asset('/') }}js/indonesia/indonesia.js"></script>
<script src="{{ asset('/') }}js/indonesia.min.js"></script>
<script src="{{ asset('/') }}js/maps/world_countries.js"></script>
<script src="{{ asset('/') }}node_modules/jquery-mapael/js/maps/world_countries.js"></script>
<script src="{{ asset('/') }}node_modules/jquery-mapael/js/maps/indonesia.js"></script>
<script src="{{ asset('/') }}node_modules/jquery-mapael/js/maps/world_countries.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    var year = <?php echo $year; ?> ;
    var user = <?php echo $user; ?> ;
    var barChartData = {
        labels: year,
        datasets: [{
            label: 'Jumlah',
            backgroundColor: "#D6A62C",
            data: user
        }]
    };


    window.onload = function () {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                scales: {
                    yAxes: {
                        ticks:{
                        beginAtZero: true
                        }
                    },
                },
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                // title: {
                //     display: true,
                //     text: 'Jumlah'
                // }
            }
        });
    };
    
    var usiaa = <?php echo json_encode($jumlahBerdasarkanUsia1); ?>;
    var usiab = <?php echo json_encode($jumlahBerdasarkanUsia2); ?>;
    var usiac = <?php echo json_encode($jumlahBerdasarkanUsia3); ?>;
    var usiad = <?php echo json_encode($jumlahBerdasarkanUsia4); ?>;
    var usiae = <?php echo json_encode($jumlahBerdasarkanUsia5); ?>;
    var usiaf = <?php echo json_encode($jumlahBerdasarkanUsia6); ?>;

    var jumlah = <?php echo $jumlahusia; ?> ;
    var ctx1 = document.getElementById("speedCanvas").getContext('2d');
    var myChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: jumlah,
            datasets : [{
                label: 'Jumlah',
                backgroundColor: "#D6A62C",
                data: [ usiaa,usiab,usiac,usiad,usiae,usiaf]
            }],
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                },
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                // title: {
                //     display: true,
                //     text: 'Jumlah'
                // }
            }
        }
    });

</script>




<script type="text/javascript">
    $(".wraper-map").mapael({
        map: {
            name: "indonesia",
            defaultArea: {
                attrs: {
                    stroke: "#fff",
                    "stroke-width": 0.5
                },
                attrsHover: {
                    "stroke-width": 1
                }
            }
        },
        areas: {
            "ID-AC": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Aceh</span><br />Anggota : {{$aceh}}"
                }
            },
            "ID-BA": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Bali</span><br />Anggota : {{ $bali }}"
                }
            },
            "ID-BB": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Kepulauan Bangka Belitung</span><br />Anggota : {{ $kepbangbel }}"
                }
            },
            "ID-BE": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Bengkulu</span><br />Anggota : {{ $bengkulu }}"
                }
            },
            "ID-BT": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Banten</span><br />Anggota : {{ $banten }}"
                }
            },
            "ID-GO": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Gorontalo</span><br />Anggota : {{$gorontalo}}"
                }
            },
            "ID-JA": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Jambi</span><br />Anggota : {{ $jambi }}"
                }
            },
            "ID-JB": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Jawa Barat</span><br />Anggota : {{ $jabar }}"
                }
            },
            "ID-JI": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Jawa Timur</span><br />Anggota : {{ $jatim }}"
                }
            },
            "ID-JK": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">DKI Jakarta</span><br />Anggota : {{$dki}}"
                }
            },
            "ID-JT": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Jawa Tengah</span><br />Anggota : {{$jateng}}"
                }
            },
            "ID-KB": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Kalimantan Barat</span><br />Anggota : {{$kalbar}}"
                }
            },
            "ID-KI": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Kalimantan Timur</span><br />Anggota : {{$kaltim}}"
                }
            },
            "ID-KR": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Kepulauan Riau</span><br />Anggota : {{$kepri}}"
                }
            },
            "ID-KS": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Kalimantan Selatan</span><br />Anggota : {{$kalsel}}"
                }
            },
            "ID-KT": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Kalimantan Tengah</span><br />Anggota : {{$kalteng}}"
                }
            },
            "ID-KU": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Kalimantan Utara</span><br />Anggota : {{$kalut}}"
                }
            },
            "ID-LA": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Lampung</span><br />Anggota : {{$lampung}}"
                }
            },
            "ID-MA": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Maluku</span><br />Anggota : {{$maluku}}"
                }
            },
            "ID-MU": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Maluku Utara</span><br />Anggota : {{$malukuut}}"
                }
            },
            "ID-NB": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Nusa Tenggara Barat</span><br />Anggota : {{$ntb}}"
                }
            },
            "ID-NT": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Nusa Tenggara Timur</span><br />Anggota : {{$ntt}}"
                }
            },
            "ID-PA": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Papua</span><br />Anggota : {{$papuabar}}"
                }
            },
            "ID-PB": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Papua Barat</span><br />Anggota : {{$papua}}"
                }
            },
            "ID-RI": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Riau</span><br />Anggota : {{$riau}}"
                }
            },
            "ID-SA": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Sulawesi Utara</span><br />Anggota : {{$sulut}}"
                }
            },
            "ID-SB": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Sumatera Barat</span><br />Anggota : {{$sumbar}}"
                }
            },
            "ID-SG": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Sulawesi Tenggara</span><br />Anggota : {{$sulgar}}"
                }
            },
            "ID-SN": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Sulawesi Selatan</span><br />Anggota : {{$sulsel}}"
                }
            },
            "ID-SR": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Sulawesi Barat</span><br />Anggota : {{$sulbar}}"
                }
            },
            "ID-SS": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Sumatera Selatan</span><br />Anggota : {{$sumsel}}"
                }
            },
            "ID-ST": {
                value: "0",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Sulawesi Tengah</span><br />Anggota : {{$sulteng}}"
                }
            },
            "ID-SU": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">Sumatera Utara</span><br />Anggota : {{$sumut}}"
                }
            },
            "ID-YO": {
                value: "7",
                href: "#",
                tooltip: {
                    content: "<span style=\"font-weight:bold;\">DI Yogyakarta</span><br />Anggota : {{$diy}}"
                }
            },
        }
    });

</script>
