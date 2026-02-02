<?php

use App\Http\Controllers\ResumeAnalysisController;

Route::get('/', function () {
    return view('analyze');
});

Route::post('/analyze', [ResumeAnalysisController::class, 'store'])
    ->name('analyze.resume');
