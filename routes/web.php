<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;


// Root
Route::get('/', function () {
    return redirect()->route('dashboard');
});


// Authentication
Route::get('/login', [
    LoginController::class,
    'show'
])->name('login');

Route::post('/login', [
    LoginController::class,
    'login'
])->name('login.submit');


// Authenticated application
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');


    // Reviews
    Route::get('/reviews', [
        ReviewsController::class,
        'index'
    ])->name('reviews');


    // Properties
    Route::get('/properties', [
        PropertiesController::class,
        'index'
    ])->name('properties');


    // Analytics
    Route::prefix('analytics')
        ->name('analytics.')
        ->group(function () {

            Route::get('/rating', [
                AnalyticsController::class,
                'rating'
            ])->name('rating');

            Route::get('/sentiment', [
                AnalyticsController::class,
                'sentiment'
            ])->name('sentiment');

            Route::get('/operational', [
                AnalyticsController::class,
                'operational'
            ])->name('operational');
        });


    // Logout
    Route::post('/logout', [
        LoginController::class,
        'logout'
    ])->name('logout');

});