<?php

use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
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
    Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword']);

    Route::get('/businesses', [BusinessController::class, 'index']);
    Route::post('/businesses', [BusinessController::class, 'store']);
    Route::post('/businesses/{id}', [BusinessController::class, 'update']);
    Route::post('/businesses/{id}/toggle-status', [BusinessController::class, 'toggleStatus']);
    Route::post('/businesses/{id}/reset-password', [BusinessController::class, 'resetPassword']);

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

    Route::post('/histories', [HistoryController::class, 'store']);
    Route::get('/histories/dates-grouped', [HistoryController::class, 'datesGrouped']);
    Route::get('/histories/per-business-data', [HistoryController::class, 'perBusinessData']);
    Route::get('/histories/per-business-time-series', [HistoryController::class, 'getBusinessHistoryTimeSeries']);


    Route::get('/reports', [ReportController::class, 'index']);
});
