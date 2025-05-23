<?php

use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanCalculatorController;
use App\Http\Controllers\PercentageCalculatorController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');

Route::post('/item', [ItemController::class, 'insert'])->name('item.store');
Route::delete('/item/{id}', [ItemController::class, 'delete'])->name('item.destroy');

// Kalkulator Persentase Routes
Route::get('/calculator', [PercentageCalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculator/calculate', [PercentageCalculatorController::class, 'calculate'])->name('calculator.calculate');

// Kalkulator KPR Routes
Route::get('/loan', [LoanCalculatorController::class, 'index']);
Route::post('/loan', [LoanCalculatorController::class, 'calculate']);
