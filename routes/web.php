<?php

use App\Http\Controllers\Admin\ContractorController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/request-demo', 'requestDemo')->name('website.request-demo');
});

// 🔐 Auth Routes (handled by AuthController)
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('website.login');
    Route::post('/login', 'login')->name('website.login.submit');

    Route::get('/signup', 'registerPage')->name('website.signup');
    Route::post('/signup', 'register')->name('website.register.submit');

    Route::post('/logout', 'logout')->name('logout');
});

// 🧱 Dashboard (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard.index');
    })->name('dashboard');
});
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class, ['as' => 'admin']);
});
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class)->names('admin.roles')->except(['show']);
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('permissions', PermissionController::class)
        ->names('admin.permissions')
        ->except(['show']);
});


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('contractors', ContractorController::class)->names('admin.contractors');
    Route::post('contractors/{id}/toggle-status', [ContractorController::class, 'toggleStatus'])->name('admin.contractors.toggle-status');
});
Route::patch('admin/contractor-documents/{id}/verify', [ContractorController::class, 'verify'])
    ->name('admin.contractor-documents.verify')
    ->middleware(['auth']);

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('works', WorkController::class);
    Route::resource('units', UnitController::class);
});
