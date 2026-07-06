<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are the public facing and authentication routes.
| Admin and Contractor routes have been moved to their respective files.
|
*/

// Cache clearing utility
Route::get('/cc', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'All caches (cache, config, route, view) cleared successfully';
});

// Localization Route
Route::get('lang/{locale}', [App\Http\Controllers\LocaleController::class, 'setLocale'])->name('lang.switch');

// Public Website Routes
Route::controller(WebsiteController::class)->group(function () {
    Route::get('/', 'index')->name('website.home');
    Route::get('/about', 'about')->name('website.about');
    Route::get('/construction', 'construction')->name('website.construction');
    Route::get('/infrastructure', 'infrastructure')->name('website.infrastructure');
    Route::get('/project-management', 'projectManagement')->name('website.project-management');
    Route::get('/design-consulting', 'designConsulting')->name('website.design-consulting');
    Route::get('/clients', 'clients')->name('website.clients');
    Route::get('/faqs', 'faqs')->name('website.faqs');
    Route::get('/digitalshramik', 'digitalShramik')->name('website.digitalshramik');
    Route::get('/contact', 'contact')->name('website.contact');
    Route::post('/contact', 'contactSubmit')->name('website.contact.submit');
    Route::get('/request-demo', 'requestDemo')->name('website.request-demo');
    Route::get('/calculator', 'calculator')->name('website.calculator');
    Route::get('/blog', 'blogIndex')->name('website.blog.index');
    Route::get('/blog/{slug}', 'blogShow')->name('website.blog.show');
    Route::post('/blog/{slug}/comments', 'storeComment')->name('website.blog.comments.store');
    Route::get('/sitemap.xml', 'sitemap')->name('website.sitemap');
});

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('website.login');
    Route::get('/auth/login', 'loginPage')->name('login');
    Route::post('/login', 'login')->name('website.login.submit');
    Route::get('/signup', 'registerPage')->name('website.signup');
    Route::post('/signup', 'register')->name('website.register.submit');
    Route::post('/logout', 'logout')->name('logout');
});

// Fallback for root dashboard (redirects based on role)
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->user()->hasRole('contractor')) {
        return redirect()->route('contractor.dashboard.index');
    }
    return redirect()->route('website.home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Forgot/Reset Password Routes
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordPage'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordPage'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware(['signed'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'verifyResend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});
