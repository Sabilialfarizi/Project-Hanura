<?php

namespace App\Http\Controllers\Dpc;

use Illuminate\Http\Request;
use App\{Pembatalan, DetailUsers, User};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class RestoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        

       $id = User::where('users.id',Auth()->user()->id)
        ->leftJoin('detail_users','detail_users.userid','=','users.id')
        ->select('kabupaten_domisili')
        ->first();
        $pembatalan = DetailUsers::orderBy('id', 'asc')->where('status_kta',4)->get();
        $nik = DetailUsers::where('kabupaten_domisili', $id->kabupaten_domisili)
        ->where(function($query){
             $query->whereBetween('status_kta', array(0,1,2,3,5));
             $query->orwhere('status_kta','=', 1);
        })
        ->groupBy('nik')
        ->get('nik');

        return view('dpc.restore.index', compact('pembatalan','nik'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);
        $detail =User::leftJoin('detail_users','users.id','=','detail_users.userid')
        ->join('model_has_roles','users.id','=','model_has_roles.model_id')
        ->join('roles','model_has_roles.role_id','=','roles.id')
        ->where('detail_users.no_member',$id)->first();
         
        $member = User::leftJoin('detail_users','users.id','=','detail_users.userid')->where('detail_users.no_member',$id)->first();
        // dd($member);



        return view('dpc.restore.show', compact('member', 'detail'));
    }
     public function updateaktif(Request $request)
    {
        // dd($request->ids);
        $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_kta' => 1
            )); 
        $pembatalan = Pembatalan::whereIn('id_anggota', $request->ids)->delete();

      return redirect()->route('dpc.restore.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
      public function updatenonaktif(Request $request)
    {
     
        $pembatalan = Pembatalan::whereIn('id_anggota', $request->ids)->delete();
          $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_kta' => 5
            )); 
        
      return redirect()->route('dpc.restore.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
    
  
    public function destroy($id)
    { 
        $detail = DetailUsers::where('id', $id)->get();
        $pembatalan = Pembatalan::where('id_anggota', $id)->delete();
          foreach ($detail as $det) {
             $update = DetailUsers::where('id', $det->id)->update(array(
            'status_kta' => 5
            ));
        }
        return redirect()->route('dpc.restore.index')->with('success', 'Anggota Sudah di Delete');
    }
}
