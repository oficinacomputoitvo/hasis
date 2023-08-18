<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\RolEnum;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (str_contains($request->path(),"/api/")) { 
            return $next($request);
        }
        $rol = $request->session()->get("rol","0");

        if (auth()->check() && 
            (   $rol == RolEnum::ADMIN->value ||
                $rol == RolEnum::COLLABORATOR->value
            ))
            return $next($request);

        return redirect('/signout');
    }
}
