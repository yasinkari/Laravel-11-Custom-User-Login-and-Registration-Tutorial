<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_name' => 'Fashion T-Shirt',
                'product_price' => 29.99,
                'product_description' => 'Comfortable cotton t-shirt suitable for all skin tones.',
                'is_visible' => true,
                'image' => 'fashion-tshirt.jpg'
            ],
            [
                'product_name' => 'Casual Dress',
                'product_price' => 49.99,
                'product_description' => 'Elegant casual dress with various color options for different skin tones.',
                'is_visible' => true,
                'image' => 'casual-dress.jpg'
            ],
            [
                'product_name' => 'Formal Shirt',
                'product_price' => 39.99,
                'product_description' => 'Classic formal shirt with colors that complement your skin tone.',
                'is_visible' => true,
                'image' => 'formal-shirt.jpg'
            ],
            [
                'product_name' => 'Summer Blouse',
                'product_price' => 34.99,
                'product_description' => 'Light and airy blouse perfect for summer, available in colors for every skin tone.',
                'is_visible' => true,
                'image' => 'summer-blouse.jpg'
            ],
            [
                'product_name' => 'Winter Sweater',
                'product_price' => 59.99,
                'product_description' => 'Warm and cozy sweater with colors designed to enhance your skin tone.',
                'is_visible' => true,
                'image' => 'winter-sweater.jpg'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
