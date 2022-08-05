<ul>
    @php
        $id = auth()->user()->id;
        $detail = DB::table('detail_users')
            ->where('userid', $id)
            ->first();
        $pengesahan = DB::table('detail_users')
            ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->where('detail_users.status_kta', 0)
            ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
            ->groupBy('detail_users.nik')
            ->get()
            ->count();
        
        $pembatalan = DB::table('detail_users')
            ->join('pembatalan_anggota', 'detail_users.id', '=', 'pembatalan_anggota.id_anggota')
            ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->where('detail_users.status_kta', 3)
            ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
            ->groupBy('pembatalan_anggota.id')
            ->get()
            ->count();
        
        $repair = DB::table('detail_users')
            ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->join('pembatalan_anggota', 'detail_users.id', '=', 'pembatalan_anggota.id_anggota')
            ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
            ->where('detail_users.status_kta', 2)
            ->orderBy('detail_users.id', 'desc')
            ->groupBy('pembatalan_anggota.id')
            ->get()
            ->count();
        
        $restore = DB::table('detail_users')
            ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
            ->where('detail_users.status_kta', 4)
            ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
            ->groupBy('detail_users.nik')
            ->get()
            ->count();
        
   
     
            
            $total_anggota = DB::table('detail_users')
              ->join('users','detail_users.userid','=','users.id')
              ->join('model_has_roles','users.id','=','model_has_roles.model_id')
              ->where('detail_users.status_kta',1)
              ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
             ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
              ->groupBy('detail_users.nik')
              ->get()
              ->count();
              
            $user1 = DB::table('detail_users')
              ->join('users','detail_users.userid','=','users.id')
              ->join('model_has_roles','users.id','=','model_has_roles.model_id')
              ->where('detail_users.status_kta',1)
              ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
              ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
              ->where('detail_users.status_kpu', 1)
              ->groupBy( 'detail_users.nik')
              ->get()
              ->count();
        
        $user = DB::table('users')
            ->leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'detail_users.kabupaten_domisili')
            ->where('detail_users.kabupaten_domisili', $detail->kabupaten_domisili)
            ->whereIn('model_has_roles.role_id', array(4,5))
            ->where('users.username', '!=', '')
            ->where('detail_users.status_kta', 1)
           ->groupBy( 'detail_users.nik')
            ->get()
            ->count();
        
        $target = DB::table('kantor')
            ->where('id_daerah', $detail->kabupaten_domisili)
            ->first();
    @endphp
    <br>
    <br>
    <br>
    <style>
        /*.led-box {*/
        /*    height: 30px;*/
        /*    width: 25%;*/
        /*    margin: 10px 0;*/
        /*    float: left;*/
        /*}*/

        /*.led-box p {*/
        /*    font-size: 12px;*/
        /*    text-align: center;*/
        /*    margin: 1em;*/
        /*}*/

        .led-red {
            margin: 0 auto;
            width: 14px;
            height: 14px;
            background-color: #F00;
            border-radius: 50%;
            box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 12px;
            -webkit-animation: blinkRed 0.5s infinite;
            -moz-animation: blinkRed 0.5s infinite;
            -ms-animation: blinkRed 0.5s infinite;
            -o-animation: blinkRed 0.5s infinite;
            animation: blinkRed 0.5s infinite;
        }

        @-webkit-keyframes blinkRed {
            from {
                background-color: #F00;
            }

            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }

            to {
                background-color: #F00;
            }
        }

        @-moz-keyframes blinkRed {
            from {
                background-color: #F00;
            }

            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }

            to {
                background-color: #F00;
            }
        }

        @-ms-keyframes blinkRed {
            from {
                background-color: #F00;
            }

            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }

            to {
                background-color: #F00;
            }
        }

        @-o-keyframes blinkRed {
            from {
                background-color: #F00;
            }

            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }

            to {
                background-color: #F00;
            }
        }

        @keyframes blinkRed {
            from {
                background-color: #F00;
            }

            50% {
                background-color: #A00;
                box-shadow: rgba(0, 0, 0, 0.2) 0 -1px 7px 1px, inset #441313 0 -1px 9px, rgba(255, 0, 0, 0.5) 0 2px 0;
            }

            to {
                background-color: #F00;
            }
        }
    </style>
    @if ($total_anggota < ($target->target_dpc ?? ''))
        <li class="{{ request()->is('dashboard*') }}">
            <a style="color:#FFF9F9;" href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
                <span style="margin-left:62px;" class="badge">
                    <div class="led-red"></div>
                </span>
            </a>
        </li>
    @else
        <li class="{{ request()->is('dashboard*') }}">
            <a style="color:#FFF9F9;" href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
    @endif



    <li class="submenu">
        <a style="color:#FFF9F9;" href="#" class=""><i class="fa-solid fa-users"></i><span> Daftar Anggota
            </span>
            <span class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li class="{{ request()->is('dpc/kabupaten*') }}">
                <a style="color:#00000;" href="{{ route('dpc.member.create') }}">
                    <span>Input Anggota</span></a>
            </li>

            <li class="{{ request()->is('dpc/member*') }}">

                <a style="color:#00000;" href="{{ route('dpc.member.index') }}">
                    <span>Untuk KPU</span><span style="margin-left:52px;" class="badge">{{ $user1 }}</span></a>
            </li>

            <li class="{{ request()->is('dpc/kabupaten*') }}">
                <a style="color:#00000;" href="{{ route('dpc.kabupaten.index') }}">
                    <span>Untuk Internal</span><span style="margin-left:32px;"
                        class="badge">{{ $total_anggota }}</span></a>
            </li> 
            <li class="{{ request()->is('dpc/member*') }}">
                <a style="color:#00000;" href="{{ route('dpc.member.cetak_kta') }}">
                    <span>Cetak Kartu</span><span style="margin-left:48px;"
                        class="badge">{{ $total_anggota }}</span></a>
            </li> 
            
            <!-- 
            <li class="{{ request()->is('dpc/listingKTP*') }}">
                <a style="color:#00000;" href="{{ route('dpc.listingKTP.index') }}">
                    <span>Listing KTP</span><span style="margin-left:50px;"
                        class="badge">{{ $total_anggota }}</span></a>
            </li> 
             
         
            
       

            <li class="{{ request()->is('dpc/import/anggota*') }}">
                <a style="color:#00000;" href="{{ route('dpc.import.anggota') }}">
                    <span>Import Anggota</span></a>
            </li>
            
           -->
             
        




        </ul>
    </li>
    <li class="submenu">
        <a style="color:#FFF9F9;" href="#" class=""><i class="fa-solid fa-users"></i><span> Manajemen
                Anggota
            </span>
            <span class="menu-arrow"></span></a>
        <ul style="display: none;">

            <li class="{{ request()->is('dpc/pending*') }}">

                <a style="color:#00000;" href="{{ route('dpc.pending.index') }}">Pengesahan Anggota<span
                        style="margin-left:12px;" class="badge badge-light" cellspacing="15">
                        {{ $pengesahan }}</span></a>
            </li>
            <li class="{{ request()->is('dpc/pembatalan*') }}">
                <a style="color:#00000;" href="{{ route('dpc.pembatalan.index') }}"><span>Pembatalan
                        Anggota</span><span style="margin-left:12px;" class="badge">{{ $pembatalan }}</span></a>
            </li>
            <li class="{{ request()->is('dpc/repair*') }}">
                <a style="color:#00000;" href="{{ route('dpc.repair.index') }}">Perbaikan Anggota<span
                        style="margin-left:22px;" class="badge">{{ $repair }}</span></a>
            </li>
            <li class="{{ request()->is('dpc/restore*') }}">
                <a style="color:#00000;" href="{{ route('dpc.restore.index') }}">Data Terhapus<span
                        style="margin-left:50px;" class="badge">{{ $restore }}</span></a>
            </li>
        </ul>
    </li>

    <li class="{{ request()->is('dpc/kecamatan*') }}">
        <a style="color:#FFF9F9;" href="{{ route('dpc.kecamatan.index') }}"><i
                class="fa-solid fa-users"></i><span>Kecamatan</span></a>
    </li>
    <li class="{{ request()->is('dpc/kelurahan*') }}">
        <a style="color:#FFF9F9;" href="{{ route('dpc.kelurahan.index') }}"><i
                class="fa-solid fa-users"></i><span>Kel
                / Desa</span></a>
    </li>
     <li class="{{ request()->is('dpc/penghubung*') }}">
        <a style="color:#FFF9F9;" href="{{route('dpc.penghubung.index')}}"><i
                class="fa-solid fa-users"></i><span>Petugas Penghubung</span></a>
    </li>
    <!--<li class="{{ request()->is('dpp/provinsi*') }}">-->
    <!--    <a style="color:#FFF9F9;" href="{{ route('dpc.provinsi.index') }}"><i class="fa-solid fa-users"-->
    <!--            aria-hidden="true"></i>-->
    <!--        <span>Rekapitulasi Anggota</span></a>-->
    <!--</li>	-->
    <li class="{{ request()->is('dpc/exports*') }}">
					<a style="color:#FFF9F9;" href="{{ route('dpc.exports.index') }}"><i class="fa-solid fa-print"></i><span>Export</span></a>
				</li>
    <li class="{{ request()->is('dpc/listuser*') }}">
        <a style="color:#FFF9F9;" href="{{ route('dpc.listuser.index') }}"><i
                class="fa-solid fa-users"></i><span>List
                User</span><span class="badge">{{ $user }}</span></a>
    </li>
    <li class="{{ request()->is('dpc/informasi*') }}">
        <a style="color:#FFF9F9;" href="{{ route('dpc.informasi.index') }}"><i
                class="fa-solid fa-circle-info"></i><span>Informasi</span></a>
    </li>



    <li class="{{ request()->is('dpc/user*') }}">
        <a style="color:#FFF9F9;" href="{{ route('dpc.user.index') }}"><i class="fa-solid fa-users"></i><span>Profil
                DPC</span></a>
    </li>
    <li class="{{ request()->is('dpc/pengurus*') }}">
        <a style="color:#FFF9F9;" href="{{ route('dpc.pengurus.index') }}"><i
                class="fa-solid fa-users"></i><span>Kepengurusan</span></a>
    </li>

    <li class="{{ request()->is('dpc/log_activity*') }}">
        <a style="color:#FFF9F9;" href="{{ route('dpc.log_activity.index') }}"><i
                class="fa-solid fa-file-invoice"></i><span>Log Activity</span></a>
    </li>
</ul>
