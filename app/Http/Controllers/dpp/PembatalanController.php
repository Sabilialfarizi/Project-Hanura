<?php

namespace App\Http\Controllers\Dpp;

use Illuminate\Http\Request;
use App\{Pembatalan, DetailUsers, User};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PembatalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        

        $pembatalan = Pembatalan::orderBy('id', 'asc')->get();
  
        return view('dpp.pembatalan.index', compact('pembatalan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(\Gate::allows('category_create'), 403);
        
        $pembatalan = DetailUsers::groupBy('nickname')->where('status_kta',1)->get();
        return view('dpp.pembatalan.create', compact('pembatalan'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDelete(Request $request , $id)
    {
         $pembatalan = Pembatalan::where('id_anggota', $id)->delete();
          $detail = DetailUsers::where('id',$id)->update([

             'status_kta' => 4]);
          

        return redirect()->route('dpp.pembatalan.index')->with('success', 'Pembatalan Anggota Sukses DiBuat');
       
    }
    public function update(Request $request , $id)
    {
     
        $pembatalan = Pembatalan::where('id_anggota', $id)->delete();
         $detail = DetailUsers::where('id',$id)->update([

             'status_kta' => 1]);
            //  dd($detail);

        return redirect()->route('dpp.pembatalan.index')->with('success', 'Pembatalan Anggota Sukses DiBuat');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_unless(\Gate::allows('member_edit'), 403);
        $detail = DetailUsers::where('no_member', $id)
                ->first();
         
        $member = User::leftJoin('detail_users','users.id','=','detail_users.userid')->where('detail_users.no_member',$id)->first();
        // dd($member);



        return view('dpp.pembatalan.show', compact('member', 'detail'));
    }
    
     public function loaddata(Request $request)
    {
        $data = [];
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('kabupaten_domisili')->first();
        $pembatalan =  DetailUsers::where('status_kta', 1)
            ->groupBy('nickname')
            ->whereIn('detail_users.kabupaten_domisili', $detail)
            ->where('nickname', 'like', '%' . $request->q . '%')
            ->get();
        foreach ($pembatalan as $row) {
            $data[] = ['id' => $row->id,  'text' => $row->nickname];
        }
       
    		return response()->json($data);
    }
     public function searchAnggota(Request $request)
    {
        $data = [];
        $roles= DB::table('model_has_roles')
            ->leftJoin('users','model_has_roles.model_id','=','users.id')
            ->leftJoin('roles','model_has_roles.role_id','=','roles.id')
            ->leftJoin('detail_users','detail_users.userid','=','users.id')
            ->select('detail_users.id','detail_users.no_member','detail_users.nik','detail_users.alamat','detail_users.nickname','detail_users.avatar')
            ->where('detail_users.id',$request->id)->get();
            // dd($roles);
            

            foreach ($roles as $value) {
                $data[] = [
                    'id' => $value->id,
                    'no_member' => $value->no_member,
                    'nik' => $value->nik,
                    'alamat' => $value->alamat,
                    'avatar' => $value->avatar
                ];
            }
          
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

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
        Pembatalan::where('id',$id)->delete();
        return redirect()->route('dpp.pembatalan.index')->with('success', 'Pembatalan Anggota Sudah di Delete');
    }
}
