  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <ul>
      <br>
      <br>
      <br>
      @php
          $user = DB::table('users')
              ->leftJoin('detail_users', 'users.id', '=', 'detail_users.userid')
              ->where('users.username', '!=', '')
              ->where('users.generated_dpp',0)
              ->where('detail_users.status_kta', 1)
              ->groupBy('detail_users.id')
              ->get()
              ->count();
      @endphp
      <li class="{{ request()->is('dashboard*') }}">
          <a style="color:#FFF9F9;" href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
      </li>
      <li class="{{ request()->is('dpp/provinsi*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpp.provinsi.index') }}"><i class="fa-solid fa-users"
                  aria-hidden="true"></i>
              <span>Rekapitulasi Anggota</span></a>
      </li>
      <li class="submenu">
          <a style="color:#FFF9F9;" href="#" class=""><i class="fa-solid fa-users"></i><span> Rekap
                  Kepengurusan
              </span> <span class="menu-arrow"></span></a>
          <ul style="display: none;">
              <li class="{{ request()->is('rekap/dpd*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.rekap.dpd') }}"><span>DPD</span></a>
              </li>
              <li class="{{ request()->is('rekap/dpc*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.rekap.dpc.single') }}"><span>DPC</span></a>
              </li>
              <li class="{{ request()->is('rekap/pac*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.rekap.pac.single') }}"><span>PAC</span></a>
              </li>
              
               <!--
              <li class="{{ request()->is('list/dpc*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.list.dpc') }}"><span>Rekap Angg &amp; Org</span></a>
              </li>
              -->
          </ul>
      </li>

      <!--<li   class="{{ request()->is('dpp/kabupaten*') }}">-->
      <!--    <a style="color:#FFF9F9;" href="{{ route('dpp.kabupaten.index') }}"><i class="fa-solid fa-users"></i><span>Daftar Anggota</span></a>-->
      <!--</li>-->


      <li class="{{ request()->is('dpp/user*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpp.user.index') }}"><i
                  class="fa-solid fa-users"></i><span>User</span><span class="badge">{{ $user }}</span></a>
      </li>
      <li class="submenu">
          <a style="color:#FFF9F9;" href="#" class=""><i class="fa-solid fa-briefcase"></i><span> Master
              </span> <span class="menu-arrow"></span></a>
          <ul style="display: none;">
              <li class="{{ request()->is('dpp/jabatan*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.jabatan.index') }}"><span>Jabatan</span></a>
              </li>
              <li class="{{ request()->is('dpp/pekerjaan*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.pekerjaan.index') }}"><span>Pekerjaan</span></a>
              </li>

              <li class="{{ request()->is('dpp/kabupaten*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.kabupaten.index') }}"><span>Daftar Anggota</span>
                  </a>
              </li>
          </ul>
      </li>



      <li class="submenu">
          <a style="color:#FFF9F9;" href="#" class=""><i class="fa-solid fa-circle-info"></i><span>
                  Informasi </span> <span class="menu-arrow"></span></a>
          <ul style="display: none;">
              <li class="{{ request()->is('dpp/informasi*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.informasi.index') }}"><span>Informasi</span></a>
              </li>

              <li class="{{ request()->is('dpp/kategori*') }}">
                  <a style="color:#00000;" href="{{ route('dpp.kategori.index') }}"><span>Artikel Kategori</span></a>
              </li>
          </ul>
      </li>
      <li class="{{ request()->is('dpp/exports*') }}"> <a style="color:#FFF9F9;"
              href="{{ route('dpp.exports.index') }}"><i class="fa-solid fa-print"></i><span>Export</span></a> </li>
      <li class="{{ request()->is('dpp/ettings*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpp.settings.index') }}"><i
                  class="fa-solid fa-gear"></i><span>Settings</span></a>
      </li>
      <!--<li class="{{ request()->is('dpp/about*') }}">-->
      <!--    <a style="color:#FFF9F9;" href="{{ route('dpp.about.index') }}"><i class="fa-solid fa-gear"></i><span>Tentang Kami</span></a>-->
      <!--</li>-->
      <li class="{{ request()->is('dpp/log_activity*') }}">
          <a style="color:#FFF9F9;" href="{{ route('dpp.log_activity.index') }}"><i
                  class="fa-solid fa-file-invoice"></i><span>Log Activity</span></a>
      </li>
  </ul>
