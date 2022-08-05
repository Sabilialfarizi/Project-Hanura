<?php

namespace App\Http\Controllers\Dpd;

use Illuminate\Http\Request;
use App\{Pembatalan, DetailUsers, User};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(\Gate::allows('category_access'), 403);
        

        $pembatalan = DetailUsers::orderBy('id', 'asc')->where('status_kta',2)->get();
  
        return view('dpd.repair.index', compact('pembatalan'));
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
        $detail = DetailUsers::where('no_member', $id)
                ->first();
         
        $member = User::leftJoin('detail_users','users.id','=','detail_users.userid')->where('detail_users.no_member',$id)->first();
        // dd($member);



        return view('dpd.repair.show', compact('member', 'detail'));
    }
    
  
    public function destroy($id)
    { 
        $detail = DetailUsers::where('id',$id)->get();
        
          foreach ($detail as $det) {
            $user = User::where('id', $det->userid)->delete();
        
            $det->delete();
        }
        return redirect()->route('dpd.repair.index')->with('success', 'Anggota Sudah di Delete');
    }
}
