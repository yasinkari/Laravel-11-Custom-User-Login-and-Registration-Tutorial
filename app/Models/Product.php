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

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'productID');
    }
}
