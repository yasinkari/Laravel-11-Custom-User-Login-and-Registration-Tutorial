<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $primaryKey = 'colorID';
    protected $fillable = [
        'color_name',
        'color_code'
    ];

    // Remove product() and toneRecords() relationships as they don't exist in migrations
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'colorID');
    }
}