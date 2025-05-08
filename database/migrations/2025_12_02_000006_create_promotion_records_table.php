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
        Schema::create('promotion_records', function (Blueprint $table) {
            $table->id('promotion_recordID');
            $table->unsignedBigInteger('promotionID');
            $table->unsignedBigInteger('productID');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('promotionID')->references('promotionID')->on('promotions')->onDelete('cascade');
            $table->foreign('productID')->references('productID')->on('products')->onDelete('cascade');
            
            // Ensure a product can only be associated with a promotion once
            $table->unique(['promotionID', 'productID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_records');
    }
};