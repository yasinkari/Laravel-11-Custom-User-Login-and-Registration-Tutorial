<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'user_name' => 'Mustaqim Ibrahim',
            'email' => 'mustaqimbinibrahim@gmail.com',
            'password' => Hash::make('12345678'),
            'user_phone' => '0123456789',
            'user_address' => 'Admin Address',
            'user_role' => 'admin'
        ]);

        // Customer User
        User::create([
            'user_name' => 'Yasin Ibrahim',
            'email' => 'yasinibrahim304@gmail.com',
            'password' => Hash::make('12345678'),
            'user_phone' => '0123456789',
            'user_address' => 'Customer Address',
            'user_role' => 'user'
        ]);
    }
}
