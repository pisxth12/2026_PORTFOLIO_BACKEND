<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            $user = User::updateOrCreate(
                ['email' => 'admin@gmail.com'],
                [
                    'name' => 'Admin',
                    'password' => Hash::make('Admin123'),
                ]
            );
            $this->command->info('User created: ' . $user->email);
        } catch (\Exception $e) {
            $this->command->error('Seeder failed: ' . $e->getMessage());
        }
    }
}
