<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kabupaten , DetailUsers};
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        $id = Auth::user()->id;

        $provinsi = DetailUsers::where('userid', $id)->first();
  
        return view('dpc.provinsi.index', compact('provinsi'));
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

        return view('dpc.provinsi.create', compact('id_prov'));
       
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

        $request->validate([
            'id_prov' => 'required|unique:provinsis,id_prov',
            'name' => 'required',
            'zona_waktu' => 'required',
        ],
        [
            'id_prov.required' => 'Kode Provinsi tidak boleh kosong',
            'id_prov.unique' => 'Kode Provinsi sudah ada',
            'name.required' => 'Nama Provinsi tidak boleh kosong',
            'zona_waktu.required' => 'Zona Waktu tidak boleh kosong',
        ]);

        Provinsi::create([
            'id_prov' => $request->id_prov,
            'name' => $request->name,
            'zona_waktu' => $request->zona_waktu,
        ]);

        return redirect()->route('dpc.provinsi.index')->with('success', 'Pembatalan Anggota Sukses DiBuata'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $provinsi = Kabupaten::where('id_prov',$id)->groupBy('id_kab')->get();

        $kabupaten = Provinsi::where('id_prov', $id)->first();
        
        return view('dpc.provinsi.show', compact('kabupaten','provinsi'));
    }
    
         public function showData($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $kabupaten = DetailUsers::where('kabupaten_domisili', $id)->get();
         $detail = Kabupaten::where('id_kab', $id)->first();
 
   
        return view('dpc.provinsi.show', compact('kabupaten','detail'));
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
        $prov = Provinsi::where('id_prov',$request->id_prov)->get();
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

      
        $anggota = DetailUsers::groupBy('nickname')->where('status_kta',1)->pluck('nickname','id');
        return view('dpc.provinsi.edit', compact('anggota','provinsi'));
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
        $request->validate([
            'id_prov' => 'required|unique:provinsis,id_prov',
            'name' => 'required',
            'zona_waktu' => 'required',
        ],
        [
            'id_prov.required' => 'Kode Provinsi tidak boleh kosong',
            'id_prov.unique' => 'Kode Provinsi sudah ada',
            'name.required' => 'Nama Provinsi tidak boleh kosong',
            'zona_waktu.required' => 'Zona Waktu tidak boleh kosong',
        ]);

        Provinsi::find($id)->update([
            'id_prov' => $request->id_prov,
            'name' => $request->name,
            'zona_waktu' => $request->zona_waktu,
        ]);

        return redirect()->route('dpc.provinsi.index')->with('success', 'Ketua Anggota Sukses DiBuat'); 
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
        
        return redirect()->route('dpc.provinsi.index')->with('success', 'Provinsi berhasil dihapus');
    }
}