<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizing extends Model
{
    use HasFactory;

    protected $table = 'product_sizing';
    protected $primaryKey = 'product_sizingID';
    
    protected $fillable = [
        'product_variantID',
        'product_stock',
        'product_size'
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variantID');
    }

    public function cartRecords()
    {
        return $this->hasMany(CartRecord::class, 'product_sizingID');
    }
}