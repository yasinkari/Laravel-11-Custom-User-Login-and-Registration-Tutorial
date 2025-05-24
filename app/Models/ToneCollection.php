<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToneCollection extends Model
{
    use HasFactory;

    protected $table = 'tone_collection';
    protected $primaryKey = 'tone_collectionID';
    
    protected $fillable = [
        'toneID',
        'product_variantID'
    ];

    public function tone()
    {
        return $this->belongsTo(Tone::class, 'toneID');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variantID');
    }
}