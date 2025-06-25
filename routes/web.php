<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FinancialController;

Route::get('/financial', [FinancialController::class, 'create'])->name('financial.create');
Route::post('/financial', [FinancialController::class, 'store'])->name('financial.store');
Route::get('/financial/list', [FinancialController::class, 'index'])->name('financial.index');

Route::get('/financial/{id}/edit', [FinancialController::class, 'edit'])->name('financial.edit');
Route::put('/financial/{id}', [FinancialController::class, 'update'])->name('financial.update');

Route::get('/financial/report', [FinancialController::class, 'report'])->name('financial.report');

Route::delete('/financial/{id}', [FinancialController::class, 'destroy'])->name('financial.destroy');