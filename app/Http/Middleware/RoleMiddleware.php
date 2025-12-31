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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  <-- Changed to accept multiple roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if the user has ANY of the roles passed in the route
        foreach ($roles as $role) {
            // Using Spatie's hasRole, or your custom logic
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // If loop finishes without returning, user has none of the required roles
        abort(403, 'Unauthorized access.');
    }
}
