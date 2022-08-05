<?php

namespace App\Http\Controllers\Dpc;

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
          $kabupaten = DB::table('kantor')->where('id_daerah',$detail->kabupaten_domisili)->first();
          
          $pengurus = DB::table('kepengurusan')->where('id_daerah',$detail->kabupaten_domisili)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','jabatans.urutan','kepengurusan.nik','kepengurusan.foto','kepengurusan.ttd')
            ->where('kepengurusan.deleted_at',null)
          ->orderBy('jabatans.kode','asc')
          ->groupBy('kepengurusan.id_kepengurusan')
          ->get();
          
          $pengurusDPD =  DB::table('kepengurusan')->where('id_daerah',$detail->provinsi_domisili)
          ->leftJoin('jabatans','kepengurusan.jabatan','=','jabatans.kode')
          ->select('kepengurusan.nama as name','kepengurusan.kta','jabatans.nama','kepengurusan.nik','jabatans.urutan')
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
       
        
        return view('dpc.user.index', compact('kabupaten','pengurus','pengurusDPD','penguruspusat','detail'));
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
    public function destroy($id)
    { 
        Category::where('id',$id)->delete();
        return redirect()->route('dpc.kategori.index')->with('success', 'Kategori Informasi Sudah di Delete');
    }
}
