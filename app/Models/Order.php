<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
=======
    protected $primaryKey = 'orderID';
    protected $fillable = [
        'userID',
        'cartID',
        'order_date',
        'total_amount'
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class, 'orderID');
>>>>>>> master
    }
}
