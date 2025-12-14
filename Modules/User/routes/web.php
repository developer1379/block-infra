<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('user/dashboard', [UserController::class, 'index'])->name('admin.user');
});
