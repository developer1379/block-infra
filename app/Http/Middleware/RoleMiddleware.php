<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role  The role passed from the route (e.g., 'user', 'admin')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Check if the user has the required role
        // This assumes your User model has a hasRole() method
        if ($user->hasRole($role)) {
            return $next($request);
        }

        // 3. Unauthorized: User logged in but does not have the right role
        abort(403, 'Unauthorized action.');
    }
}
