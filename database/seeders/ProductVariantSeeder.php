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
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL']; // Added 'XXXL' to match migration
        
        $products = Product::all();
        $tones = Tone::all();
        $colors = ProductColor::all();
        
        $colorMappings = [
            'Fair' => ['Navy', 'Brown', 'Burgundy', 'Green', 'Olive', 'Dusty Pink', 'Mint Green'],
            'Olive' => ['Burgundy', 'Maroon', 'Purple', 'Green', 'Navy', 'Nude', 'Royal Blue'],
            'Light Brown' => ['Navy', 'Royal Blue', 'Teal', 'Grey', 'Burgundy', 'Mint Green', 'Soft Yellow'],
            'Brown' => ['Navy', 'Mid Blue', 'Green', 'Bright Yellow', 'Sky Blue', 'Royal Blue', 'Nude'],
            'Black Brown' => ['Black', 'Navy', 'Burgundy', 'Pink', 'Pastel Blue', 'Dusty Pink', 'Royal Blue']
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