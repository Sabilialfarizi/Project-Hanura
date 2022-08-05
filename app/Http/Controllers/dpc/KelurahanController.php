<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kabupaten,Kelurahan, DetailUsers};
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\KelurahanExport;
use Maatwebsite\Excel\Facades\Excel;

class KelurahanController extends Controller
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

        $kabupaten = DetailUsers::where('userid',$id)->first();
  
        return view('dpc.kelurahan.index', compact('kabupaten'));
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

        $kelurahan = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
        ->join('users','detail_users.userid','=','users.id')
        ->where('detail_users.kelurahan_domisili', $id)
       ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
        ->groupBy('detail_users.nik')
        ->where('detail_users.status_kta', 1)->get();
        $detail = Kelurahan::where('id_kel', $id)->first();
        // dd($kabupaten);
        
        return view('dpc.kelurahan.show', compact('kelurahan','detail'));
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

        return redirect()->route('dpc.kategori.index')->with('success', 'Kategori Informasi Sudah di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
        public function export($id)
    {
        $kecamatan = Kelurahan::where('id_kel', $id)->first();
        $exporter = app()->makeWith(KelurahanExport::class, compact('id'));


        return $exporter->download($kecamatan->name .'.xlsx');
    }
    public function destroy($id)
    { 
        Category::where('id',$id)->delete();
        return redirect()->route('dpc.kategori.index')->with('success', 'Kategori Informasi Sudah di Delete');
    }
}
