<?php

namespace App\Http\Controllers\Dpd;

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
  
        return view('dpd.pembatalan.index', compact('pembatalan'));
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
        return view('dpd.pembatalan.create', compact('pembatalan'));
       
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
             'deleted_at' => date('Y-m-d H:i:s'),
             'status_kta' => 4]);
          

        return redirect()->route('dpd.pembatalan.index')->with('success', 'Pembatalan Anggota Sukses DiBuat');
       
    }
     public function store(Request $request)
    {
        $pembatalan = Pembatalan::create([
            'id_anggota'        => $request->id_anggota,
            'alasan_pembatalan' => $request->alasan_pembatalan,
            'created_by'    => \Auth::user()->id,
            'status'        => 3,
            'created_at'    => date('Y-m-d H:i:s')
        ]);
         $detail = DetailUsers::where('id',$request->id_anggota)->update([

             'status_kta' => 3]);
            //  dd($detail);

        return redirect()->route('dpd.pembatalan.index')->with('success', 'Pembatalan Anggota Sukses DiBuat');
       
    }

    public function update(Request $request , $id)
    {
     
        $pembatalan = Pembatalan::where('id_anggota', $id)->delete();
         $detail = DetailUsers::where('id',$id)->update([

             'status_kta' => 1]);
            //  dd($detail);

        return redirect()->route('dpd.pembatalan.index')->with('success', 'Pembatalan Anggota Sukses DiBuat');
       
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



        return view('dpd.pembatalan.show', compact('member', 'detail'));
    }
    
     public function loaddata(Request $request)
    {
        $data = [];
        $id = Auth::user()->id;
        $detail= DetailUsers::where('userid',$id)->select('provinsi_domisili')->first();
        $pembatalan =  DetailUsers::join('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
            ->where('detail_users.status_kta', 1)
            ->groupBy('detail_users.nickname')
            ->where('model_has_roles.role_id',11)
            ->whereIn('detail_users.provinsi_domisili', $detail)
            ->where('detail_users.nickname', 'like', '%' . $request->q . '%')
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
            ->where('detail_users.id',$request->id)
            ->where('model_has_roles.role_id',11)
            ->get();
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

    public function updateacc(Request $request)
    {

      $pembatalan = Pembatalan::whereIn('id_anggota', $request->ids)->delete();
    $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
            'status_kta' => 1
            )); 
        
      


      return redirect()->route('dpd.pembatalan.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
      public function updatefail(Request $request)
    {
            $pembatalan = Pembatalan::whereIn('id_anggota', $request->ids)->delete();
           
          $detail = DetailUsers::whereIn('id', $request->ids)->update(array(
             'deleted_at' => date('Y-m-d H:i:s'),
             'status_kta' => 4));
        
      
      return redirect()->route('dpd.pembatalan.index')->with('success', 'Kategori Informasi Sudah di Update');
    }
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        Pembatalan::where('id',$id)->delete();
        return redirect()->route('dpd.pembatalan.index')->with('success', 'Pembatalan Anggota Sudah di Delete');
    }
}
