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
        'cartID',
        'order_date'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cartID');
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
