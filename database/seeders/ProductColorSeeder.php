<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductColor;

class ProductColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'Navy', 'code' => '#0A1747'],
            ['name' => 'Brown', 'code' => '#6B4423'],
            ['name' => 'Burgundy', 'code' => '#800020'],
            ['name' => 'Green', 'code' => '#2E5D4B'],
            ['name' => 'Olive', 'code' => '#808000'],
            ['name' => 'Maroon', 'code' => '#800000'],
            ['name' => 'Purple', 'code' => '#800080'],
            ['name' => 'Royal Blue', 'code' => '#4169E1'],
            ['name' => 'Teal', 'code' => '#008080'],
            ['name' => 'Grey', 'code' => '#808080'],
            ['name' => 'Mid Blue', 'code' => '#0000CD'],
            ['name' => 'Bright Yellow', 'code' => '#FFFF00'],
            ['name' => 'Sky Blue', 'code' => '#87CEEB'],
            ['name' => 'Black', 'code' => '#000000'],
            ['name' => 'Pink', 'code' => '#FFC0CB'],
            ['name' => 'Pastel Blue', 'code' => '#ADD8E6']
        ];

        foreach ($colors as $color) {
            ProductColor::create([
                'color_name' => $color['name'],
                'color_code' => $color['code']
            ]);
        }
    }
}