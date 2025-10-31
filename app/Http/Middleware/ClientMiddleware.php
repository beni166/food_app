<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->bearerToken()||!Auth::guard('sanctum')->check()){
            return response()->json([
                'status_message' =>'Token invalide ou utilisatuer non connecter',
                "status"=>401,
                "data"=>null
            ],401);
        };
        return $next($request);
    }
}
