<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantImage extends Model
{
    use HasFactory;

    protected $table = 'variant_image';
    protected $primaryKey = 'variant_imageID';
    
    protected $fillable = [
        'product_variantID',
        'product_image'
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variantID');
    }
}