<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\NelayanController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

//login-google
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle'])->name('callbackGoogle');

//login-facebook
Route::get('/auth/facebook', [FacebookAuthController::class, 'redirect'])->name('facebook-auth');
Route::get('/auth/facebook/call-back', [FacebookAuthController::class, 'callbackFacebook'])->name('callbackFacebook');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/about-information/fishapp', function () {
    return view('about_information');
})->name('about_information');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/pdatefoto', [ProfileController::class, 'updatefoto'])->name('update.profile.photo');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/about2', function () {
        return view('about2');
    })->name('about2');
    Route::get('/about-information2/fishapp', function () {
        return view('about_information2');
    })->name('about_information2');
});

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'login'])->name('login_admin');
    Route::post('login/post', [AdminController::class, 'store'])->name('admin.login');
    Route::middleware('is_admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
        Route::get('/viewdatanelayan', [AdminController::class, 'viewdatanelayan'])->name('viewdatanelayan');
    });
});

Route::get('/api/villages', [NelayanController::class, 'villages']);
Route::prefix('nelayan')->group(function () {
    Route::get('form-registraton', [NelayanController::class, 'registration'])->name('form_registrasi_nelayan');
    Route::post('form-registraton/post', [NelayanController::class, 'store'])->name('post_form_pendaftaran_nelayan');
    Route::get('login', [NelayanController::class, 'login'])->name('login_nelayan');
    Route::post('login/post', [NelayanController::class, 'login'])->name('nelayan.login');
});

require __DIR__.'/auth.php';
