<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, DetailUsers, Kabupaten , Kecamatan, Kepengurusan};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PengurusController extends Controller
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
        $detail= DetailUsers::where('userid',$id)->first();
        $provinsi = DB::table('kantor')->where('id_daerah',$detail->provinsi_domisili)->first();
        $kabupaten = Kabupaten::join('kantor','kabupatens.id_kab','=','kantor.id_daerah')
        ->where('kabupatens.id_prov', $detail->provinsi_domisili)
        ->select('kabupatens.id_kab','kabupatens.name','kantor.alamat','kantor.no_telp','kantor.email','kantor.fax','kantor.rt_rw')
        ->orderBy('kabupatens.id_kab','asc')
        ->get();
      
      
        $kel= DetailUsers::where('userid',$id)->value('provinsi_domisili');
        
        $ketua = Kepengurusan::where(DB::raw('substr(id_daerah, 1, 2)  '), '=', $detail->provinsi_domisili)
            ->whereBetween('jabatan',array(3001,3003))
            ->orderBy('id_daerah','asc')
            ->get();

     
        $sekre = Kepengurusan::where(DB::raw('substr(id_daerah, 1, 2)  '), '=', $detail->provinsi_domisili)
            
            ->where('jabatan', 3002)
            ->orderBy('id_daerah','asc')
            ->get();
            
        $benda = Kepengurusan::where(DB::raw('substr(id_daerah, 1, 2)  '), '=', $detail->provinsi_domisili)
         
            ->where('jabatan', 3003)
            ->orderBy('id_daerah','asc')
            ->get();
       
      
    
          $penguruspusat =  DB::table('kepengurusan')->where('id_daerah', 0)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
            ->where('kepengurusan.deleted_at',null)
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.foto')
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
       
        
        return view('dpd.pengurus.index', compact('provinsi','penguruspusat','kabupaten','ketua','sekre','benda','detail'));
    }
    public function show($id)
    {
       
        $kabupaten= Kabupaten::where('id_kab',$id)->first();

        $detail = Kepengurusan::leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
        ->leftJoin('kabupatens','kepengurusan.id_daerah','=','kabupatens.id_kab')
        ->whereBetween('kepengurusan.jabatan', [3001,3003])
        ->where('kepengurusan.id_daerah', $id)
        ->where('kepengurusan.deleted_at',null)
        ->orderBy('jabatans.kode','asc')
        ->select('kepengurusan.ttd','kepengurusan.id_daerah','kabupatens.name as nama_kabupaten','kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto')
        ->groupBy('kepengurusan.id_kepengurusan')
        ->get();
        
             $penguruspusat =  DB::table('kepengurusan')->where('id_daerah', 0)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
            ->where('kepengurusan.deleted_at',null)
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
      
        
        return view('dpd.pengurus.show', compact('detail','kabupaten','penguruspusat'));
    }

}
