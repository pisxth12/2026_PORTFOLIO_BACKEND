<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/seed', function() {
    \Artisan::call('db:seed --force');
    return 'Seeded!';
});


Route::get('/make-me-a-user', function() {
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'pisxth12@gmail.com',
        'password' => bcrypt('yourpassword123')
    ]);
    return "User created. Delete this route now.";
});

// Add this at the VERY BOTTOM of routes/web.php
Route::get('/create-admin', function() {
    try {
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'pisxth12@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('yourpassword123'),
                'email_verified_at' => now(),
            ]
        );
        return "User created! Email: " . $user->email . " - Password: yourpassword123";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
