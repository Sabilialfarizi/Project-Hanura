<?php

namespace App\Http\Controllers\Dpc;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\{LoginActivity, DetailUsers, Provinsi};

class LoginActivityController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $kabupaten = DetailUsers::where('userid',$id)->value('kabupaten_domisili');
        
    
         $loginActivities = LoginActivity::join('detail_users','login_activities.user_id','=','detail_users.userid')
        ->join('model_has_roles','model_has_roles.model_id','=','detail_users.userid')
        ->join('roles','roles.id','=','model_has_roles.role_id')
        ->join('kabupatens','detail_users.kabupaten_domisili','=','kabupatens.id_kab')
        ->select('login_activities.*')
        ->where('kabupatens.id_kab', $kabupaten)
        ->where('roles.id',4)
        ->groupBy('login_activities.id')
        ->get();

    
        return view('dpc.log_activity.index',compact('loginActivities'));
    }
    
    public function destroy($id){
        
        LoginActivity::where('id',$id)->delete();
        
       return redirect()->route('dpc.log_activity.index')->with('success', 'Log activity has been deleted');
    }
}
