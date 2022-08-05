<?php

namespace App\Http\Controllers\dpp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LoginActivity;

class LoginActivityController extends Controller
{
    public function index(){
        
        $loginActivities = LoginActivity::whereUserId(auth()->user()->id)->latest()->paginate(10);
    
        return view('dpp.log_activity.index',compact('loginActivities'));
    }
    
    public function destroy($id){
        
        LoginActivity::where('id',$id)->delete();
        
       return redirect()->route('dpp.log_activity.index')->with('success', 'Log activity has been deleted');
    }
}
