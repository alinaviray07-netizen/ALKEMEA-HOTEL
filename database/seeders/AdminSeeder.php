<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'api_token' => 'Wd7uMsaJSFQ1ViecerpiorKjly7MZKLR3tu9eIAg4Lpm8bkLOfkdkhSXmTSQ',
            ]
        );

        User::updateOrCreate(
            ['email' => 'guest@gmail.com'],
            [
                'name' => 'Sample Guest',
                'password' => Hash::make('guest12345'),
                'role' => 'guest',
                'api_token' => null,
            ]
        );
    }
}