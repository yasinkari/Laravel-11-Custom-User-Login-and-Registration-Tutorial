<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'orderID';
    
    protected $fillable = [
        'userID',
        // Removed 'cartID'
        'order_date',
        'order_status' // Added order_status column
    ];

    public function cart()
    {
        // Changed to hasOne as cartID is removed from orders table and orderID is added to carts table
        return $this->hasOne(Cart::class, 'orderID');
    }

    // Remove user() relationship as it's accessed through cart
    // Remove products() relationship as there's no order_product table
    public function payment()
    {
        return $this->hasOne(Payment::class, 'orderID');
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class, 'orderID');
    }
}
