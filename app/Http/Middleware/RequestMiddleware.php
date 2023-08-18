<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\RolEnum;

class RequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rol = $request->session()->get("rol","0");
        
        if ($request->route()->getName()=="registerrequests")
            return $next($request);
            
        if (auth()->check() && 
            (   $rol == RolEnum::REQUESTER->value  )){
                return $next($request);
            }
            

        return redirect('/signout');
    }
}
