<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Provinsi, Kelurahan , Kecamatan , DetailUsers};
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

              $id = auth()->user()->id;
    

        $DetailUsers = DetailUsers::where('userid',$id)->first();
     
  
        return view('dpd.kecamatan.index', compact('DetailUsers'));
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
         $kecamatan = DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
           ->join('users','detail_users.userid','=','users.id')
           ->where('detail_users.kecamatan_domisili', $id)
           ->where('detail_users.status_kta', 1)
           ->where(DB::raw('LENGTH(detail_users.no_member)'),'>',[18,20])
           ->groupBy('detail_users.nik')
           ->get();
         $detail = Kecamatan::where('id_kec', $id)->first();
      
        // dd($kabupaten);
        
        return view('dpd.kecamatan.show', compact('kecamatan','detail'));
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

        return redirect()->route('dpp.kategori.index')->with('success', 'Kategori Informasi Sudah di Update');
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
        return redirect()->route('dpp.kategori.index')->with('success', 'Kategori Informasi Sudah di Delete');
    }
}
