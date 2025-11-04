<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

    Route::get('/login', 'login')->name('website.login');
    Route::get('/signup', 'signup')->name('website.signup');
});

