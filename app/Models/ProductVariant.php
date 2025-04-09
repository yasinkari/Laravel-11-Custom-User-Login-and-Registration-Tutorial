<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variant';
    protected $primaryKey = 'product_variantID';
    
    protected $fillable = [
        'toneID',
        'colorID',
        'productID',
        'product_size',
        'product_stock',
        'product_image'
    ];

    public function cartRecords()
    {
        return $this->hasMany(CartRecord::class, 'product_variantID');
    }

    /**
     * Get the tone associated with the product variant.
     */
    public function tone()
    {
        return $this->belongsTo(Tone::class, 'toneID', 'toneID');
    }

    /**
     * Get the color associated with the product variant.
     */
    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'colorID', 'colorID');
    }

    /**
     * Get the product associated with the product variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }
}