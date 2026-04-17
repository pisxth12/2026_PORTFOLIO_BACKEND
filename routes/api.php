<?php

use App\Http\Controllers\API\PortfolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('portfolio', [PortfolioController::class, 'getPortfolio']);
    Route::get('/user', [PortfolioController::class, 'getUser']);
    Route::get('/social', [PortfolioController::class, 'getSocial']);
    Route::get('/skills', [PortfolioController::class, 'getSkills']);
    Route::get('/projects', [PortfolioController::class, 'getProjects']);
    Route::post('/contact', [PortfolioController::class, 'submitContact']);
});
