<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionRecord extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'promotion_recordID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'promotionID',
        'productID'
    ];

    /**
     * Get the promotion associated with this record.
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotionID', 'promotionID');
    }

    /**
     * Get the product associated with this record.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }
}