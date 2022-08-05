<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $responses = [
                    'statusCode' => 402,
                    'message'    => 'Token Invalid',
                    'Data'       => "{}" ];
                return response()->json(['result'=>$responses],200);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $responses = [
                    'statusCode' => 400,
                    'message'    => 'Token Kadaluarsa',
                    'Data'       => "{}" ];
                return response()->json(['result'=>$responses],200);
            }else{
                $responses = [
                    'statusCode' => 401,
                    'message'    => 'Authorization Token not found',
                    'Data'       => "{}" ];
                return response()->json(['result'=>$responses],200);
            }
        }
        return $next($request);
    }
}
