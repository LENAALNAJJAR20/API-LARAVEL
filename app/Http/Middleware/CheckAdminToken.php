<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\GeneralTrait;

class CheckAdminToken
{
    use GeneralTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $error) {
            if ($error instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->returnError('401', 'The token has been expired !');
            } elseif ($error instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->returnError('498', 'The token is invalid !');
            } else {
                return $this->returnError('404', 'The token does not exists');
            }
        } catch (\Throwable $error) {
            if ($error instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->returnError('401', 'The token has been expired !');
            } elseif ($error instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->returnError('498', 'The token is invalid !');
            } else {
                return $this->returnError('404', 'The token does not exists');
            }
        }
        if (!$user)
            $this->returnError(trans('unauthenticated'), Response::HTTP_UNAUTHORIZED);
        return $next($request);
    }
}
