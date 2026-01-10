<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContractorController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\BidController as AdminBidController;
use App\Http\Controllers\Admin\ProjectAwardController;
use App\Http\Controllers\Admin\Contractor\BidController as ContractorBidController;
use App\Http\Controllers\Admin\Contractor\ProfileController as ContractorProfileController;
use App\Http\Controllers\Contractor\ContractorProjectController;
use App\Http\Controllers\Contractor\ProjectProgressController;
use Modules\User\Http\Controllers\UserController;

Route::middleware(['web'])->group(function () {

    Route::get('/cc', function () {
        Artisan::call('cache:clear');
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

    Route::middleware(['auth', 'role:admin,contractor'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.pages.dashboard.index');
        })->name('dashboard');
    });



    Route::middleware(['auth', 'role:admin,contractor'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::resource('categories', CategoryController::class);
            Route::resource('roles', RoleController::class)->except(['show']);
            Route::resource('permissions', PermissionController::class)->except(['show']);
            Route::resource('contractors', ContractorController::class);

            Route::post(
                'contractors/{id}/toggle-status',
                [ContractorController::class, 'toggleStatus']
            )->name('contractors.toggle-status');

            Route::patch(
                'contractor-documents/{id}/verify',
                [ContractorController::class, 'verify']
            )->name('contractor-documents.verify');

            Route::resource('works', WorkController::class);
            Route::resource('units', UnitController::class);

            Route::resource('projects', ProjectController::class);

            Route::get(
                'projects/{id}/bids',
                [AdminBidController::class, 'projectBids']
            )->name('projects.bids');

            Route::post(
                'projects/{projectId}/award/{bidId}',
                [ProjectAwardController::class, 'award']
            )->name('projects.award');
        });

    Route::middleware(['auth', 'role:admin,contractor'])->group(function () {

        Route::get('projects/{id}/add-bid', [ContractorBidController::class, 'create'])->name('admin.projects.bid.create');
        Route::post('projects/{id}/add-bid', [ContractorBidController::class, 'store'])->name('admin.projects.bid.store');
        Route::get('/contractor/profile', [ContractorProfileController::class, 'index'])->name('contractor.profile');
        Route::post('/contractor/profile/update', [ContractorProfileController::class, 'update'])->name('contractor.profile.update');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

        Route::get('/projects/{project}/track', [ProjectController::class, 'track'])->name('projects.track');
        // Tracking Page
        Route::get('/projects/{id}/tracking', [App\Http\Controllers\Admin\ProjectTrackingController::class, 'show'])
            ->name('projects.tracking');

        // Milestone Actions
        Route::post('/milestones', [App\Http\Controllers\Admin\ProjectTrackingController::class, 'storeMilestone'])
            ->name('milestones.store');

        Route::patch('/milestones/{id}/status', [App\Http\Controllers\Admin\ProjectTrackingController::class, 'updateMilestoneStatus'])
            ->name('milestones.status');

        Route::delete('/milestones/{id}', [App\Http\Controllers\Admin\ProjectTrackingController::class, 'destroyMilestone'])
            ->name('milestones.destroy');
    });

    // Contractor Routes
    Route::prefix('contractor')->name('contractor.')->middleware(['auth'])->group(function () {

        Route::post('/project/progress', [App\Http\Controllers\Contractor\ProjectProgressController::class, 'store'])
            ->name('project.progress.store');
        Route::get('/projects', [ContractorProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [ContractorProjectController::class, 'show'])->name('projects.show');
        Route::post('/projects/{project}/progress', [ContractorProjectController::class, 'storeProgress'])->name('projects.progress.store');
    });
});
