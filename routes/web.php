<?php

use App\Http\Controllers\Admin\ContractorController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\BidController as AdminBidController;
use App\Http\Controllers\Admin\Contractor\BidController as ContractorBidController;
use App\Http\Controllers\Admin\Contractor\ProfileController as ContractorProfileController;
use App\Http\Controllers\Admin\ProjectAwardController;
use App\Http\Controllers\Contractor\ProfileController;
use Illuminate\Support\Facades\Artisan;

Route::get('/cc', function () {
    Artisan::call("cache:clear");
    Artisan::call('route:clear');

    return 'cache cleared';
});
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
    Route::get('/calculator', 'calculator')->name('website.calculator');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginPage')->name('website.login');
    Route::get('/auth/login', 'loginPage')->name('login');
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


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    /** 🔹 PROJECT CRUD ROUTES */
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    /** 🔹 VIEW ALL BIDS OF A PROJECT */
    Route::get('projects/{id}/bids', [AdminBidController::class, 'projectBids'])
        ->name('projects.bids');
    Route::post(
        'projects/{projectId}/award/{bidId}',
        [ProjectAwardController::class, 'award']
    )->name('projects.award');
});


Route::middleware(['auth'])->group(function () {
    Route::get('projects/{id}/add-bid', [ContractorBidController::class, 'create'])
        ->name('admin.projects.bid.create');

    Route::post('projects/{id}/add-bid', [ContractorBidController::class, 'store'])
        ->name('admin.projects.bid.store');

    Route::get('/contractor/profile', [ContractorProfileController::class, 'index'])
        ->name('contractor.profile');

    Route::post('/contractor/profile/update', [ContractorProfileController::class, 'update'])
        ->name('contractor.profile.update');
});
