<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kelurahan , DetailUsers};
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowDataKecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // abort_unless(\Gate::allows('category_access'), 403);

      $kabupaten = DetailUsers::where('kelurahan_domisili', $id)->where('status_kta', 1)->get();
   
        $detail = Kelurahan::where('id_kel', $id)->first();
 
   
        return view('dpp.kecamatan.showData', compact('kabupaten','detail'));
    }

 
  
         public function showData($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $kabupaten = DetailUsers::where('kelurahan_domisili', $id)->get();

       
         $detail = Kelurahan::where('id_kel', $id)->first();
 
   
        return view('dpp.kabupaten.show', compact('kabupaten','detail'));
    }
    
         public function showKelurahan($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);
        

         $kelurahan = DetailUsers::join('users','detail_users.userid','=','users.id')
                  ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                  ->where('detail_users.kelurahan_domisili', $id)
                  ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                  ->where('detail_users.status_kta', 1)
                  ->groupBy('detail_users.nik')
                  ->get();
       
       
         $detail = Kelurahan::where('id_kel', $id)->first();
 
   
        return view('dpp.kecamatan.datakelurahan', compact('kelurahan','detail'));
    }
    

}
