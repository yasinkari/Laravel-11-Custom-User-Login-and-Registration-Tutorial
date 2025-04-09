<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('productID');
            $table->string('product_name');
            $table->decimal('product_price', 10, 2);
            $table->text('product_description');
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_special_offer')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
