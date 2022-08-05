<?php

namespace App\Http\Middleware;

use App\{User, DetailUsers};
use Closure;
use Illuminate\Support\Facades\Auth;


class MacAddr
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
         $user = User::find(Auth::user()->id);
         $detail = DetailUsers::leftJoin('model_has_roles','detail_users.userid','=','model_has_roles.model_id')
            ->where('detail_users.userid',$user->id)
            ->where('detail_users.status_kta', 1)
            ->select('model_has_roles.role_id','detail_users.no_member','detail_users.nickname','detail_users.nik')
            ->first();
        if (! $detail ){
             Auth::logout();
             return back();
        }
     
   
        if ( $detail->role_id != 5 ) {
            
            return $next($request);
        }

        Auth::logout();
        return back();
    }
}
