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

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'toneID');
    }

    public function toneRecords()
    {
        return $this->hasMany(ToneRecord::class, 'toneID');
    }
}