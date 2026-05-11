<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => ENV('ADMIN_EMAIL')],
            [
                'name' => 'Admin',
                'password' => Hash::make(ENV('ADMIN_PASSWORD')),
            ]
        );
    }
}
