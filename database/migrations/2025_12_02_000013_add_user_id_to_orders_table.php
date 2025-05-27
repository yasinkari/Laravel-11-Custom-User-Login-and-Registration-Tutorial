<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // First check if the column exists
            if (!Schema::hasColumn('orders', 'userID')) {
                // Add userID foreign key if it doesn't exist
                $table->foreignId('userID')
                    ->after('orderID')
                    ->constrained('users', 'userID')
                    ->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'userID')) {
                $table->dropForeign(['userID']);
                $table->dropColumn('userID');
            }
        });
    }
};