<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users with specified details
        User::create([
            'name' => 'Tengku Muz',
            'email' => 'entahladoe@gmail.com',
            'password' => Hash::make('12345678'), // Hashed password
            'role' => 'user', // Default user role
        ]);

        User::create([
            'name' => 'Yasin Ibrahim',
            'email' => 'yasinibrahim304@gmail.com',
            'password' => Hash::make('12345678'), // Hashed password
            'role' => 'user', // Default user role
        ]);

        User::create([
            'name' => 'Mustaqim Ibrahim',
            'email' => 'mustaqimbinibrahim@gmail.com',
            'password' => Hash::make('12345678'), // Hashed password
            'role' => 'admin', // Admin role
        ]);

        // Create products with the 'details' field
        Product::create([
            'name' => 'Sample Product 1',
            'price' => 99.99,
            'image' => 'sample_image.jpg',
            'is_visible' => true,
            'details' => json_encode(['variants' => []]), // Default empty variants
        ]);

        Product::create([
            'name' => 'Sample Product 2',
            'price' => 49.99,
            'image' => 'sample_image2.jpg',
            'is_visible' => true,
            'details' => json_encode(['variants' => []]), // Default empty variants
=======
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ToneSeeder::class,
            ProductSeeder::class,
            ProductColorSeeder::class,
            ProductVariantSeeder::class,
>>>>>>> master
        ]);
    }
}
