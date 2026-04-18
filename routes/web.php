<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/seed', function() {
    \Artisan::call('db:seed --force');
    return 'Seeded!';
});
