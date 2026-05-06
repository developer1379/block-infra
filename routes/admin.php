<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContractorController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\BidController as AdminBidController;
use App\Http\Controllers\Admin\ProjectAwardController;
use App\Http\Controllers\Admin\ProjectTrackingController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\SiteReportController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Prefix: /admin
| Name Prefix: admin.
| Middleware: ['web', 'auth', 'role:admin'] (Applied in RouteServiceProvider)
|
*/

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard');

// Resource Management
Route::resource('categories', CategoryController::class);
Route::resource('roles', RoleController::class)->except(['show']);
Route::resource('permissions', PermissionController::class)->except(['show']);
Route::resource('contractors', ContractorController::class);
Route::resource('works', WorkController::class);
Route::resource('units', UnitController::class);
Route::resource('projects', ProjectController::class);

// Contractor Actions
Route::post('contractors/{id}/toggle-status', [ContractorController::class, 'toggleStatus'])->name('contractors.toggle-status');
Route::patch('contractor-documents/{id}/verify', [ContractorController::class, 'verify'])->name('contractor-documents.verify');

// Project & Bid Management
Route::get('projects/{id}/bids', [AdminBidController::class, 'projectBids'])->name('projects.bids');
Route::post('projects/{projectId}/award/{bidId}', [ProjectAwardController::class, 'award'])->name('projects.award');
Route::get('projects/{project}/payments', [ProjectController::class, 'payments'])->name('projects.payments');

// Project Tracking & Milestones
Route::get('/projects/{project}/track', [ProjectController::class, 'track'])->name('projects.track');
Route::get('/projects/{id}/tracking', [ProjectTrackingController::class, 'show'])->name('projects.tracking');
Route::post('/milestones', [ProjectTrackingController::class, 'storeMilestone'])->name('milestones.store');
Route::patch('/milestones/{id}/status', [ProjectTrackingController::class, 'updateMilestoneStatus'])->name('milestones.status');
Route::delete('/milestones/{id}', [ProjectTrackingController::class, 'destroyMilestone'])->name('milestones.destroy');

// New Construction Management Routes
Route::resource('workers', WorkerController::class);
Route::resource('materials', MaterialController::class);
Route::resource('finance', FinanceController::class);
Route::resource('site-reports', SiteReportController::class);
