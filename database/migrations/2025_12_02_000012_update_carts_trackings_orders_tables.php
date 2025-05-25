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
        Schema::table('carts', function (Blueprint $table) {
            // Add foreign key orderID from table order, referencing 'orderID'
            // $table->foreignId('orderID')->nullable()->constrained('orders', 'orderID')->onDelete('set null');
            // Add cart_status column
            $table->string('cart_status')->nullable();
        });

        Schema::table('trackings', function (Blueprint $table) {
            // Drop column order_status
            $table->dropColumn('order_status');
            // Add column tracking_status
            $table->string('tracking_status')->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key cartID
            $table->dropForeign(['cartID']);
            $table->dropColumn('cartID');
            // Add order_status column
            $table->string('order_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['orderID']);
            $table->dropColumn('orderID');
            $table->dropColumn('cart_status');
        });

        Schema::table('trackings', function (Blueprint $table) {
            $table->dropColumn('tracking_status');
            $table->string('order_status')->nullable(); // Re-add the dropped column
        });

        Schema::table('orders', function (Blueprint $table) {
            // Re-add the dropped foreign key and column, referencing 'cartID'
            $table->foreignId('cartID')->nullable()->constrained('carts', 'cartID')->onDelete('set null');
            $table->dropColumn('order_status');
        });
    }
};