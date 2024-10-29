<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/registration', function (){
        return view('auth.registration');
    })->name('registration.index');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/registration', [AuthController::class, 'registration'])->name('registration.store');
});

Route::middleware('checkAuth')->group(function (){
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::resource('products', ProductController::class)->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);


});

Route::get('products', [ProductController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('tags', [TagController::class, 'index']);
