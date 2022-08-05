<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kabupaten, Kecamatan, DetailUsers};
use App\ArticleCategory as Category;
use App\Kepengurusan;
use App\Kantor;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use DataTables;

class ProvinsiController extends Controller
{
    private $path = '/www/wwwroot/siap.partaihanura.or.id/uploads/';


    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        $provinsi = Provinsi::orderBy('id', 'asc')->groupBy('id_prov')->get();;

        return view('dpp.provinsi.index', compact('provinsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //   $anggota = DetailUsers::groupBy('nickname')->where('status_kta',1)->pluck('nickname','id');
        $check_id_prov = Provinsi::max('id_prov');
        $id_prov =  $check_id_prov !== null ? $check_id_prov + 1 : '1';

        return view('dpp.provinsi.create', compact('id_prov'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //    $divisi = DB::table('provinsis')->where('id_prov', $request->id_prov)->first();
        //    dd($divisi);
        // $divisi = DB::table('provinsis')->where('id_prov', $request->id_prov)->update([
        //     'id_ketua_dpd'        => $request->id_ketua_dpd,
        //     'id_sekre_dpd' => $request->id_sekre_dpd,
        //     'id_benda_dpd'    => $request->id_benda_dpd,
        // ]);

        // Provinsi::update([
        //     'id_ketua_dpd'        => $request->id_ketua_dpd,
        //     'id_sekre_id' => $request->id_sekre_id,
        //     'id_benda_id'    => $request->id_benda_id,
        // ]);

        //  dd($detail);

        $request->validate(
            [
                'id_prov' => 'required|unique:provinsis,id_prov',
                'name' => 'required',
                'zona_waktu' => 'required',
            ],
            [
                'id_prov.required' => 'Kode Provinsi tidak boleh kosong',
                'id_prov.unique' => 'Kode Provinsi sudah ada',
                'name.required' => 'Nama Provinsi tidak boleh kosong',
                'zona_waktu.required' => 'Zona Waktu tidak boleh kosong',
            ]
        );

        Provinsi::create([
            'id_prov' => $request->id_prov,
            'name' => $request->name,
            'zona_waktu' => $request->zona_waktu,
        ]);

        return redirect()->route('dpp.provinsi.index')->with('success', 'Pembatalan Anggota Sukses DiBuata');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provinsi = Kabupaten::where('id_prov', $id)->groupBy('id_kab')->get();


        $kabupaten = Provinsi::where('id_prov', $id)->first();

        return view('dpp.provinsi.show', compact('kabupaten', 'provinsi'));
    }

    public function showData($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

        $kabupaten = DetailUsers::where('kabupaten_domisili', $id)->get();
        $detail = Kabupaten::where('id_kab', $id)->first();


        return view('dpp.provinsi.show', compact('kabupaten', 'detail'));
    }


    /**
     * loaddata the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loaddata(Request $request)
    {
        $data = [];
        dd($request);
        $prov = Provinsi::where('id_prov', $request->id_prov)->get();
        dd($prov);

        // $detail= DetailUsers::where('userid',$id)->select('provinsi_domisili')->first();

        $provinsi =  DetailUsers::where('status_kta', 1)
            ->groupBy('nickname')
            ->where('provinsi_domisili', $request->id_prov)
            ->where('nickname', 'like', '%' . $request->q . '%')
            ->get();
        foreach ($provinsi as $row) {
            $data[] = ['id' => $row->id,  'text' => $row->nickname];
        }

        return response()->json($data);
    }

    public function edit($id)
    {
        $provinsi = Provinsi::find($id);


        $anggota = DetailUsers::groupBy('nickname')->where('status_kta', 1)->pluck('nickname', 'id');
        return view('dpp.provinsi.edit', compact('anggota', 'provinsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        // $divisi = DB::table('provinsis')->where('id',$request->id)->update([
        //     'id_ketua_dpd'  => $request->id_ketua_dpd,
        //     'id_sekre_dpd' => $request->id_sekre_dpd,
        //     'id_benda_dpd'  => $request->id_benda_dpd,
        // ]);
        $request->validate(
            [
                'id_prov' => 'required|unique:provinsis,id_prov',
                'name' => 'required',
                'zona_waktu' => 'required',
            ],
            [
                'id_prov.required' => 'Kode Provinsi tidak boleh kosong',
                'id_prov.unique' => 'Kode Provinsi sudah ada',
                'name.required' => 'Nama Provinsi tidak boleh kosong',
                'zona_waktu.required' => 'Zona Waktu tidak boleh kosong',
            ]
        );

        Provinsi::find($id)->update([
            'id_prov' => $request->id_prov,
            'name' => $request->name,
            'zona_waktu' => $request->zona_waktu,
        ]);

        return redirect()->route('dpp.provinsi.index')->with('success', 'Ketua Anggota Sukses DiBuat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Provinsi::find($id)->delete();

        return redirect()->route('dpp.provinsi.index')->with('success', 'Provinsi berhasil dihapus');
    }

    // ZIP KTA KTP
    public function zip_kta_ktp($id)
    {
        set_time_limit(0);
        $user = User::selectRaw("users.id, detail_users.foto_ktp, detail_users.nik")
            ->leftJoin('detail_users', 'detail_users.userid', '=', 'users.id')
            ->where('kabupaten_domisili', '=', $id)
            ->where('status_kta', '=', 1)
            ->get();
        $kabupaten = Kabupaten::where('id_kab', $id)->first();

        $zip = new \ZipArchive();
        $zipName = $this->path . '/kabupaten-zip/' . ucwords(strtolower($kabupaten->name)) . '.zip';

        if ($zip->open($zipName, \ZipArchive::CREATE) !== TRUE) {
            echo 'Could not open ZIP file.';
            return;
        }

        $to_delete = [];
        $extp = ['jpg', 'jpeg', 'png'];
        foreach ($user as $value) {
            $ext = pathinfo($this->path . '/img/foto_ktp/' . $value->foto_ktp, PATHINFO_EXTENSION);
            if (in_array($ext, $extp)) {
                $to_delete[] = $kta_name = $this->cetakPDF($value->id);

                // $im = new \Imagick();
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
            }
        }

        $zip->close();

        // foreach ($to_delete as $kta_name) {
        //     unlink($this->path . 'img/pic_kta/' . $kta_name . '.jpeg');
        //     unlink($this->path . 'img/pic_kta/' . $kta_name . '.pdf');
        // }

        return response()->download($zipName);
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
        $pdf = PDF::loadview('dpc.kecamatan.render_kta', ['details' => $details, 'kantor' => $kantor, 'ketua' => $ketua, 'sekre' => $sekre, 'kabupaten' => $kabupaten])->setPaper($customPaper, 'portrait');

        $pdf->save($this->path . 'img/pic_kta/' . ucwords(strtolower($details->nik)) . ".pdf");

        return ucwords(strtolower($details->nik));
    }

    // Rekap Kepengurusan
    public function rekap_dpd()
    {
        // Nomor SK
        $kantor = Provinsi::selectRaw("
                kantor.no_sk AS file_sk,
                kantor.domisili,
                kantor.surat_keterangan_kantor AS skk,
                kantor.rekening_bank,
                kantor.id_kantor,
                kantor.alamat,
                kantor.status_kantor,
                kantor.tgl_selesai,
                kantor.nomor_rekening_bank,
                provinsis.name,
                provinsis.id_prov,
                kepengurusan.no_sk,
                dpc.jml,
                kab.jml_kab,
                kp.jml_pengurus,
                kpp.jml_perempuan
            ")
            ->leftJoin('kantor', function ($join) {
                $join->where('kantor.deleted_at', null);
                $join->where('kantor.id_tipe_daerah', 2);
                $join->on('kantor.id_daerah', '=', 'provinsis.id_prov');
            })
            ->leftJoin('kepengurusan', function ($join) {
                $join->on('provinsis.id_prov', '=', 'kepengurusan.id_daerah');
                $join->where('kepengurusan.jabatan', '=', 2001);
                $join->where('kepengurusan.deleted_at', null);
            });

        $jTable1 = DB::raw("(
            SELECT DISTINCT
                COUNT(id) AS jml,
                kabupatens.id_prov
            FROM
                kabupatens
            LEFT JOIN (SELECT DISTINCT id_daerah, deleted_at FROM kantor ) as kantor ON kantor.id_daerah = kabupatens.id_kab AND kantor.deleted_at IS NULL
            LEFT JOIN kepengurusan ON kepengurusan.id_daerah = kabupatens.id_kab AND jabatan = 3001 AND kepengurusan.deleted_at IS NULL
            WHERE
                kepengurusan.no_sk IS NOT NULL
            GROUP BY
                kabupatens.id_prov
            ) as dpc");

        $kantor->leftJoin($jTable1, 'dpc.id_prov', '=', 'provinsis.id_prov');
        $jTable2 = DB::raw("(
                SELECT DISTINCT COUNT(id) as jml_kab, id_prov FROM kabupatens GROUP BY kabupatens.id_prov
            ) as kab");
        $kantor->leftJoin($jTable2, 'kab.id_prov', '=', 'provinsis.id_prov');

        $jTable3 = DB::raw("(SELECT DISTINCT COUNT(nik) as jml_pengurus, id_daerah FROM kepengurusan WHERE deleted_at IS NULL GROUP BY id_daerah ) as kp");
        $kantor->leftJoin($jTable3, 'kp.id_daerah', '=', 'provinsis.id_prov');

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
        $kantor->leftJoin($jTable4, 'kpp.id_daerah', '=', 'provinsis.id_prov');

        $data['dpd'] = $kantor->get();
        $data['count'] = $data['dpd']->count();

        $data['sk_yes'] = $kantor->whereRaw('kepengurusan.no_sk IS NOT NULL')->get()->count();
        $data['sk_no'] = $data['dpd']->count() - $data['sk_yes'];
        // dd($data['count']);

        return view('dpp.provinsi.rekap_dpd', $data);
    }

    public function rekap_dpc($id = null, $type = -1)
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
                kpp.jml_perempuan
            ")
            ->leftJoin(DB::raw('(SELECT DISTINCT * FROM `kantor` GROUP BY `id_daerah`) kantor'), function ($join) {
                $join->where('kantor.deleted_at', null);
                $join->where('kantor.id_tipe_daerah', 3);
                $join->on('kantor.id_daerah', '=', 'kabupatens.id_kab');
            })
            ->leftJoin('kepengurusan', function ($join) {
                $join->on('kabupatens.id_kab', '=', 'kepengurusan.id_daerah');
                $join->where('kepengurusan.jabatan', '=', 3001);
                $join->where('kepengurusan.deleted_at', null);
            });

        // JOIN (SELECT DISTINCT id_daerah, deleted_at FROM kantor ) as kantor ON kantor.id_daerah = kecamatans.id_kec AND kantor.deleted_at IS NULL
        $jTable1 = DB::raw("(
            SELECT DISTINCT
                COUNT(id) AS jml,
                kecamatans.id_kab
            FROM
                kecamatans
            JOIN (
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

        if (!is_null($id)) {
            $kantor->where('kabupatens.id_prov', '=', $id);
        }

        switch ($type) {
            case 0:
                $kantor->whereRaw('kepengurusan.no_sk IS NULL');
                break;

            case 1:
                $kantor->whereRaw('kepengurusan.no_sk IS NOT NULL');
                break;
        }

        $data['provinsi'] = Provinsi::where('id_prov', '=', $id)->first();
        $data['id'] = (is_null($id)) ? null : $id;
        $data['dpc'] = $kantor->get();
        $data['count'] = $data['dpc']->count();
        $data['type'] = $type;
        $data['sk_yes'] = $kantor->whereRaw('kepengurusan.no_sk IS NOT NULL')->get()->count();
        $data['sk_no'] = $data['dpc']->count() - $data['sk_yes'];

        return view('dpp.provinsi.rekap_dpc', $data);
    }

    public function rekap_pac($id = null, $type = -1)
    {
        $kantor = Kecamatan::selectRaw("
            kantor.no_sk AS file_sk,
            kantor.domisili,
            kantor.surat_keterangan_kantor AS skk,
            kantor.rekening_bank,
            kantor.id_kantor,
            kantor.alamat,
            kantor.status_kantor,
            kantor.tgl_selesai,
            kantor.nomor_rekening_bank,
            kecamatans.name,
            kecamatans.id_kec,
            kepengurusan.no_sk,
            kp.jml_pengurus,
                kpp.jml_perempuan
        ")
            ->leftJoin(DB::raw('(SELECT DISTINCT * FROM `kantor` GROUP BY `id_daerah`) kantor'), function ($join) {
                $join->where('kantor.deleted_at', null);
                $join->where('kantor.id_tipe_daerah', 4);
                $join->on('kantor.id_daerah', '=', 'kecamatans.id_kec');
            })
            ->leftJoin('kepengurusan', function ($join) {
                $join->on('kecamatans.id_kec', '=', 'kepengurusan.id_daerah');
                $join->where('kepengurusan.jabatan', '=', 4001);
                $join->where('kepengurusan.deleted_at', null);
            });

        $jTable3 = DB::raw("(SELECT DISTINCT COUNT(nik) as jml_pengurus, id_daerah FROM kepengurusan WHERE deleted_at IS NULL GROUP BY id_daerah ) as kp");
        $kantor->leftJoin($jTable3, 'kp.id_daerah', '=', 'kecamatans.id_kec');

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
        $kantor->leftJoin($jTable4, 'kpp.id_daerah', '=', 'kecamatans.id_kec');

        if (!is_null($id)) {
            $kantor->where('kecamatans.id_kab', '=', $id);
        }

        switch ($type) {
            case 0:
                $kantor->whereRaw('kepengurusan.no_sk IS NULL');
                break;

            case 1:
                $kantor->whereRaw('kepengurusan.no_sk IS NOT NULL');
                break;
        }

        $data['kabupaten'] = Kabupaten::where('id_kab', '=', $id)->first();
        $data['pac'] = $kantor->get();
        $data['count'] = $data['pac']->count();
        $data['type'] = $type;
        $data['sk_yes'] = $kantor->whereRaw('kepengurusan.no_sk IS NOT NULL')->get()->count();
        $data['sk_no'] = $data['pac']->count() - $data['sk_yes'];

        return view('dpp.provinsi.rekap_pac', $data);
    }

    public function rekap_pac_single()
    {
        // Nomor SK
        $kp = DB::raw("(
            SELECT DISTINCT
                no_sk,
                id_daerah
            FROM
                `kepengurusan`
            WHERE
                `jabatan` = 4001 AND deleted_at IS NULL
            GROUP BY
            	`id_daerah`
        ) as kp");

        // Jumlah DPC
        $pac = DB::raw("(
            SELECT COUNT(`id_kantor`) AS `jml`,
                `kec`
            FROM
                `kantor`
            WHERE
                `id_tipe_daerah` = 4
            GROUP BY
                `kec`
        ) as pac");

        // Jumlah Pengurus
        $jp = DB::raw("(
            SELECT COUNT(`id_kepengurusan`) as `jml_p`, `id_daerah`
            FROM
                `kepengurusan`
                WHERE deleted_at IS NULL
            GROUP BY
            	`id_daerah`
        ) AS `jp`");

        $kantor = Kecamatan::selectRaw("
                kantor.id_kantor,
                kantor.alamat,
                kecamatans.name,
                kecamatans.id_kec,
                kp.no_sk,
                pac.jml,
                jp.jml_p
            ")
            ->leftJoin('kantor', function ($join) {
                $join->on('kecamatans.id_kec', '=', 'kantor.kec')->where('kantor.id_tipe_daerah', '=', 3);
            })
            ->leftJoin($kp, function ($join) {
                $join->on('kecamatans.id_kec', '=', 'kp.id_daerah');
            })
            ->leftJoin($pac, function ($join) {
                $join->on('pac.kec', '=', 'kecamatans.id_kec');
            })
            ->leftJoin($jp, function ($join) {
                $join->on('kecamatans.id_kec', '=', 'jp.id_daerah');
            });

        $data['kabupaten'] = null;
        $data['pac'] = $kantor->get();
        $data['type'] = null;
        $data['count'] = $data['pac']->count();
        $data['sk_yes'] = $kantor->whereRaw('kp.no_sk IS NOT NULL')->get()->count();
        $data['sk_no'] = $data['pac']->count() - $data['sk_yes'];

        return view('dpp.provinsi.rekap_pac', $data);
    }

    public function download_sk($id)
    {
        $kantor = Kantor::where('id_kantor', '=', $id)->first();
        $file = $this->path . 'file/no_sk/' . $kantor->no_sk;

        return response()->download($file);
    }

    public function download_domisili($id)
    {
        $kantor = Kantor::where('id_kantor', '=', $id)->first();
        $file = $this->path . 'file/domisili/' . $kantor->domisili;

        return response()->download($file);
    }

    public function download_ket_kantor($id)
    {
        $kantor = Kantor::where('id_kantor', '=', $id)->first();
        $file = $this->path . 'file/surat_keterangan_kantor/' . $kantor->surat_keterangan_kantor;

        return response()->download($file);
    }

    public function download_rek_bank($id)
    {
        $kantor = Kantor::where('id_kantor', '=', $id)->first();
        $file = $this->path . 'file/rekening_bank/' . $kantor->rekening_bank;

        return response()->download($file);
    }

    public function download_rekap_all($id)
    {
        $kantor = Kantor::leftJoin('tipe_daerah', 'tipe_daerah.id_tipe_daerah', '=', 'kantor.id_tipe_daerah')->where('id_kantor', '=', $id)->first();

        $zip = new \ZipArchive();
        $zipName = $this->path . '/rekap-dpp/' . strtoupper($kantor->nama_tipe . $kantor->id_daerah) . '.zip';
        if ($zip->open($zipName, \ZipArchive::CREATE) !== TRUE) {
            echo 'Could not open ZIP file.';
            return;
        }

        if (!is_null($kantor->no_sk) && file_exists($this->path . 'file/no_sk/' . $kantor->no_sk)) {
            $ext = pathinfo($this->path . 'file/no_sk/' . $kantor->no_sk);
            $zip->addFile($this->path . 'file/no_sk/' . $kantor->no_sk, 'SK/sk_' . $kantor->id_daerah . '.' . $ext['extension']);
        }

        if (!is_null($kantor->domisili) && file_exists($this->path . 'file/domisili/' . $kantor->domisili)) {
            $ext = pathinfo($this->path . 'file/domisili/' . $kantor->domisili);
            $zip->addFile($this->path . 'file/domisili/' . $kantor->domisili, 'DOMISILI/dom_' . $kantor->id_daerah . '.' . $ext['extension']);
        }

        if (!is_null($kantor->surat_keterangan_kantor) && file_exists($this->path . 'file/surat_keterangan_kantor/' . $kantor->surat_keterangan_kantor)) {
            $ext = pathinfo($this->path . 'file/surat_keterangan_kantor/' . $kantor->surat_keterangan_kantor);
            $zip->addFile($this->path . 'file/surat_keterangan_kantor/' . $kantor->surat_keterangan_kantor, 'SURAT KETERANGAN KANTOR/skk_' . $kantor->id_daerah . '.' . $ext['extension']);
        }

        if (!is_null($kantor->rekening_bank) && file_exists($this->path . 'file/rekening_bank/' . $kantor->rekening_bank)) {
            $ext = pathinfo($this->path . 'file/rekening_bank/' . $kantor->rekening_bank);
            $zip->addFile($this->path . 'file/rekening_bank/' . $kantor->rekening_bank, 'REKENING BANK/rek_' . $kantor->id_daerah . '.' . $ext['extension']);
        }

        $zip->close();

        return response()->download($zipName);
    }
}
