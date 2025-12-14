<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Session expired. Please login again.'
                ], 419);
            }

            return redirect()
                ->route('website.login')
                ->with('error', 'Your session has expired. Please login again.');
        });

        $this->renderable(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 419) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Session expired. Please login again.'
                    ], 419);
                }

                return redirect()
                    ->route('website.login')
                    ->with('error', 'Your session has expired. Please login again.');
            }
        });
    }
}
