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
        Schema::table('promotions', function (Blueprint $table) {
            // Drop the productID column
            $table->dropForeign(['productID']);
            $table->dropColumn('productID');
            
            // Add start_date, end_date, and is_active columns if they don't exist
            if (!Schema::hasColumn('promotions', 'start_date')) {
                $table->date('start_date')->nullable();
            }
            
            if (!Schema::hasColumn('promotions', 'end_date')) {
                $table->date('end_date')->nullable();
            }
            
            if (!Schema::hasColumn('promotions', 'is_active')) {
                $table->boolean('is_active')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            // Add back the productID column
            $table->unsignedBigInteger('productID')->nullable();
            $table->foreign('productID')->references('productID')->on('products');
            
            // Drop the added columns
            $table->dropColumn(['start_date', 'end_date', 'is_active']);
        });
    }
};