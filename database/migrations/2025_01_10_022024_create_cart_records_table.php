<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cart_records', function (Blueprint $table) {
            $table->id('cart_recordID');
            $table->foreignId('cartID')->constrained('carts', 'cartID');
            $table->foreignId('product_variantID')->constrained('product_variant', 'product_variantID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_records');
    }
};
