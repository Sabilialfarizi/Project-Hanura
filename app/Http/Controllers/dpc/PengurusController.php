<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, DetailUsers, Kabupaten , Kecamatan};
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
      
          $kabupaten = DB::table('kantor')->where('id_daerah',$detail->kabupaten_domisili)->first();
          
          $pengurus = DB::table('kepengurusan')->where('id_daerah',$detail->kabupaten_domisili)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto')
            ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
    
          
          $pengurusDPD =  DB::table('kepengurusan')->where('id_daerah',$detail->provinsi_domisili)
          ->leftJoin('provinsis','kepengurusan.id_daerah','=','provinsis.id_prov')
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('provinsis.name as provinsi','kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
            ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
          
          
          $penguruspusat =  DB::table('kepengurusan')->where('id_daerah', 0)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
            ->where('kepengurusan.deleted_at',null)
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
       
        
        return view('dpc.pengurus.index', compact('kabupaten','pengurus','pengurusDPD','penguruspusat','detail'));
    }

}
