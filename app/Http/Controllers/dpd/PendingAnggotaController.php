<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{DetailUsers, Pembatalan};
use App\ArticleCategory as Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendingAnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);

        $category = DetailUsers::orderBy('id', 'desc')->get();
  
        return view('dpd.pending.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('category_create'), 403);
        
        return view('dpd.pending.create');
    }
    
    public function update($id, Request $request)
    {
    
       
       
        $detail = DB::table('detail_users')->where('id', $id)->update(array( 
            'status_kta' => 1,
             'created_by' => \Auth::user()->id,
             'created_at' =>$request->tgl_pengesahan));
         

            return redirect()->route('dpd.pending.index')->with('success', 'Pengesahan Anggota Sukses DiBuat');
    }

 
    public function store(Request $request)
    {   
        $pembatalan = Pembatalan::create([
            'id_anggota'        => $request->id_anggota,
            'alasan_pembatalan' => $request->alasan_pembatalan,
            'created_by'    => \Auth::user()->id,
            'status'        => 2,
            'created_at'    => date('Y-m-d H:i:s')
        ]);

         $detail = DetailUsers::where('id',$request->id_anggota)->update([

             'status_kta' => 2,
             'created_by' => \Auth::user()->id,
             'created_at' =>date('Y-m-d H:i:s')]);

        return redirect()->route('dpd.pending.index')->with('success', 'Pengesahan Anggota Dibatalkan Sukses DiBuat');
    }
     public function updateaktif(Request $request)
     {
    
 
        $detail = DB::table('detail_users')->whereIn('id', $request->ids)->update(array( 
            'status_kta' => 1,
            'created_by' => \Auth::user()->id,
            'created_at' =>$request->tgl_pengesahan));
  
      return redirect()->route('dpd.pending.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
      public function updatenonaktif(Request $request)
    {
         \DB::beginTransaction();
        $anggota = DetailUsers::whereIn('id', $request->ids)->get();
      
        $attr = [];
        
      
        $checked_array = $request->ids;
        // dd($checked_array);
        
        foreach ($checked_array as $data => $key){
        $attr [] = [
            'id_anggota'        => $key,
            'alasan_pembatalan' => $request->alasan_pembatalan,
            'created_by'    => \Auth::user()->id,
            'status'        => 2,
            'created_at'    => date('Y-m-d H:i:s')
        ];
       
        
         $detail = Pembatalan::insert($attr);
        \DB::commit();
        
         $detail = DetailUsers::whereIn('id',$request->ids)->update(array(

             'status_kta' => 2,
             'created_by' => \Auth::user()->id,
             'created_at' =>date('Y-m-d H:i:s')));
        }
      
      return redirect()->route('dpd.restore.index')->with('success', 'Kategori Informasi Sudah di Update');
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
        // abort_unless(\Gate::allows('category_edit'), 403);
        $pending = DetailUsers::find($id);
     
        
        return view('dpd.pending.edit', compact('pending'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
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
