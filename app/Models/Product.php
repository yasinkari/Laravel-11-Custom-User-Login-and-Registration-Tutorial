<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['name', 'price', 'status', 'image', 'is_visible', 'details'];

    protected $casts = [
        'details' => 'array', // Automatically cast the 'details' column to an array
    ];
    

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

   
=======
    protected $primaryKey = 'productID';
    protected $fillable = [
        'product_name',
        'product_price',
        'product_description',
        'is_new_arrival',
        'is_best_seller',
        'is_special_offer'
    ];

    // Remove the orders() and carts() relationships as they're now connected through variants
    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'productID');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'productID', 'productID');
    }
>>>>>>> master
}
