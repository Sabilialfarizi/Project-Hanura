<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Information;
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('information_access'), 403);

        $jabatan = DB::table('jabatans')
        ->join('tipe_daerah','jabatans.tipe_daerah','=','tipe_daerah.id_tipe_daerah')
        ->get();
        // dd($program);
        return view('dpp.jabatan.index', compact('jabatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('information_create'), 403);
        $tipe = DB::table('tipe_daerah')->where('is_active', 1)->pluck('nama_tipe', 'id_tipe_daerah');
        
        return view('dpp.jabatan.create', compact('tipe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $jab = DB::table('jabatans')->where('kode', $request->kode)->first();
     if($jab == null){
          
          $info = DB::table('jabatans')->insert([
            'kode'   => $request->kode,
            'nama'          => $request->nama,
            'status'       => $request->status,
            'tipe_daerah'        => $request->tipe_daerah,
            'urutan'        => $request->urutan,
            'is_active'     => 1,
            'created_at'    => date('Y-m-d H:i:s')
        ]);
         return redirect()->route('dpp.jabatan.index')->with('success', 'Jabatan Sudah di Create');
         
        
     }else{
         
         return redirect()->route('dpp.jabatan.create')->with('success', 'Kode Jabatan Sudah Dibuat');
     }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jabatan = DB::table('jabatans')->find($id);

        $tipe = DB::table('tipe_daerah')->where('is_active', 1)->pluck('nama_tipe', 'id_tipe_daerah');
        return view('dpp.jabatan.edit', compact('jabatan','tipe'));
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
     $jabatan = DB::table('jabatans')->where('id', $id)->update([
        'kode' => $request->kode,
        'nama' => $request->nama,
        'tipe_daerah' => $request->tipe_daerah,
        'status' => $request->status,
        'urutan' => $request->urutan,
        'updated_at' => date('Y-m-d H:i:s')
         ]);
  

        return redirect()->route('dpp.jabatan.index')->with('success', 'Jabatan Sudah di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $informasi = DB::table('jabatans')->where('id',$id)->delete();

       return redirect()->route('dpp.jabatan.index')->with('success', 'Informasi Sudah di Delete');
    }
}
