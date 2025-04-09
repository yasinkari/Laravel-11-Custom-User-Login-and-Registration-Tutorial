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
        'product_description'
    ];

    // Keep existing relationships
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
