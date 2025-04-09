<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'productID';
    
    protected $fillable = [
        'product_name',
        'product_price',
        'product_description',
        'is_new_arrival',
        'is_best_seller',
        'is_special_offer',
        'image',
        'is_visible',
        'details'
    ];

    protected $casts = [
        'details' => 'array',
        'is_new_arrival' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_special_offer' => 'boolean',
        'is_visible' => 'boolean'
    ];

    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'productID');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'productID', 'productID');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
