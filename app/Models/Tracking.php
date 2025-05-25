<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $primaryKey = 'trackingID';
    protected $fillable = [
        'orderID',
        // Removed 'order_status'
        'timestamp',
        'tracking_status' // Added tracking_status column
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderID');
    }
}