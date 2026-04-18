<?php

use App\Http\Controllers\API\PortfolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('portfolio', [PortfolioController::class, 'getPortfolio']);
    Route::post('/contact', [PortfolioController::class, 'submitContact']);
});

Route::get('/x', function() {
    return 'ok';
});
