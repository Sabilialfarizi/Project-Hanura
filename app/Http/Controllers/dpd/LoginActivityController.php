<?php

namespace App\Http\Controllers\dpd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\{LoginActivity, DetailUsers, Provinsi};

class LoginActivityController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $provinsi = DetailUsers::where('userid',$id)->value('provinsi_domisili');

        $roles = DetailUsers::join('model_has_roles','model_has_roles.model_id','=','detail_users.userid')
        ->join('roles','roles.id','=','model_has_roles.role_id')
        ->where('detail_users.userid',$id)
        ->value('roles.id');
       
 
        
        $loginActivities = LoginActivity::join('detail_users','login_activities.user_id','=','detail_users.userid')
        ->join('model_has_roles','model_has_roles.model_id','=','detail_users.userid')
        ->join('roles','roles.id','=','model_has_roles.role_id')
        ->join('provinsis','detail_users.provinsi_domisili','=','provinsis.id_prov')
        ->select('login_activities.*')
        ->where('provinsis.id_prov', $provinsi)
        ->where('roles.id',11)
        ->groupBy('login_activities.id')
        ->get();
 
 
    
        return view('dpd.log_activity.index',compact('loginActivities'));
    }
    
    public function destroy($id){
        
        LoginActivity::where('id',$id)->delete();
        
       return redirect()->route('dpp.log_activity.index')->with('success', 'Log activity has been deleted');
    }
}
