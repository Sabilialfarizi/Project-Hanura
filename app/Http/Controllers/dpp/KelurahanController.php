<?php

namespace App\Http\Controllers\dpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Kelurahan, Kecamatan};

class KelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_kec)
    {
        $kecamatan = Kecamatan::where('id_kec', $id_kec)->first();
        $max_id_kel = Kelurahan::where('id_kec', $id_kec)->max('id_kel');
        $id_kel = $max_id_kel !== null ? $max_id_kel + 1 : $id_kec . '001';
    
        return view('dpp.kelurahan.create', compact('kecamatan', 'id_kel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'id_kec' => 'required',
            'id_kel' => 'required|unique:kelurahans,id_kel',
            'name' => 'required',
            'id_wilayah' => 'required',
            'id_kpu' => 'required'
        ],
        [
            'id_kec.required' => 'Kode Kecamatan harus diisi',
            'id_kpu.required' => 'Kode KPU harus diisi',
            'id_kel.required' => 'Kode Kelurahan harus diisi',
            'id_kel.unique' => 'Kode Kelurahan sudah ada',
            'name.required' => 'Nama Kelurahan harus diisi',
            'id_wilayah.required' => 'Kode Wilayah harus diisi',
        ]);

        $kelurahan = array([
            'id_kec' => $request->id_kec,
            'id_kpu' => $request->id_kpu,
            'id_kel' => $request->id_kel,
            'name' => $request->name,
            'id_wilayah' => $request->id_wilayah,
        ]);

        
        $kel = Kelurahan::insert($kelurahan);
       

        return redirect("/dpp/provinsi/$request->id_kec/kelurahan")->with('success','Data berhasil dibuat');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_kec, $id_kel)
    {
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_kec, $id_kel)
    {
        $kecamatan = Kecamatan::where('id_kec', $id_kec)->first();
        $kelurahan = Kelurahan::where('id_kel', $id_kel)->first();
      
        
        return view('dpp.kelurahan.edit', compact('kecamatan', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id_kec, $id_kel, Request $request)
    {
         $request->validate([
            'id_kec' => 'required',
            'id_kel' => 'required',
            'name' => 'required',
            'id_wilayah' => 'required',
            'id_kpu' => 'required'
        ],
        [
            'id_kec.required' => 'Kode Kecamatan harus diisi',
            'id_kpu.required' => 'Kode KPU harus diisi',
            'id_kel.required' => 'Kode Kelurahan harus diisi',
            // 'id_kel.unique' => 'Kode Kelurahan sudah ada',
            'name.required' => 'Nama Kelurahan harus diisi',
            'id_wilayah.required' => 'Kode Wilayah harus diisi',
        ]);

        $kelurahan = Kelurahan::where('id_kel', $id_kel)->update([
            'id_kec' => $request->id_kec,
            'id_kpu' => $request->id_kpu,
            'id_kel' => $request->id_kel,
            'name' => $request->name,
            'id_wilayah' => $request->id_wilayah,
        ]);
   

        return redirect("/dpp/provinsi/$request->id_kec/kelurahan")->with('success','Data berhasil dibuat');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_kec, $id_kel)
    {
        Kelurahan::where('id_kel', $id_kel)->delete();

         return redirect("/dpp/provinsi/$id_kec/kelurahan")->with('success','Data berhasil dibuat');
    }
}