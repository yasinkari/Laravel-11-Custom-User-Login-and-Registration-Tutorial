<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'bill_reference')) {
                $table->string('bill_reference')->nullable()->after('orderID');
            }
            
            if (!Schema::hasColumn('payments', 'bill_amount')) {
                $table->decimal('bill_amount', 10, 2)->nullable()->after('bill_reference');
            }
            
            if (!Schema::hasColumn('payments', 'billcode')) {
                $table->string('billcode')->nullable()->after('bill_amount');
            }
            
            if (!Schema::hasColumn('payments', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('billcode');
            }
            
            if (!Schema::hasColumn('payments', 'status_msg')) {
                $table->string('status_msg')->nullable()->after('payment_status');
            }
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $columns = [
                'bill_reference',
                'bill_amount',
                'billcode',
                'transaction_id',
                'status_msg'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};