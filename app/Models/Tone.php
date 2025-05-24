<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tone extends Model
{
    use HasFactory;

    protected $primaryKey = 'toneID';
    protected $fillable = [
        'tone_name',
        'tone_code'
    ];

    public function toneCollections()
    {
        return $this->hasMany(ToneCollection::class, 'toneID');
    }

    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class, 'tone_collection', 'toneID', 'product_variantID');
    }
}