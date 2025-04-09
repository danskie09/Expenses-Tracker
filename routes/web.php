<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FinancialGoalController;

Route::get('/', function () {
    return view('welcome');
});

// User Routes
Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
Route::get('/reports', [UserController::class, 'reports'])->name('reports');
Route::get('/weekly-tracking', [UserController::class, 'weeklyTracking'])->name('weekly-tracking');

// Financial Goals Routes
Route::get('/financial-goals', [FinancialGoalController::class, 'index'])->name('financial-goals');
Route::post('/financial-goals', [FinancialGoalController::class, 'store'])->name('financial-goals.store');
Route::get('/financial-goals/{id}', [FinancialGoalController::class, 'show'])->name('financial-goals.show');
Route::put('/financial-goals/{id}', [FinancialGoalController::class, 'update'])->name('financial-goals.update');
Route::delete('/financial-goals/{id}', [FinancialGoalController::class, 'destroy'])->name('financial-goals.destroy');

require __DIR__.'/auth.php';
