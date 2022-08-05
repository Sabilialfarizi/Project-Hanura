<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kabupaten , DetailUsers};
use App\Exports\KabupatenExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
   
        $detail = DetailUsers::where('userid', $id)->orderBy('id','asc')->select('kabupaten_domisili')->first();
   

        $kabupaten = Kabupaten::whereIn('id_kab', $detail)->first();
     
        $provinsi = Provinsi::where('id_prov', $kabupaten->id_prov)->first();
   
  
        return view('dpd.kabupaten.index', compact('kabupaten','detail','provinsi'));
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
    public function export($id) 
    {
        $exporter = app()->makeWith(KabupatenExport::class, compact('id'));   
        return $exporter->download('Pemilu.xlsx');
    }
     public function show( $id)
    {
         $kabupaten = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
         ->join('users','detail_users.userid','=','users.id')
         ->where('detail_users.kabupaten_domisili', $id)
         ->where('detail_users.status_kta', 1)
         ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
          ->groupBy('detail_users.nik')
         ->get();

         $detail = Kabupaten::where('id_kab', $id)->first();
      
        // dd($kabupaten);
        
        return view('dpd.kabupaten.show', compact('kabupaten','detail'));
    }

  
}
