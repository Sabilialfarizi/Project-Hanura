<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User,DetailUsers,MaritalStatus,Job,Provinsi,Kepengurusan,Kabupaten,Kecamatan,Kelurahan,Kantor};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class GeneratedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    
        $kecamatan = Kecamatan::where('kecamatans.id_kec', $id)
        ->first();
    
        return view('dpc.kecamatan.generated',compact('kecamatan'));
    }
    
    
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     
      public function ajax_generated(Request $request, $id)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $kabupaten = DetailUsers::whereBetween('created_at', array($request->from_date, $request->to_date))->orderBy('kabupaten_domisili', 'asc')->get();
            } else {
                 $kabupaten = User::join('detail_users', 'users.id', '=', 'detail_users.userid')
                    ->selectRaw('detail_users.id,users.created_at,detail_users.nik,detail_users.waktu_generate, detail_users.nickname, detail_users.kelurahan_domisili, detail_users.kecamatan_domisili')
                    ->where('detail_users.kecamatan_domisili', $id)
                    ->where('detail_users.status_kta', 1)
                    ->where('detail_users.status_generate', 2)
                    ->where(DB::raw('LENGTH(detail_users.no_member)'), '>', [18, 20])
                    ->groupBy('detail_users.nik')
                    ->orderBy('detail_users.id', 'desc')
                    ->get();
            }
    

            return datatables()
                ->of($kabupaten)
             
                ->editColumn('nik', function ($kabupaten) {
                    return $kabupaten->nik;
                })
                ->editColumn('name', function ($kabupaten) {
                    return $kabupaten->nickname;
                })
                ->editColumn('tgl_input', function ($kabupaten) {
                    return Carbon::parse($kabupaten->created_at)->format('d/m/Y');
                
                })
                ->editColumn('tgl_generated', function ($kabupaten) {
                   return Carbon::parse($kabupaten->waktu_generate)->format('d/m/Y');
                })
                ->editColumn('id_kelurahan', function ($kabupaten) {
                    return $kabupaten->kelurahan_domisili;
                })
       

                ->addIndexColumn()
                ->rawColumns(['name'])
                ->make(true);
        }
    }
    public function show(Request $request)
    {
        $data = [];
        $ids = null;
        if ($request->id) {
            if (is_array($request->id)) {
                $ids = $request->id;
            } else {
                $ids = explode(',', $request->id);
            }
        }
 
 
        
        $detail = DetailUsers::whereIn('detail_users.id', ($request->ids) ? $request->ids : $ids)
            ->update([
                'status_generate' => 0
                ]);
        $kecamatan = DetailUsers::whereIn('detail_users.id', ($request->ids) ? $request->ids : $ids)
            ->first();

            
        $message = 'succes';
         return redirect('/dpc/kecamatan/'.$kecamatan->kecamatan_domisili.'/generated')->with('message', 'sukses');;
    }
   
}
