<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cartID';
    protected $fillable = [
        'userID',
        'total_amount',
        'status',  // Existing status field
        'orderID', // Added orderID foreign key
        'cart_status' // Added cart_status column
    ];

    // Remove product() relationship as it's not in the migration
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function cartRecords()
    {
        return $this->hasMany(CartRecord::class, 'cartID');
    }
    
    public function order()
    {
        // Changed to belongsTo as orderID is now on the carts table
        return $this->belongsTo(Order::class, 'orderID');
    }
    
    // Add a relationship to access payment information directly
    public function payment()
    {
        return $this->hasOneThrough(
            Payment::class,
            Order::class,
            'orderID', // Foreign key on the orders table
            'orderID', // Foreign key on the payments table
            'orderID', // Local key on the carts table
            'orderID'  // Local key on the orders table
        );
    }
    
    // Add a scope to filter carts by month and year
    public function scopeByMonthYear(Builder $query, $month, $year)
    {
        return $query->whereHas('order', function (Builder $orderQuery) use ($month, $year) {
            $orderQuery->whereMonth('order_date', $month)
                      ->whereYear('order_date', $year);
        });
    }
}