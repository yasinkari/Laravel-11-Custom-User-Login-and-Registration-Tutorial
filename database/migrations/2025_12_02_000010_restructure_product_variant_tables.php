<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RestructureProductVariantTables extends Migration
{
    public function up()
    {
        // 1. Add variant_imageID to products table
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_imageID')->nullable();
        });

        // 2. Drop foreign keys from product_variant table first
        Schema::table('product_variant', function (Blueprint $table) {
            $table->dropForeign(['toneID']);
        });

        // Remove columns from product_variant
        Schema::table('product_variant', function (Blueprint $table) {
            $table->dropColumn(['product_image', 'product_stock', 'product_size', 'toneID']);
        });

        // 3. Create variant_image table
        Schema::create('variant_image', function (Blueprint $table) {
            $table->id('variant_imageID');
            $table->unsignedBigInteger('product_variantID');
            $table->string('product_image');
            $table->timestamps();

            $table->foreign('product_variantID')
                  ->references('product_variantID')
                  ->on('product_variant')
                  ->onDelete('cascade');
        });

        // 4. Create product_sizing table
        Schema::create('product_sizing', function (Blueprint $table) {
            $table->id('product_sizingID');
            $table->unsignedBigInteger('product_variantID');
            $table->integer('product_stock');
            $table->string('product_size');
            $table->timestamps();

            $table->foreign('product_variantID')
                  ->references('product_variantID')
                  ->on('product_variant')
                  ->onDelete('cascade');
        });

        // 5. Create tone_collection table
        Schema::create('tone_collection', function (Blueprint $table) {
            $table->id('tone_collectionID');
            $table->unsignedBigInteger('toneID');
            $table->unsignedBigInteger('product_variantID');
            $table->timestamps();

            $table->foreign('toneID')
                  ->references('toneID')
                  ->on('tones')
                  ->onDelete('cascade');

            $table->foreign('product_variantID')
                  ->references('product_variantID')
                  ->on('product_variant')
                  ->onDelete('cascade');
        });

        // 6. Modify cart_records table
        Schema::table('cart_records', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['product_variantID']);
            // Drop the old column
            $table->dropColumn('product_variantID');
            // Add the new foreign key column
            $table->unsignedBigInteger('product_sizingID');
            $table->foreign('product_sizingID')
                  ->references('product_sizingID')
                  ->on('product_sizing')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Reverse the changes in cart_records
        Schema::table('cart_records', function (Blueprint $table) {
            $table->dropForeign(['product_sizingID']);
            $table->dropColumn('product_sizingID');
            $table->unsignedBigInteger('product_variantID');
            $table->foreign('product_variantID')
                  ->references('product_variantID')
                  ->on('product_variant');
        });

        // Drop the new tables
        Schema::dropIfExists('tone_collection');
        Schema::dropIfExists('product_sizing');
        Schema::dropIfExists('variant_image');

        // Restore columns in product_variant
        Schema::table('product_variant', function (Blueprint $table) {
            $table->string('product_image')->nullable();
            $table->integer('product_stock')->default(0);
            $table->string('product_size')->nullable();
            $table->unsignedBigInteger('toneID')->nullable();
            $table->foreign('toneID')
                  ->references('toneID')
                  ->on('tones');
        });

        // Remove variant_imageID from products
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('variant_imageID');
        });
    }
}