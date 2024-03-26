<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // public function handle($request, Closure $next, ...$guard): Response
    // {
    //     if (!Auth::check()) {
    //         // Jika belum, arahkan ke halaman login
    //         return redirect()->route('login');
    //     }

    //     return $next($request);
    // }
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }

    }

}
