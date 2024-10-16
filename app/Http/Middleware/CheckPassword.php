<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        dd($request->api_password,config('api_key.password'));
        if($request->api_password !== config('api_key.password')){
          return response()->json(['message' => 'unauthenticated'], Response::HTTP_UNAUTHORIZED);

        }
        return $next($request);
    }
}
