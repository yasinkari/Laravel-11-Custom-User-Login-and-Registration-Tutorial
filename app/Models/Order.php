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
        'order_date',
        'order_status'
    ];

    protected $casts = [
        'order_date' => 'datetime'
    ];

    public function cart()
    {
        return $this->hasOne(Cart::class, 'orderID');
    }

    public function cartRecords()
    {
        return $this->hasManyThrough(
            CartRecord::class,
            Cart::class,
            'orderID', // Foreign key on carts table
            'cartID',  // Foreign key on cart_records table
            'orderID', // Local key on orders table
            'cartID'   // Local key on carts table
        );
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'orderID');
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class, 'orderID');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
