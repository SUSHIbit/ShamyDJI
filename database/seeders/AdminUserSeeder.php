<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'shahmy',
            'email' => 'ariefsushi1@gmail.com',
            'password' => Hash::make('sejarah123'),
            'role' => 'admin',
        ]);
    }
}