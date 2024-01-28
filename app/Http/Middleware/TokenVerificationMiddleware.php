<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token=$request->header('Authorization');
        $result=JWTToken::VerifyToken($token);
        if($result=="unauthorised"){
            return response()->json([
                'status' => 'Unauthorised',
                'message' => 'Unauthorised'
            ],401);
        }
        else{
            $request->headers->set('email',$result->email);
            $request->headers->set('id',$result->id);
            return $next($request);
        }

    }
}
