<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if ($user) {
            $userRoles = is_array($user->role) ? $user->role : [$user->role];

            foreach ($userRoles as $role) {
                if (in_array($role, $roles)) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Unauthorized: You do not have the required role to access this resource.');
    }

}
