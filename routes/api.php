<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::middleware(['web'])->group(function () {
    Route::post('/' , [AuthController::class , 'login'])->withoutMiddleware
    (VerifyCsrfToken::class);

    // Categories ======================================================================================================

    Route::get('/categories/{id}' , [CategoryController::class , 'show']);

    Route::post('/categories' , [CategoryController::class , 'store'])->withoutMiddleware
    (VerifyCsrfToken::class);

    Route::put('/categories/{id}' , [CategoryController::class , 'update'])->withoutMiddleware
    (VerifyCsrfToken::class);

    Route::post('/categories/{id}/subcategories' , [CategoryController::class , 'storeChildCategory'])->withoutMiddleware
    (VerifyCsrfToken::class);

    Route::delete('/categories/{id}' , [CategoryController::class , 'destroy'])->withoutMiddleware
    (VerifyCsrfToken::class);
    Route::delete('/subcategories/{id}' , [CategoryController::class , 'destroySubcategory'])->withoutMiddleware
    (VerifyCsrfToken::class); // Видалити підкатегорію

    // =================================================================================================================

    // Products ========================================================================================================

    Route::get('/products' , [ProductController::class , 'showAllProducts']);
    Route::get('/products/{id}' , [ProductController::class , 'show']);

    Route::post('/products' , [ProductController::class , 'store'])->withoutMiddleware
    (VerifyCsrfToken::class);

    Route::put('/products/{id}' , [ProductController::class , 'update'])->withoutMiddleware
    (VerifyCsrfToken::class);
    Route::delete('/products/{id}' , [ProductController::class , 'destroy'])->withoutMiddleware
    (VerifyCsrfToken::class);

    // =================================================================================================================

    // Tag =============================================================================================================

    Route::get('/tag' , [TagController::class , 'index']);
    Route::get('/tag/{id}' , [TagController::class , 'show']);

    Route::post('/tag' , [TagController::class , 'store'])->withoutMiddleware
    (VerifyCsrfToken::class);

    Route::put('/tag/{id}' , [TagController::class , 'update'])->withoutMiddleware
    (VerifyCsrfToken::class);
    Route::delete('/tag/{id}' , [TagController::class , 'destroy'])->withoutMiddleware
    (VerifyCsrfToken::class);

    // =================================================================================================================
});

