<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, DetailUsers, Kabupaten , Kecamatan};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
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
        //   dd($detail);
          $provinsi = DB::table('kantor')->where('id_daerah',$detail->provinsi_domisili)->first();
        
        //   dd($provinsi);
          
          $pengurus = DB::table('kepengurusan')->where('id_daerah',$detail->kabupaten_domisili)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','kepengurusan.nik','jabatans.urutan','kepengurusan.foto')
            ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
          
          $pengurusDPD =  DB::table('kepengurusan')->where('id_daerah',$detail->provinsi_domisili)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.ttd','kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto')
            ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
  
          
          $penguruspusat =  DB::table('kepengurusan')->where('id_daerah', 0)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
            ->where('kepengurusan.deleted_at',null)
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','kepengurusan.nik','jabatans.urutan')
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
       
        
        return view('dpd.user.index', compact('provinsi','pengurus','pengurusDPD','penguruspusat','detail'));
    }


}
