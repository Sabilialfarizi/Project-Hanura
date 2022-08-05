<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kabupaten, DetailUsers, Kecamatan};
use App\Kepengurusan;
use App\Kantor;
use App\User;
use DB;
use App\ArticleCategory as Category;

class ProvinsiController extends Controller
{
     private $path = '/www/wwwroot/siap.partaihanura.or.id/uploads/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);

        $provinsi = Provinsi::orderBy('id', 'asc')->get();

        return view('dpd.provinsi.index', compact('provinsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('category_create'), 403);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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


        return view('dpd.provinsi.show', compact('kabupaten', 'provinsi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name          = $request->name;
        $category->updated_by    = \Auth::user()->id;
        $category->updated_at    = date('Y-m-d H:i:s');
        $category->update();

        return redirect()->route('dpd.kategori.index')->with('success', 'Kategori Informasi Sudah di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        return redirect()->route('dpd.kategori.index')->with('success', 'Kategori Informasi Sudah di Delete');
    }

    public function rekap_dpc($type = -1)
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

        $prov = DetailUsers::select('provinsi_domisili')->where('userid', '=', auth()->user()->id)->first();

        $kantor->where('kabupatens.id_prov', '=', $prov->provinsi_domisili);

        switch ($type) {
            case 0:
                $kantor->whereRaw('kepengurusan.no_sk IS NULL');
                break;

            case 1:
                $kantor->whereRaw('kepengurusan.no_sk IS NOT NULL');
                break;
        }

        $data['provinsi'] = Provinsi::where('id_prov', '=', $prov->provinsi_domisili)->first();
        $data['id'] = $prov->provinsi_domisili ?? null;
        $data['dpc'] = $kantor->get();
        $data['count'] = $data['dpc']->count();
        $data['type'] = $type;
        $data['sk_yes'] = $kantor->whereRaw('kepengurusan.no_sk IS NOT NULL')->get()->count();
        $data['sk_no'] = $data['dpc']->count() - $data['sk_yes'];

        return view('dpd.provinsi.rekap_dpc', $data);
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
        } else {
            $prov = DetailUsers::select('provinsi_domisili')->where('userid', '=', auth()->user()->id)->first();
            $kantor->whereIn('id_kab', function ($query) use ($prov) {
                $query->select('id_kab')
                    ->from('kabupatens')
                    ->where('id_prov', '=', $prov->provinsi_domisili);
            });
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

        return view('dpd.provinsi.rekap_pac', $data);
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
