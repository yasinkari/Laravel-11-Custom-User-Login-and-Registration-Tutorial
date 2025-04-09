<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variant', function (Blueprint $table) {
            $table->id('product_variantID');
            $table->foreignId('toneID')->constrained('tones', 'toneID');
            $table->foreignId('colorID')->constrained('product_colors', 'colorID');
            $table->foreignId('productID')->constrained('products', 'productID');
            $table->enum('product_size', ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL']);
            $table->integer('product_stock')->default(0);
            $table->string('product_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant');
    }
};
