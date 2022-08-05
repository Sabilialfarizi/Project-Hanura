<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('information_access'), 403);

        $pekerjaan = DB::table('jobs')->get();
        // dd($program);
        return view('dpp.pekerjaan.index', compact('pekerjaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
        return view('dpp.pekerjaan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
          $pekerjaan = DB::table('jobs')->insert([
            'name' => $request->name,
            'status' => $request->status,
            'created_by'    => Auth::user()->id,
            'created_at'    => date('Y-m-d H:i:s')
        ]);
  

         return redirect()->route('dpp.pekerjaan.index')->with('success', 'Pekerjaan Sudah Dibuat');

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
        $pekerjaan = DB::table('jobs')->find($id);

        return view('dpp.pekerjaan.edit', compact('pekerjaan'));
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
    
    $pekerjaan = DB::table('jobs')->where('id', $id)->update([
        'name' => $request->name,
        'status' => $request->status,
        'updated_by'    => Auth::user()->id,
        'updated_at' => date('Y-m-d H:i:s')
         ]);
       
  

        return redirect()->route('dpp.pekerjaan.index')->with('success', 'Pekerjaan Sudah di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $informasi = DB::table('jobs')->where('id',$id)->delete();

       return redirect()->route('dpp.pekerjaan.index')->with('success', 'Jabatan Sudah di Delete');
    }
}
