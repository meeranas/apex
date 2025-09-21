<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'web'])->group(function () {
    Route::match(['get', 'post'], '/reports/download-comprehensive', [ReportController::class, 'downloadComprehensiveReport'])
        ->name('reports.download-comprehensive');
});
