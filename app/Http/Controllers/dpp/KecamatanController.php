<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kelurahan, Kecamatan, Kabupaten, DetailUsers};
use App\Exports\{PACExport, PACExport_hp};
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // abort_unless(\Gate::allows('category_access'), 403);

        $kecamatan = Kecamatan::orderBy('id', 'asc')->get();


        return view('dpp.kecamatan.index', compact('kecamatan'));
    }
    public function export($id)
    {

        $kecamatan = Kecamatan::where('id_kec', $id)->first();

        $exporter = app()->makeWith(PACExport::class, compact('id'));

        return $exporter->download("Kecamatan_" . $kecamatan->name . ".xls");
    }

    public function exports()
    {
        $id = 640712;

        $kecamatan = Kecamatan::where('id_kec', $id)->first();
        $kabupaten = Kabupaten::where('id_kab', $kecamatan->id_kab)->first();
        $provinsi = Provinsi::where('id_prov', $kabupaten->id_prov)->first();
        $detail = DetailUsers::leftJoin('users', 'detail_users.userid', '=', 'users.id')
            ->leftJoin('jenis_kelamin', 'detail_users.gender', '=', 'jenis_kelamin.id')
            ->leftJoin('jobs', 'detail_users.pekerjaan', '=', 'jobs.id')
            ->leftJoin('kelurahans', 'kelurahans.id_kel', '=', 'detail_users.kelurahan_domisili')
            ->leftJoin('status_pernikahans', 'detail_users.status_kawin', '=', 'status_pernikahans.id')
            ->where('detail_users.status_kta', 1)
            ->where('detail_users.status_kpu', 2)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->where('detail_users.kecamatan_domisili', $id)
            ->orderBy('detail_users.kelurahan_domisili', 'asc')
            //  ->groupBy(['detail_users.no_member', 'detail_users.nik'])
            ->groupBy('detail_users.nik')
            ->select(
                'detail_users.no_member',
                'detail_users.created_by as pegawai',
                'detail_users.kabupaten_domisili',
                'detail_users.nickname',
                'detail_users.nik',
                'jenis_kelamin.name as gender',
                'detail_users.birth_place',
                'detail_users.tgl_lahir',
                'status_pernikahans.nama',
                'jobs.name',
                'detail_users.alamat',
                'detail_users.kelurahan_domisili',
                'kelurahans.id_kpu'
            )->get();


        return view('excel_test', [
            'details' => $detail,
            'kecamatan' => $kecamatan,
            'kabupaten' => $kabupaten,
            'provinsi'  => $provinsi,
        ]);
    }

    public function export_hp($id)
    {

        $kecamatan = Kecamatan::where('id_kec', $id)->first();

        $exporter = app()->makeWith(PACExport_hp::class, compact('id'));


        return $exporter->download("Kecamatan_" . $kecamatan->name . "_hp.xls");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // abort_unless(\Gate::allows('category_create'), 403);


        $kabupaten = Kabupaten::where('id_kab', $id)->where('status', 1)->pluck('name', 'id_kab');

        return view('dpp.kecamatan.create', compact('kabupaten', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'id_kab' => 'required',
                'name' => 'required',
                'id_kec' => 'required|unique:kecamatans,id_kec',
            ],
            [
                'id_kab.required' => 'Kode Kabupaten harus diisi',
                'name.required' => 'Nama Kecamatan harus diisi',
                'id_kec.required' => 'Kode Kecamatan harus diisi',
                'id_kec.unique' => 'Kode Kecamatan sudah ada',
            ]
        );

        Kecamatan::create([
            'id_kab' => $request->id_kab,
            'name' => $request->name,
            'id_kec' => $request->id_kec,
        ]);

        return redirect("/dpp/provinsi/$request->id_kab/kecamatan")->with('success', 'Data berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kecamatan = Kelurahan::where('id_kec', $id)->groupBy('id_kel')->get();

        $kelurahan = Kecamatan::where('id_kec', $id)->first();
        $id_kec = Kecamatan::where('id_kec', $id)->pluck('id_kec');

        return view('dpp.kecamatan.show', compact('kecamatan', 'kelurahan', 'id_kec', 'id'));
    }
    public function showkecamatan($id)
    {
        // abort_unless(\Gate::allows('category_access'), 403);

        $kabupaten = DetailUsers::join('users', 'detail_users.userid', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('detail_users.kecamatan_domisili', $id)
            ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
            ->select('detail_users.*')
              ->where('detail_users.status_kta', 1)
              ->groupBy('detail_users.nik')
              ->get();
      

        $detail = Kecamatan::where('id_kec', $id)->first();


        return view('dpp.kecamatan.showData', compact('kabupaten', 'detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kabupaten = Kabupaten::where('status', 1)->pluck('name', 'id_kab');
        $kecamatan = Kecamatan::find($id);

        return view('dpp.kecamatan.edit', compact('kabupaten', 'kecamatan'));
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
        // $category = Category::find($id);
        // $category->name          = $request->name;
        // $category->updated_by    = \Auth::user()->id;
        // $category->updated_at    = date('Y-m-d H:i:s');
        // $category->update();

        // return redirect()->route('dpp.kategori.index')->with('success', 'Kategori Informasi Sudah di Update');

        $request->validate(
            [
                'id_kab' => 'required',
                'name' => 'required',
                'id_kec' => 'required',
            ],
            [
                'id_kab.required' => 'Kode Kabupaten harus diisi',
                'name.required' => 'Nama Kecamatan harus diisi',
                'id_kec.required' => 'Kode Kecamatan harus diisi',
                // 'id_kec.unique' => 'Kode Kecamatan sudah ada',
            ]
        );

        Kecamatan::find($id)->update([
            'id_kab' => $request->id_kab,
            'name' => $request->name,
            'id_kec' => $request->id_kec,
        ]);

        return redirect("/dpp/provinsi/$request->id_kab/kecamatan")->with('success', 'Data berhasil dibuat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,  Request $request)
    {

        $id_kec = Kecamatan::where('id', $id)->first();
        $kecamatan = Kecamatan::find($id)->delete();

        return redirect("/dpp/provinsi/$id_kec->id_kab/kecamatan")->with('success', 'Data berhasil dibuat');
    }
}
