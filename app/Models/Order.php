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
        'order_date',
        'total_amount',
        'status'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cartID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'paymentID');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'orderID', 'productID')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class, 'orderID');
    }
}
