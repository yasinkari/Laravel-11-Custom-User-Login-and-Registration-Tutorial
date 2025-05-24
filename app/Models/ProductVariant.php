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
        'colorID',
        'productID'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'colorID', 'colorID');
    }

    public function variantImages()
    {
        return $this->hasMany(VariantImage::class, 'product_variantID');
    }

    public function productSizings()
    {
        return $this->hasMany(ProductSizing::class, 'product_variantID');
    }

    public function toneCollections()
    {
        return $this->hasMany(ToneCollection::class, 'product_variantID');
    }

    public function tones()
    {
        return $this->belongsToMany(Tone::class, 'tone_collection', 'product_variantID', 'toneID');
    }
}