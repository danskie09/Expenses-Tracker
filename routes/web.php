<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});



//User Routes
Route::get('/financial-goals', [UserController::class, 'financialGoals'])->name('financial-goals');
Route::get('/weekly-tracking', [UserController::class, 'weeklyTracking'])->name('weekly-tracking');
Route::get('/reports', [UserController::class, 'reports'])->name('reports');
Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

require __DIR__.'/auth.php';
