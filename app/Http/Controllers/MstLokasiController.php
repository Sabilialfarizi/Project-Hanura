<?php

namespace App\Http\Controllers;

use App\Models\mst_lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MstLokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer',
        ]);

        //$employees = MstEmployee::orderBy('name')->paginate(8);

        $lokasi = DB::table('lokasi')
        ->when($request->keyword, function ($query) use ($request) {
            $query->where('nama', 'like', "%{$request->keyword}%") ; // or by name
        })->paginate($request->limit ? $request->limit : 20);

        $lokasi->appends($request->only('keyword'));

        return view('mst_lokasi.index', compact('lokasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('mst_lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string'],
            'latitude' => ['required', 'string', 'max:20'],
            'longitude' => ['required', 'string', 'max:20'],

        ]);

        mst_lokasi::create($request->all());

        Alert::success('Success', 'Data berhasil ditambahkan');
        return redirect()->route('MstLokasi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mst_lokasi  $mst_lokasi
     * @return \Illuminate\Http\Response
     */
    public function show(mst_lokasi $mst_lokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mst_lokasi  $mst_lokasi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $list = mst_lokasi::findOrFail($id);

        return view('mst_lokasi.edit', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mst_lokasi  $mst_lokasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'nama' => ['required', 'string', 'max:20'],
            'latitude' => ['required', 'string', 'max:20'],
            'longitude' => ['required', 'string', 'max:20'],

        ]);

        mst_lokasi::find($id)->update($request->all());

        Alert::success('Success', 'Data berhasil ditambahkan');
        return redirect()->route('MstLokasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mst_lokasi  $mst_lokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        mst_lokasi::findOrFail($id)->delete();

        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('MstLokasi.index');
    }

     // for mobile
     public function getLokasi(Request $req){

        $data = mst_lokasi::
        select( "*",
        DB::raw("(6371 * acos(cos(radians($req->user_latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($req->user_longitude)) + sin(radians($req->user_latitude)) * sin(radians(latitude)))) AS jarak "))
        ->having('jarak' ,'<',1)
        ->first();
        if ($data !=null) {
        $response       = [ 'statusCode'=>200,
        'message' => $data->nama ];
        } else {
            $response   = [ 'statusCode'=>202,
            'message' => 'Not in office range',
           ];
        }


        return response()->json(['result'=>$response], 200);
    }
}
