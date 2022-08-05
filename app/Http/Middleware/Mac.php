<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class Mac
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
        $macAddr = substr(exec('getmac'), 0, 17);
        // return $macAddr;
        if (auth()->user()->mac_address != $macAddr) {
            Auth::logout();
        }

        return back();
    }
}
