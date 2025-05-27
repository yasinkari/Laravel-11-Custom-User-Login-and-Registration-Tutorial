<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'paymentID';
    protected $fillable = [
        'orderID',
        'bill_reference',
        'bill_amount',
        'billcode',
        'transaction_id',
        'payment_date',
        'payment_status',
        'status_msg'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderID');
    }
}