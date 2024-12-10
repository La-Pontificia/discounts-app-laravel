<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::post('login', [LoginController::class, 'login']);
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/users/{id}', [UserController::class, 'update']);
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus']);

    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/one', [ClientController::class, 'one']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::post('/clients/import', [ClientController::class, 'import']);
    Route::post('/clients/{id}', [ClientController::class, 'update']);
    Route::post('/clients/{id}/toggle-status', [ClientController::class, 'toggleStatus']);


    Route::get('/discounts', [DiscountController::class, 'index']);
    Route::post('/discounts', [DiscountController::class, 'store']);
    Route::post('/discounts/{id}', [DiscountController::class, 'update']);
    Route::post('/discounts/{id}/delete', [DiscountController::class, 'destroy']);
});
