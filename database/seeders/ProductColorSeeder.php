<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductColor;

class ProductColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['color_name' => 'Navy', 'color_code' => '#0A1747'],
            ['color_name' => 'Brown', 'color_code' => '#6B4423'],
            ['color_name' => 'Burgundy', 'color_code' => '#800020'],
            ['color_name' => 'Green', 'color_code' => '#2E5D4B'],
            ['color_name' => 'Olive', 'color_code' => '#808000'],
            ['color_name' => 'Maroon', 'color_code' => '#800000'],
            ['color_name' => 'Purple', 'color_code' => '#800080'],
            ['color_name' => 'Royal Blue', 'color_code' => '#4169E1'],
            ['color_name' => 'Teal', 'color_code' => '#008080'],
            ['color_name' => 'Grey', 'color_code' => '#808080'],
            ['color_name' => 'Mid Blue', 'color_code' => '#0000CD'],
            ['color_name' => 'Bright Yellow', 'color_code' => '#FFFF00'],
            ['color_name' => 'Sky Blue', 'color_code' => '#87CEEB'],
            ['color_name' => 'Black', 'color_code' => '#000000'],
            ['color_name' => 'Pink', 'color_code' => '#FFC0CB'],
            ['color_name' => 'Pastel Blue', 'color_code' => '#ADD8E6']
        ];

        foreach ($colors as $color) {
            ProductColor::create($color);
        }
    }
}