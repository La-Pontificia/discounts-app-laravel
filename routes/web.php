<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::post('login', [LoginController::class, 'login']);
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/users/{id}', [UserController::class, 'update']);
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus']);

    Route::get('/clients', [ClientController::class, 'index']);
});
