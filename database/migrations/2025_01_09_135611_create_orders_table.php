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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orderID');  // Changed to be consistent with naming
            $table->unsignedBigInteger('userID');  // Changed from user_id to userID
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // pending, completed, canceled
            $table->timestamps();
    
            $table->foreign('userID')
                  ->references('userID')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
