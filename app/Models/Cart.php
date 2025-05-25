<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}