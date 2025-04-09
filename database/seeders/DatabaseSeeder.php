<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            ProductSeeder::class,
            ToneSeeder::class,
            ProductColorSeeder::class,
            ProductVariantSeeder::class,
        ]);
    }
}
