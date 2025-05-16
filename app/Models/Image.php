<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $primaryKey = 'imageID';
    
    protected $fillable = [
        'product_variantID',
        'product_image'
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variantID', 'product_variantID');
    }
}