<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminContractorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('website.login');
        }

        $user = Auth::user();

        if ($user->hasRole('admin') || $user->hasRole('contractor')) {
            return $next($request);
        }

        if ($user->hasRole('user') && $request->routeIs('admin.user')) {
            return $next($request);
        }

        if ($user->hasRole('user')) {
            return redirect()->route('admin.user');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('website.login');
    }
}
