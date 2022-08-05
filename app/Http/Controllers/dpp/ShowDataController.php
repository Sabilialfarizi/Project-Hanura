<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, User, Kabupaten, DetailUsers, Kelurahan, Kecamatan, Kantor, Kepengurusan};
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use ZipArchive;
use App\Exports\PACExport;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use DirecctoryIterator;
use QrCode;

class ShowDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $path = '/www/wwwroot/siap.partaihanura.or.id/uploads/';

    public function index($id)
    {
        // abort_unless(\Gate::allows('category_access'), 403);

        $kabupaten = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->where('detail_users.status_kta', 1)
            ->groupBy('detail_users.nik')
            ->get();

        $detail = Kabupaten::where('id_kab', $id)->first();


        return view('dpp.provinsi.showData', compact('kabupaten', 'detail'));
    }



    public function showData($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        $kabupaten = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where('detail_users.status_kta', 1)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->groupBy('detail_users.nik')
            ->get();
        $detail = Kabupaten::where('id_kab', $id)->first();


        return view('dpp.provinsi.show', compact('kabupaten', 'detail'));
    }

    public function showprovinsi($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        $provinsi = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('detail_users.provinsi_domisili', $id)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->where('detail_users.status_kta', 1)
            ->groupBy('detail_users.nik')
            ->get();

        $detail = Provinsi::where('id_prov', $id)->first();


        return view('dpp.provinsi.showprovinsi', compact('provinsi', 'detail'));
    }
    public function showkabupaten($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        $kabupaten = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->where('detail_users.status_kta', 1)
            ->groupBy('detail_users.nik')
            ->get();
        $detail = Kabupaten::where('id_kab', $id)->first();


        return view('dpp.kabupaten.showkabupaten', compact('kabupaten', 'detail'));
    }
    public function showkecamatan($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        //  $kelurahan = DetailUsers::where('kelurahan_domisili', $id)->where('status_kta', 1)->get();
        $detail = Kabupaten::where('id_kab', $id)->first();

        $provinsi = Provinsi::where('id_prov', $detail->id_prov)->first();

        $kecamatan = Kecamatan::selectRaw("
            kecamatans.id,
            kecamatans.id_kec,
            kecamatans.name,
            kabupatens.id_kab,
            provinsis.id_prov
        ")
            ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'kecamatans.id_kab')
            ->leftJoin('provinsis', 'provinsis.id_prov', '=', 'kabupatens.id_prov')
            ->where('kecamatans.id_kab', $id)
            ->get();


        return view('dpp.provinsi.showkecamatan', compact('kecamatan', 'detail', 'provinsi'));
    }
    public function showkelurahan($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        //  $kelurahan = DetailUsers::where('kelurahan_domisili', $id)->where('status_kta', 1)->get();
        $detail = Kecamatan::where('id_kec', $id)->first();
        $id_kec = Kecamatan::where('id_kec', $id)->pluck('id_kec');

        $kabupaten = Kabupaten::where('id_kab', $detail->id_kab)->first();

        $provinsi = Provinsi::where('id_prov', $kabupaten->id_prov)->first();

        $kelurahan = Kelurahan::where('id_kec', $id)->get();




        return view('dpp.provinsi.showkelurahan', compact('id_kec', 'kelurahan', 'detail', 'kabupaten', 'provinsi'));
    }


    public function export_hp_parpol($id)
    {
        $get_kabupaten = Kabupaten::where('id_kab', $id)->first();

        $get_provinsi = Provinsi::where('id_prov', $get_kabupaten->id_prov)->first();

        // get detail user from kab

        /*SELECT detail_users.* , kelurahans.name AS nama_kelurahan , kecamatans.name AS nama_kecamatan FROM detail_users
        INNER JOIN kelurahans ON kelurahans.id_kel = detail_users.kelurahan_domisili
        INNER JOIN kecamatans ON kecamatans.id_kec = detail_users.kecamatan_domisili
        WHERE detail_users.kabupaten_domisili LIKE '3175' AND detail_users.status_kta = 1*/

        $get_user = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('kelurahans', 'kelurahans.id_kel', 'detail_users.kelurahan_domisili')
            ->join('kecamatans', 'kecamatans.id_kec', 'detail_users.kecamatan_domisili')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where('detail_users.status_kta', 1)
            // ->where('model_has_roles.role_id', 4)
            ->whereIn('detail_users.status_kpu', array(2, 5))
            ->where('users.username', '=', '')
            ->select('detail_users.*', 'kelurahans.name AS nama_kelurahan', 'kecamatans.name AS nama_kecamatan')
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy('detail_users.nik')
            ->get();

        $kantor = Kantor::where('id_daerah', $id)->first();

        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3001)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();
        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3002)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();

        $pdf = PDF::loadview('dpp.provinsi.export_hp_parpol', ['kantor' => $kantor, 'get_kabupaten' => $get_kabupaten, 'get_provinsi' => $get_provinsi, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua])->setPaper('A4', 'landscape');
        $filename = 'LAMPIRAN 2 MODEL F2.HP-PARPOL_';
        return $pdf->stream($filename .  ucwords(strtolower($get_kabupaten->name)) . ".pdf");


        // return view('dpp.provinsi.export_hp_parpol' , compact('get_kabupaten' , 'get_provinsi' , 'get_user'));

    }
    public function export_parpol($id)
    {
        $get_kabupaten = Kabupaten::where('id_kab', $id)->first();

        $get_provinsi = Provinsi::where('id_prov', $get_kabupaten->id_prov)->first();

        // get detail user from kab

        /*SELECT detail_users.* , kelurahans.name AS nama_kelurahan , kecamatans.name AS nama_kecamatan FROM detail_users
        INNER JOIN kelurahans ON kelurahans.id_kel = detail_users.kelurahan_domisili
        INNER JOIN kecamatans ON kecamatans.id_kec = detail_users.kecamatan_domisili
        WHERE detail_users.kabupaten_domisili LIKE '3175' AND detail_users.status_kta = 1*/

        $get_user = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('kelurahans', 'kelurahans.id_kel', 'detail_users.kelurahan_domisili')
            ->join('kecamatans', 'kecamatans.id_kec', 'detail_users.kecamatan_domisili')
            ->where('detail_users.kabupaten_domisili', $id)
            ->where('detail_users.status_kta', 1)
            // ->where('model_has_roles.role_id', 4)
            ->where('detail_users.status_kpu', 2)
            ->where('users.username', '=', '')
            ->select('detail_users.*', 'kelurahans.name AS nama_kelurahan', 'kecamatans.name AS nama_kecamatan')
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy('detail_users.nik')
            ->get();


        $kantor = Kantor::where('id_daerah', $id)->first();

        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3001)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();
        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3002)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();

        $pdf = PDF::loadview('dpp.provinsi.export_parpol', ['kantor' => $kantor, 'get_kabupaten' => $get_kabupaten, 'get_provinsi' => $get_provinsi, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua])->setPaper('A4', 'landscape');
        $filename = 'LAMPIRAN 2 MODEL F2 PARPOL_';
        return $pdf->stream($filename .  ucwords(strtolower($get_kabupaten->name)) . ".pdf");

        // return view('dpp.provinsi.export_hp_parpol' , compact('get_kabupaten' , 'get_provinsi' , 'get_user'));

    }
    public function lampiran_parpol($id)
    {

        $get_provinsi = Provinsi::where('id_prov', $id)->first();


        $get_user = DB::table('kabupatens')->where('id_prov', $id)->groupBy('id_kab')->get();

        $kantor = Kantor::where('id_daerah', 0)->first();


        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.jabatan', 1001)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();


        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.jabatan', 1101)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();


        $pdf = PDF::loadview('dpp.provinsi.lampiran_parpol', ['kantor' => $kantor, 'get_provinsi' => $get_provinsi, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua]);
        $filename = 'LAMPIRAN 1 MODEL F2 PARPOL_';
        return $pdf->stream($filename .  ucwords(strtolower($get_provinsi->name)) . ".pdf");
    }
    public function lampiran_hp_parpol($id)
    {

        $get_provinsi = Provinsi::where('id_prov', $id)->first();


        $get_user = DB::table('kabupatens')->where('id_prov', $id)->groupBy('id_kab')->get();




        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.jabatan', 1001)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();

        $kantor = Kantor::where('id_daerah', 0)->first();
        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as name', 'kepengurusan.kta', 'jabatans.nama', 'jabatans.urutan', 'kepengurusan.nik', 'kepengurusan.foto', 'kepengurusan.ttd')
            ->where('kepengurusan.jabatan', 1101)
            ->where('kepengurusan.deleted_at', null)
            ->orderBy('jabatans.urutan', 'asc')
            ->groupBy('kepengurusan.id_kepengurusan')
            ->first();


        $pdf = PDF::loadview('dpp.provinsi.lampiran_hp_parpol', ['kantor' => $kantor, 'get_provinsi' => $get_provinsi, 'get_user' => $get_user, 'sekretaris' => $sekretaris, 'ketua' => $ketua]);

        $filename = 'LAMPIRAN 1 MODEL F2.HP-PARPOL_';
        return $pdf->stream($filename .  ucwords(strtolower($get_provinsi->name)) . ".pdf");
    }

    public function export_kta_n_ktp_folder($id)
    {
        $kabupaten = Kabupaten::where('id_kab', $id)->first();
        $provinsi = Provinsi::where('id_prov', $kabupaten->id_prov)->first();
        $detail_users = DetailUsers::where('kabupaten_domisili', $id)->get();
        $image_path_arr = array();

        $ketua = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as nama', 'jabatans.nama as jabatan', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3001)
            ->orderBy('kepengurusan.created_at', 'desc')
            ->limit(1)
            ->first();

        $kantor = Kantor::where('id_daerah', $id)->first();

        $sekretaris = DB::table('kepengurusan')
            ->leftJoin('jabatans', 'kepengurusan.jabatan', '=', 'jabatans.kode')
            ->select('kepengurusan.nama as nama', 'jabatans.nama as jabatan', 'kepengurusan.ttd')
            ->where('kepengurusan.id_daerah', $id)
            ->where('kepengurusan.jabatan', 3002)
            ->orderBy('kepengurusan.created_at', 'desc')
            ->limit(1)
            ->first();

        // fungsi untuk membuat zip
        $zip = new ZipArchive;
        $filename = 'KTA_dan_KTP_' . $kabupaten->name . '.zip';
        $zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // fungsi untuk mencari lokasi folder foto avatar                
        $path = storage_path('../../siap.partaihanura.or.id/uploads/img');
        $recursive_path = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $real_path = $recursive_path->getRealPath();


        // fungsi untuk mengisi alamat tanda tangan ketua, sekretaris, dan stempel
        $ttd_ketua_img_picked_path = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/' . $ketua->ttd) && !empty($ketua->ttd) ?
            '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/' . $ketua->ttd : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/noimage.jpg';
        $ttd_sekre_picked_path = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/' . $sekretaris->ttd) && !empty($sekretaris->ttd) ?
            '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/' . $sekretaris->ttd : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/ttd_kta/noimage.jpg';
        $stempel_picked_path = file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/' . $kantor->cap_kantor) && !empty($kantor->cap_kantor) ?
            '/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/' . $kantor->cap_kantor : '/www/wwwroot/siap.partaihanura.or.id/uploads/img/cap_kantor/cap.jpg';

        // fungsi untuk memasukkan foto kta ke dalam zip
        foreach ($detail_users as $du) {
            $user_img_picked_path = file_exists($real_path . '/users/' . $du->avatar) && !empty($du->avatar) ?
                $real_path . '/users/' . $du->avatar : $user_img_picked_path = $real_path . '/profile.png';

            $relative_path = 'foto_kta/' . $du->nik . '.jpg';

            $kecamatan = Kecamatan::select('name')->where('id_kec', $du->kecamatan_domisili)->first();
            $kelurahan = Kelurahan::select('name')->where('id_kel', $du->kelurahan_domisili)->first();
            $domAddress = array(
                isset($kelurahan) ? $kelurahan->name : '',
                isset($kecamatan) ? $kecamatan->name : '',
                $kabupaten->name,
                $provinsi->name
            );
            $image_path = self::generate_kta_card($du, $domAddress, $ketua, $sekretaris, $user_img_picked_path, $ttd_ketua_img_picked_path, $ttd_sekre_picked_path, $stempel_picked_path);
            $zip->addFile($image_path, $relative_path);
            array_push($image_path_arr, $image_path);
        }

        // fungsi untuk memasukkan foto ktp ke dalam zip
        foreach ($detail_users as $du) {
            $picked_path = $real_path . '/foto_ktp/' . $du->foto_ktp;
            $relative_path = 'foto_ktp/' . $du->nik . '.' . pathinfo($picked_path, PATHINFO_EXTENSION);
            if (file_exists($picked_path)) {
                $zip->addFile($picked_path, $relative_path);
            }
        }

        $zip->close();

        //hapus gambar foto kta
        foreach ($image_path_arr as $path) {
            unlink($path);
        }

        return response()->download($filename);
    }

    public function generate_kta_card(DetailUsers $du, $domAddress, $ketua, $sekretaris, $userImgAddress, $ttdKetuaImgAddress, $ttdSekreImgAddress, $capImgAddress)
    {
        header("Content-type: image/jpeg");

        $img = imagecreatetruecolor(640, 480);
        $font_file = resource_path('arialbd.ttf');
        $relative_path = dirname(__FILE__) . $du->nik . '.jpg';
        $avatar_kta = pathinfo($userImgAddress, PATHINFO_EXTENSION) == 'png' ? imagecreatefrompng($userImgAddress) : imagecreatefromjpeg($userImgAddress);
        $avatar_cap = pathinfo($capImgAddress, PATHINFO_EXTENSION) == 'png' ? imagecreatefrompng($capImgAddress) : imagecreatefromjpeg($capImgAddress);
        $avatar_ttd_ketua = pathinfo($ttdKetuaImgAddress, PATHINFO_EXTENSION) == 'png' ? imagecreatefrompng($ttdKetuaImgAddress) : imagecreatefromjpeg($ttdKetuaImgAddress);
        $avatar_ttd_sekre = pathinfo($ttdSekreImgAddress, PATHINFO_EXTENSION) == 'png' ? imagecreatefrompng($ttdSekreImgAddress) : imagecreatefromjpeg($ttdSekreImgAddress);

        //color ingredients
        $black = imagecolorallocate($img, 0, 0, 0);
        $white = imagecolorallocate($img, 255, 255, 255);

        $attNameArr = array(
            'No. KTA',
            'Nama',
            'Tempat/Tgl Lahir',
            'Alamat',
            'RT/RW',
            'Kel./Desa',
            'Kec.',
            'Kab./Kota',
            'Provinsi',
            'Diterbitkan'
        );
        $attValArr = array(
            $du->no_member,
            $du->nickname,
            $du->tgl_lahir,
            $du->alamat_domisili,
            $du->rt_rw,
            $domAddress[0],
            $domAddress[1],
            $domAddress[2],
            $domAddress[3],
            $du->created_at
        );

        imagefill($img, 0, 0, $white);
        imagecopymerge($img, $avatar_kta, 70, 70, 0, 0, imagesx($avatar_kta), imagesy($avatar_kta), 100);
        imagecopymerge($img, $avatar_ttd_ketua, 250, 280, 0, 0, imagesx($avatar_ttd_ketua), imagesy($avatar_ttd_ketua), 100);
        imagecopymerge($img, $avatar_ttd_sekre, 400, 280, 0, 0, imagesx($avatar_ttd_sekre), imagesy($avatar_ttd_sekre), 100);
        imagecopymerge($img, $avatar_cap, 320, 280, 0, 0, imagesx($avatar_cap), imagesy($avatar_cap), 80);

        foreach ($attNameArr as $key => $val) {
            imagettftext($img, 12, 0, 250, 88 + ($key * 18), $black, $font_file, $val);
            imagettftext($img, 12, 0, 400, 88 + ($key * 18), $black, $font_file, ':   ' . $attValArr[$key]);
        }

        imagettftext($img, 12, 0, 280, 274, $black, $font_file, 'DPC ' . $domAddress[2]);
        imagettftext($img, 12, 0, 300, 292, $black, $font_file, 'Ketua');
        imagettftext($img, 12, 0, 450, 292, $black, $font_file, 'Sekretaris');
        imagettftext($img, 12, 0, 300, 364, $black, $font_file, $ketua->nama);
        imagettftext($img, 12, 0, 450, 364, $black, $font_file, $sekretaris->nama);

        imagejpeg($img, $relative_path);
        imagedestroy($img);

        return $relative_path;
    }

    // ZIP KTA KTP
    public function zip_kta_ktp($id)
    {
        set_time_limit(0);
        $user = User::selectRaw("users.id, detail_users.foto_ktp, detail_users.nik")
            ->leftJoin('detail_users', 'detail_users.userid', '=', 'users.id')
            ->where('kecamatan_domisili', '=', $id)
            ->where('status_kta', '=', 1)
            ->get();
        $kecamatan = Kecamatan::where('id_kec', $id)->first();

        $zip = new \ZipArchive();
        $zipName = $this->path . '/kecamatan-zip/' . ucwords(strtolower($kecamatan->name)) . '.zip';

        if ($zip->open($zipName, \ZipArchive::CREATE) !== TRUE) {
            echo 'Could not open ZIP file.';
            return;
        }

        $to_delete = [];
        $extp = ['jpg', 'jpeg', 'png'];
        foreach ($user as $value) {
            //   $ext = pathinfo($this->path . '/img/foto_ktp/' . $value->foto_ktp, PATHINFO_EXTENSION);
            //   if (in_array($ext, $extp)) {
            // $im = new \Imagick();
            $to_delete[] = $kta_name = $this->cetakPDF($value->id);
            // $im->readImageBlob(file_get_contents($this->path . 'img/pic_kta/' . $kta_name . '.pdf'));
            // $im->setResolution(1000, 1000);
            // $im->setImageFormat('jpeg');
            // $im->setImageCompression(\Imagick::COMPRESSION_JPEG);
            // $im->setImageCompressionQuality(100);
            // $im->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);
            // $im->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
            // $im->writeImages($this->path . 'img/pic_kta/' . $kta_name . '.jpeg', false);
            // $im->clear();
            // $im->destroy();


            // $zip->addFile($this->path . '/img/pic_kta/' . $kta_name . '.jpeg', 'KTA/' . $kta_name . '.jpeg');
            $zip->addFile($this->path . '/img/pic_kta/' . $kta_name . '.pdf', 'KTP+KTA/' . $kta_name . '.pdf');
            // $zip->addFile($this->path . '/img/foto_ktp/' . $value->foto_ktp, 'KTP/' . $value->nik . '.' . $ext);
            //   }
        }

        $zip->close();

        // foreach ($to_delete as $kta_name) {
        //   unlink($this->path . 'img/pic_kta/' . $kta_name . '.jpeg');
        //   unlink($this->path . 'img/pic_kta/' . $kta_name . '.pdf');
        // }

        return response()->download($zipName);
    }

    public function cetak($id)
    {
        $member = User::find($id);

        $details = DetailUsers::where('userid', $id)->where('status_kta', 1)
            ->first();

        $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $details->kabupaten_domisili)->first();

        $kabupaten = Kabupaten::where('id_kab', $details->kabupaten_domisili)->first();
        $customPaper = array(10, 0, 295, 210);
        $pdf = PDF::loadview('dpc.member.cetak', ['details' => $details, 'kantor' => $kantor, 'member' => $member, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten])->setPaper($customPaper, 'portrait');
        $filename = 'Kta_';
        return $pdf->stream($filename .  ucwords(strtolower($details->nickname)) . ".pdf");
    }
    public function cetaks($id)
    {
        // $member = User::find($id);

        // $details = DetailUsers::where('userid', $id)->where('status_kta', 1)
        //   ->first();

        // $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
        // $sekre = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        // $kantor = Kantor::where('id_daerah', $details->kabupaten_domisili)->first();

        // $kabupaten = Kabupaten::where('id_kab', $details->kabupaten_domisili)->first();
        // $customPaper = array(10, 0, 295, 210);
        // $pdf = PDF::loadview('dpc.member.cetak', ['details' => $details, 'kantor' => $kantor, 'member' => $member, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten])->setPaper($customPaper, 'portrait');
        // $filename = 'Kta_';
        // return $pdf->stream($filename .  ucwords(strtolower($details->nickname)) . ".pdf");

        $detail = DetailUsers::leftJoin('users', 'detail_users.userid', '=', 'users.id')
            ->selectRaw('detail_users.*,users.image')
            ->where('detail_users.userid', $id)
            ->first();

        $ketua = Kepengurusan::where('id_daerah', $detail->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $detail->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $detail->kabupaten_domisili)->first();
        $kecamatan = Kecamatan::where('id_kec', $detail->kecamatan_domisili)->first();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ])->loadview('dpc.member.cetaks', ['kantor' => $kantor, 'detail' => $detail, 'ketua' => $ketua, 'kecamatan' => $kecamatan, 'sekre' => $sekre])
            ->setPaper([0, 0, 550, 245], 'potrait');
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        $filename = 'Kta_';
        return $pdf->stream($detail->nik . ".pdf");
        // $pdf->save('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . $detail->nik . '.pdf');
    }

    public function showkta($id)
    {

        set_time_limit(0);
        $user =  User::selectRaw("users.id, detail_users.foto_ktp, detail_users.nik, kabupatens.name")
            ->leftJoin('detail_users', 'detail_users.userid', '=', 'users.id')
            ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'detail_users.kabupaten_domisili')
            ->where('kabupaten_domisili', '=', $id)
            ->where('status_kta', 1)
            ->where(DB::raw('LENGTH(no_member)'), '>', [18, 20])
            ->groupBy('nik')
            ->get();

        $kecamatan = Kabupaten::where('id_kab', $id)->first();


        $zip = new \ZipArchive();
        $zipName = $this->path . '/pdf-zip/' . ucwords(strtolower($kecamatan->name)) . '.zip';

        if ($zip->open($zipName, \ZipArchive::CREATE) !== TRUE) {
            echo 'Could not open ZIP file.';
            return;
        }
        $to_delete = [];

        foreach ($user as $value) {
            $to_delete[] = $kta_name = $this->cetakKTA($value->name);

            $zip->addFile($this->path . '/file/pdf_kta/' . $kta_name . '.pdf', 'KTP/' . $kta_name . '.pdf');
        }
        $zip->close();

        // foreach ($to_delete as $kta_name) {
        //   unlink($this->path . 'file/pdf_kta/' .  ucwords(strtolower($kta_name)) . ".pdf");
        // }

        return response()->download($zipName);
    }


    private function cetakKTA($id)
    {
        $kabupaten = Kabupaten::where('name', $id)->first();
        $detail =  User::leftJoin('detail_users', 'detail_users.userid', '=', 'users.id')
            ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'detail_users.kabupaten_domisili')
            ->where('kabupaten_domisili', '=', $kabupaten->id_kab)
            ->where('status_kta', 1)
            ->where(DB::raw('LENGTH(no_member)'), '>', [18, 20])
            ->groupBy('nik')
            ->get();


        $kantor = Kantor::where('id_daerah',  $kabupaten->id_kab)->first();

        $ketua = Kepengurusan::where('id_daerah',  $kabupaten->id_kab)->where('jabatan', 3001)->first();

        $sekre = Kepengurusan::where('id_daerah',  $kabupaten->id_kab)->where('jabatan', 3002)->first();

        $customPaper = array(0, 0, 595.4488, 925.433);
        $pdf = PDF::loadview('dpp.kabupaten.showkta', ['detail' => $detail, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten, 'kantor' => $kantor])->setPaper($customPaper, 'portrait');


        $filename = 'Kta_';
        $pdf->save($this->path . 'file/pdf_kta/' .  ucwords(strtolower($id)) . ".pdf");

        return ucwords(strtolower($kabupaten->name));
    }


    private function cetakPDF($id)
    {
        $member = User::find($id);
        $details = DetailUsers::where('userid', $id)->where('status_kta', 1)
            ->first();

        $ketua = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $details->kabupaten_domisili)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $details->kabupaten_domisili)->first();

        $kabupaten = Kabupaten::where('id_kab', $details->kabupaten_domisili)->first();
        $customPaper = array(10, 0, 320, 210);
        $pdf = PDF::loadview('dpp.kecamatan.render_kta', ['detail' => $details, 'kantor' => $kantor, 'ketua' => $ketua, 'sekre' => $sekre, 'kecamatan' => $kabupaten, 'member' => $member])->setPaper($customPaper, 'portrait');

        $pdf->save($this->path . 'img/pic_kta/' . ucwords(strtolower($details->nik)) . ".pdf");

        return ucwords(strtolower($details->nik));
    }

    public function manual_kta_ktp_zip($id, $id_kec)
    {
        $detail = DetailUsers::leftJoin('users', 'detail_users.userid', '=', 'users.id')
            ->where('detail_users.kecamatan_domisili', $id_kec)
            ->where('detail_users.status_kta', 1)
            //   ->where('model_has_roles.role_id', 4)
            ->where('detail_users.status_kpu', 2)
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            ->groupBy('detail_users.id')
            ->groupBy('detail_users.nik')
            ->get();


        $ketua = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3001)->first();
        $sekre = Kepengurusan::where('id_daerah', $id)->where('jabatan', 3002)->first();
        $kantor = Kantor::where('id_daerah', $id)->first();
        $kecamatan = Kecamatan::selectRaw("
            kecamatans.id_kec,
            kecamatans.name,
            kabupatens.id_kab,
            provinsis.id_prov
        ")
            ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'kecamatans.id_kab')
            ->leftJoin('provinsis', 'provinsis.id_prov', '=', 'kabupatens.id_prov')
            ->where('id_kec', $id_kec)
            ->first();

        $zip = new \ZipArchive();
        $zipName = '/www/wwwroot/siap.partaihanura.or.id/uploads/ktp-kta-zip/' . $kecamatan->id_prov . '_' . $kecamatan->id_kab . '_' . $kecamatan->id_kec . '_' . strtoupper($kecamatan->name) . '.zip';

        if ($zip->open($zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            echo 'Could not open ZIP file.';
            return;
        }



        foreach ($detail as $key => $value) {
            if (!file_exists('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . $value->nik . '.pdf')) {

                $pdf = PDF::setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true
                ])->loadview('dpc.member.cetaks', ['kantor' => $kantor, 'detail' => $value, 'ketua' => $ketua, 'kecamatan' => $kecamatan, 'sekre' => $sekre])
                    ->setPaper([0, 0, 550, 245], 'potrait');
                $pdf->getDomPDF()->setHttpContext(
                    stream_context_create([
                        'ssl' => [
                            'allow_self_signed' => TRUE,
                            'verify_peer' => FALSE,
                            'verify_peer_name' => FALSE,
                        ]
                    ])
                );
                $pdf->save('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . $value->nik . '.pdf');
            }

            $zip->addFile('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . $value->nik . '.pdf', 'KTP+KTA/' . $value->nik . '.pdf');
            sleep(1);
        }

        $id = $id_kec;
        $exporter = app()->makeWith(PACExport::class, compact('id'));

        // $exporter->fopen(/www/wwwroot/siap.partaihanura.or.id/uploads/kta/Kecamatan_Mesuji.xls): failed to open stream: Permission denied("Kecamatan_" . $kecamatan->name . ".xls", 'excel_store');

        $zip->addFile('/www/wwwroot/siap.partaihanura.or.id/uploads/kta/' . "Kecamatan_" . $kecamatan->name . ".xls", 'Kecamatan_' . $kecamatan->name . ".xls");
        $zip->close();
        return response()->download($zipName);
    }

    public function kta_ktp_zip($id, $id_kec)
    {
        $kecamatan = Kecamatan::selectRaw("
            kecamatans.id_kec,
            kecamatans.name,
            kabupatens.id_kab,
            provinsis.id_prov
        ")
            ->leftJoin('kabupatens', 'kabupatens.id_kab', '=', 'kecamatans.id_kab')
            ->leftJoin('provinsis', 'provinsis.id_prov', '=', 'kabupatens.id_prov')
            ->where('id_kec', $id_kec)
            ->first();
        $file_name = '/www/wwwroot/siap.partaihanura.or.id/uploads/ktp-kta-zip/' . $kecamatan->id_prov . '_' . $kecamatan->id_kab . '_' . $kecamatan->id_kec . '_' . strtoupper($kecamatan->name) . '.zip';

        return response()->download($file_name);
    }

    public function list_dpc()
    {
        $kantor = Kabupaten::selectRaw("
                kantor.no_sk AS file_sk,
                kantor.domisili,
                kantor.surat_keterangan_kantor AS skk,
                kantor.rekening_bank,
                kantor.id_kantor,
                kantor.alamat,
                kantor.status_kantor,
                kantor.tgl_selesai,
                kantor.nomor_rekening_bank,
                kabupatens.name,
                kabupatens.id_kab,
                kepengurusan.no_sk,
                dpc.jml,
                kab.jml_kab,
                kp.jml_pengurus,
                kpp.jml_perempuan,
                ang.jml_ang,
                provinsis.name as prov,
                ang.status
            ")
            ->leftJoin(DB::raw('(SELECT DISTINCT * FROM `kantor` GROUP BY `id_daerah`) kantor'), function ($join) {
                $join->where('kantor.deleted_at', null);
                $join->where('kantor.id_tipe_daerah', 3);
                $join->on('kantor.id_daerah', '=', 'kabupatens.id_kab');
            })
            ->leftJoin('kepengurusan', function ($join) {
                $join->where('kepengurusan.jabatan', '=', 3001);
                $join->where('kepengurusan.deleted_at', null);
                $join->on('kabupatens.id_kab', '=', 'kepengurusan.id_daerah');
            })
            ->leftJoin('provinsis', 'provinsis.id_prov', '=', 'kabupatens.id_prov');

        // JOIN (SELECT DISTINCT id_daerah, deleted_at FROM kantor ) as kantor ON kantor.id_daerah = kecamatans.id_kec AND kantor.deleted_at IS NULL
        $jTable1 = DB::raw("(
            SELECT DISTINCT
                COUNT(id) AS jml,
                kecamatans.id_kab
            FROM
                kecamatans
            LEFT JOIN (
                SELECT DISTINCT
                    *
                FROM
                    kepengurusan
                WHERE
                    kepengurusan.deleted_at IS NULL AND kepengurusan.jabatan = 4001
                GROUP BY
                    kepengurusan.id_daerah
            ) kepengurusan ON kepengurusan.id_daerah = kecamatans.id_kec AND jabatan = 4001
            WHERE
                kepengurusan.no_sk IS NOT NULL
            GROUP BY
                kecamatans.id_kab
            ) as dpc");

        $kantor->leftJoin($jTable1, 'dpc.id_kab', '=', 'kabupatens.id_kab');
        $jTable2 = DB::raw("(
                SELECT DISTINCT COUNT(id) as jml_kab, id_kab FROM kecamatans GROUP BY kecamatans.id_kab
            ) as kab");
        $kantor->leftJoin($jTable2, 'kab.id_kab', '=', 'kabupatens.id_kab');

        $jTable3 = DB::raw("(SELECT DISTINCT COUNT(nik) as jml_pengurus, id_daerah FROM kepengurusan WHERE deleted_at IS NULL GROUP BY id_daerah ) as kp");
        $kantor->leftJoin($jTable3, 'kp.id_daerah', '=', 'kabupatens.id_kab');

        $jTable4 = DB::raw("(
            SELECT DISTINCT
                SUM(
                    CASE
                        WHEN SUBSTRING(nik, 7, 2) > 40 THEN 1 ELSE 0
                    END
                ) as jml_perempuan,
                id_daerah
            FROM
                kepengurusan
            WHERE
                deleted_at IS NULL
            GROUP BY
                id_daerah
        ) as kpp");

        $kantor->leftJoin($jTable4, 'kpp.id_daerah', '=', 'kabupatens.id_kab');

        $jTable5 = DB::raw("(
            SELECT DISTINCT
                COUNT(*) as jml_ang,
                x.status,
                detail_users.kabupaten_domisili
            FROM
                detail_users
            LEFT JOIN (
                SELECT DISTINCT
                    CASE
                        WHEN created_at >= CURRENT_DATE - INTERVAL 9 DAY AND created_at  < CURRENT_DATE + INTERVAL 1 DAY THEN 'warning'
                        WHEN created_at >= CURRENT_DATE - INTERVAL 19 DAY AND created_at  < CURRENT_DATE + INTERVAL 1 DAY THEN 'danger'
                        ELSE 'none'
                    END AS `status`,
                    kabupaten_domisili
                FROM
                    detail_users
                WHERE
                    deleted_at IS NULl
                GROUP BY
                    kabupaten_domisili
            ) as x ON x.kabupaten_domisili = detail_users.kabupaten_domisili
            WHERE
                deleted_at IS NULL AND status_kta = 1
            GROUP BY
                detail_users.kabupaten_domisili
        ) as ang");

        $kantor->leftJoin($jTable5, 'ang.kabupaten_domisili', '=', 'kabupatens.id_kab');

        $data['dpc'] = $kantor->get();

        return view('dpp.provinsi.list_dpc', $data);
    }
}
