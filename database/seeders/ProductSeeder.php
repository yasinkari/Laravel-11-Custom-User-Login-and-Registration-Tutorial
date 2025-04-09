<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
<<<<<<< HEAD
    public function run()
    {
        // Add sample products
        Product::create([
            'name' => 'Sample Product 1',
            'price' => 99.99,
            'image' => 'sample_image.jpg', // Make sure this file exists in storage/app/public/product_images
            'is_visible' => true,
        ]);

        Product::create([
            'name' => 'Sample Product 2',
            'price' => 49.99,
            'image' => 'sample_image2.jpg', // Make sure this file exists in storage/app/public/product_images
            'is_visible' => true,
        ]);
=======
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_name' => 'Fashion T-Shirt',
                'product_price' => 29.99,
                'product_description' => 'Comfortable cotton t-shirt suitable for all skin tones.'
            ],
            [
                'product_name' => 'Casual Dress',
                'product_price' => 49.99,
                'product_description' => 'Elegant casual dress with various color options for different skin tones.'
            ],
            [
                'product_name' => 'Formal Shirt',
                'product_price' => 39.99,
                'product_description' => 'Classic formal shirt with colors that complement your skin tone.'
            ],
            [
                'product_name' => 'Summer Blouse',
                'product_price' => 34.99,
                'product_description' => 'Light and airy blouse perfect for summer, available in colors for every skin tone.'
            ],
            [
                'product_name' => 'Winter Sweater',
                'product_price' => 59.99,
                'product_description' => 'Warm and cozy sweater with colors designed to enhance your skin tone.'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
>>>>>>> master
    }
}
