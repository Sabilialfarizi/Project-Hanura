<?php

namespace App\Http\Controllers\Dpc;

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
 
   
        return view('dpc.kecamatan.showData', compact('kabupaten','detail'));
    }

 
  
         public function showData($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $kabupaten = DetailUsers::where('kelurahan_domisili', $id)->get();
       
         $detail = Kelurahan::where('id_kel', $id)->first();
 
   
        return view('dpc.kabupaten.show', compact('kabupaten','detail'));
    }
    
         public function showKelurahan($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);

         $kelurahan = DetailUsers::where('kelurahan_domisili', $id)->where('status_kta', 1)->get();
    
       
         $detail = Kelurahan::where('id_kel', $id)->first();
 
   
        return view('dpc.kecamatan.datakelurahan', compact('kelurahan','detail'));
    }
    

}
