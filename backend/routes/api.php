<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ReviewController::class)->group(function() {
    Route::get('/reviews', 'index');
    Route::post('/reviews', 'store');
    Route::put('/reviews/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('/reviews/{id}', 'destroy')->middleware('auth:sanctum');
});

Route::controller(AdminController::class)->group(function() {
    Route::post('/admin/signup', 'signup');
    Route::post('/admin/login', 'login');
    Route::get('/admin/login', 'loginWithToken')->middleware('auth:sanctum');
    Route::put('/admin/update/password', 'updatePassword')->middleware('auth:sanctum');
});
