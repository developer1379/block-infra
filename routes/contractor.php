<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contractor\ProjectController;
use App\Http\Controllers\Contractor\DashboardController;
use App\Http\Controllers\Contractor\ProfileController;
use App\Http\Controllers\Contractor\ProjectProgressController;
use App\Http\Controllers\Contractor\BidController;
use App\Http\Controllers\Contractor\WorkerController;
use App\Http\Controllers\Contractor\InventoryController;
use App\Http\Controllers\Contractor\AttendanceController;
use App\Http\Controllers\Contractor\WorkerPaymentController;

/*
|--------------------------------------------------------------------------
| Contractor Routes
|--------------------------------------------------------------------------
|
| Prefix: /contractor
| Name Prefix: contractor.
| Middleware: ['web', 'auth', 'role:contractor'] (Applied in RouteServiceProvider)
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Profile Management
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Project Management
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects/{id}/details', [ProjectController::class, 'details'])->name('projects.details');
Route::post('/projects/{project}/progress', [ProjectController::class, 'storeProgress'])->name('projects.progress.store');

// Bid Management
Route::get('/project/bids/{id}', [ProjectController::class, 'projectBids'])->name('projects.bids');
Route::get('/project/bids/{id}/create', [BidController::class, 'create'])->name('bids.create');
Route::post('/project/bids/{id}/store', [BidController::class, 'store'])->name('bids.store');

// Workforce Management
Route::resource('workers', WorkerController::class);
Route::resource('attendance', AttendanceController::class);
Route::resource('payments', WorkerPaymentController::class);

// Site Activities
Route::resource('site-reports', \App\Http\Controllers\Contractor\SiteReportController::class);
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');

// Financials
Route::get('/invoices', function() { return view('contractor.invoices.index'); })->name('invoices.index');

// Progress Tracking
Route::post('/project/progress/quick', [ProjectProgressController::class, 'store'])->name('project.progress.store');
