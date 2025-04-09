<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Tone;
use App\Models\ProductColor;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        
        $products = Product::all();
        $tones = Tone::all();
        $colors = ProductColor::all();
        
        $colorMappings = [
            'Fair' => ['Navy', 'Brown', 'Burgundy', 'Green', 'Olive'],
            'Olive' => ['Burgundy', 'Maroon', 'Purple', 'Green', 'Navy'],
            'Light Brown' => ['Navy', 'Royal Blue', 'Teal', 'Grey', 'Burgundy'],
            'Brown' => ['Navy', 'Mid Blue', 'Green', 'Bright Yellow', 'Sky Blue'],
            'Black Brown' => ['Black', 'Navy', 'Burgundy', 'Pink', 'Pastel Blue']
        ];

        foreach ($products as $product) {
            foreach ($tones as $tone) {
                $recommendedColors = $colorMappings[$tone->tone_name] ?? [];
                
                foreach ($recommendedColors as $colorName) {
                    $color = $colors->where('color_name', $colorName)->first();
                    
                    if ($color) {
                        foreach ($sizes as $size) {
                            ProductVariant::create([
                                'toneID' => $tone->toneID,
                                'colorID' => $color->colorID,
                                'productID' => $product->productID,
                                'product_size' => $size,
                                'product_stock' => rand(5, 20),
                                'product_image' => 'product_images/' . strtolower(str_replace(' ', '_', $product->product_name)) . '_' . 
                                                 strtolower(str_replace(' ', '_', $colorName)) . '.jpg'
                            ]);
                        }
                    }
                }
            }
        }
    }
}