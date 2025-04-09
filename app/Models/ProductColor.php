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

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'colorID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

    public function toneRecords()
    {
        return $this->hasMany(ToneRecord::class, 'colorID');
    }
}