  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <ul>
      <br>
      <br>
      <br>
      @php
          $id = auth()->user()->id;
          $detail = DB::table('detail_users')
              ->where('userid', $id)
              ->first();
          $aktif = DB::table('detail_users')
              ->join('users', 'detail_users.userid', '=', 'users.id')
              ->join('model_has_roles', 'detail_users.userid', '=', 'model_has_roles.model_id')
              ->where('detail_users.status_kta', 1)
              ->where('detail_users.provinsi_domisili', $detail->provinsi_domisili)
              ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
              ->groupBy('detail_users.nik')
              ->get()
              ->count();
          
       $user = DB::table('users')->leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'detail_users.kabupaten_domisili')
                    ->leftJoin('provinsis', 'provinsis.id_prov', '=', 'detail_users.provinsi_domisili')
                    ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->select('users.super_admin', 'detail_users.id', 'users.username', 'provinsis.name as nama', 'users.name', 'users.email', 'users.phone_number', 'roles.key', 'detail_users.provinsi_domisili', 'detail_users.no_member')
                    ->where('detail_users.status_kta', 1)
                    ->whereIn('model_has_roles.role_id', array(11,4))
                    ->where('users.username', '!=', '')
                    ->where('provinsis.id_prov', $detail->provinsi_domisili)
                    ->orderBy('detail_users.id', 'desc')
                    ->groupBy('detail_users.id')
                    ->get()
              ->count();
      @endphp
      <li class="{{ request()->is('dashboard*') }}">
          <a style="color:#FFF9F9;" href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
      </li>
      <li class="{{ request()->is('dpd/member*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.member.index') }}"><i class="fa-solid fa-users"></i><span>Daftar
                  Anggota</span><span class="badge">{{ $aktif }}</span></a>
      </li>
      <li class="submenu">
          <a style="color:#FFF9F9;" href="#" class=""><i class="fa-solid fa-users"></i><span> Rekap
                  Kepengurusan
              </span> <span class="menu-arrow"></span></a>
          <ul style="display: none;">
              <li class="{{ request()->is('rekap/dpc*') }}">
                  <a style="color:#00000;" href="{{ route('dpd.rekap.dpc') }}"><span>DPC</span></a>
              </li>
              <li class="{{ request()->is('rekap/pac*') }}">
                  <a style="color:#00000;" href="{{ route('dpd.rekap.pac.single') }}"><span>PAC</span></a>
              </li>
              
     
              
              <li class="{{ request()->is('dpd/pengurus*') }}">
              <a style="color:#00000;" href="{{ route('dpd.pengurus.index') }}"><span>KONTAK</span></a>
              </li>
              
          </ul>
      </li>
      <li class="{{ request()->is('dpd/provinsi*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.provinsi.index') }}"><i class="fa-solid fa-users"
                  aria-hidden="true"></i>
              <span>Provinsi</span></a>
      </li>
      <li class="{{ request()->is('dpd/kabupaten*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.kabupaten.index') }}"><i
                  class="fa-solid fa-users"></i><span>Kabupaten /
                  Kota</span></a>
      </li>

      <li class="{{ request()->is('dpd/kecamatan*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.kecamatan.index') }}"><i
                  class="fa-solid fa-users"></i><span>Kecamatan</span></a>
      </li>
      <li class="{{ request()->is('dpd/kelurahan*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.kelurahan.index') }}"><i
                  class="fa-solid fa-users"></i><span>Kel / Desa</span></a>
      </li>
      <li class="{{ request()->is('dpd/penghubung*') }}">
          <a style="color:#FFF9F9;" href="/dpd/penghubung"><i class="fa-solid fa-users"></i><span>Petugas
                  Penghubung</span></a>
      </li>
      <li class="{{ request()->is('dpd/listuser*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.listuser.index') }}"><i
                  class="fa-solid fa-users"></i><span>List User</span><span
                  class="badge">{{ $user }}</span></a></a>
      </li>
      <li class="{{ request()->is('dpd/informasi*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.informasi.index') }}"><i
                  class="fa-solid fa-circle-info"></i><span>Informasi</span></a>
      </li>
      <!-- <li  class="submenu">-->
      <!--    <a style="color:#FFF9F9;" href="#" class=""><i class="fa-solid fa-users"></i><span> Master Anggota </span> <span-->
      <!--            class="menu-arrow"></span></a>-->
      <!--    <ul style="display: none;">-->

      <!--        <li class="{{ request()->is('dpd/pending*') }}">-->
      <!--            <a  style="color:#00000;" href="{{ route('dpd.pending.index') }}"><span>Pengesahan Anggota</span></a>-->
      <!--        </li>-->
      <!--        <li class="{{ request()->is('dpd/pembatalan*') }}">-->
      <!--            <a  style="color:#00000;" href="{{ route('dpd.pembatalan.index') }}"><span>Pembatalan Anggota</span></a>-->
      <!--        </li>-->
      <!--        <li class="{{ request()->is('dpd/repair*') }}">-->
      <!--            <a  style="color:#00000;" href="{{ route('dpd.repair.index') }}"><span>Data Anggota Diperbaiki</span></a>-->
      <!--        </li>-->
      <!--        <li class="{{ request()->is('dpd/restore*') }}">-->
      <!--            <a  style="color:#00000;" href="{{ route('dpd.restore.index') }}"><span>Data Anggota Terhapus</span></a>-->
      <!--        </li>-->
      <!--    </ul>-->
      <!--</li>-->

      <li class="{{ request()->is('dpd/user*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.user.index') }}"><i
                  class="fa-solid fa-users"></i><span>Profil DPD</span></a>
      </li>
      

      <li class="{{ request()->is('dpd/log_activity*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpd.log_activity.index') }}"><i
                  class="fa-solid fa-file-invoice"></i><span>Log Activity</span></a>
      </li>
  </ul>
