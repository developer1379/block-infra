<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfUserRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('user')) {
                return redirect()->route('admin.user');
            }

            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('contractor')) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
