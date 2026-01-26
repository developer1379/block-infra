<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\ProjectController;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\MilestoneCommentController;

Route::middleware(['web', 'auth', 'role:user'])->group(function () {
    Route::get('user/dashboard', [UserController::class, 'index'])->name('admin.user');
    Route::prefix('user')->as('user.')->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::post('/milestones/{milestone}/comments', [MilestoneCommentController::class, 'store'])
            ->name('milestones.comments.store');
    });
});
