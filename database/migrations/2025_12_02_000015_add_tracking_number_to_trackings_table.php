<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trackings', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('tracking_status');
        });
    }

    public function down()
    {
        Schema::table('trackings', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
        });
    }
};