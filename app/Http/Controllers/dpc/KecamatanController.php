<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kelurahan , Kecamatan, DetailUsers};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\KecamatanExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $id = auth()->user()->id;
    

        $DetailUsers = DetailUsers::where('userid',$id)->first();
     
  
        return view('dpc.kecamatan.index', compact('DetailUsers'));
    }
            public function export($id)
    {
        $kecamatan = Kecamatan::where('id_kec', $id)->first();
        $exporter = app()->makeWith(KecamatanExport::class, compact('id'));


        return $exporter->download($kecamatan->name .'.xlsx');
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
    public function show( $id)
    {
         $kecamatan = DetailUsers::join('users','detail_users.userid','=','users.id')
         ->join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->where('detail_users.kecamatan_domisili', $id)
         ->where('detail_users.status_kta', 1)
        ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
          ->groupBy('detail_users.nik')
         ->get();
    
         $detail = Kecamatan::where('id_kec', $id)->first();
      
        // dd($kabupaten);
        
        return view('dpc.kecamatan.show', compact('kecamatan','detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function kuota($id)
    {
         $kecamatan = Kecamatan::where('id_kec',$id)->first();
         $detail = Kecamatan::where('id_kec', $id)->first();
         return view('dpc.kecamatan.edit', compact('kecamatan','detail'));
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
            'kuota' => 'required',
        ],
        [
            
            'kuota.required' => 'Kuota tidak boleh kosong',
        ]);

       $kecamatan =  Kecamatan::where('id',$id)->update([
            'kuota' => $request->kuota,
        ]);
      

        return redirect()->route('dpc.kecamatan.index')->with('success', ' Sukses DiBuat'); 
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        Category::where('id',$id)->delete();
        return redirect()->route('dpc.kategori.index')->with('success', 'Kategori Informasi Sudah di Delete');
    }
}
