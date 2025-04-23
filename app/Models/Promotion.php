<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'promotionID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'productID',
        'promotion_name',
        'promotion_type',
        'discount_amount',
        'start_date',
        'end_date',
        'is_active'
    ];

    /**
     * Get the product that owns the promotion.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'productID');
    }
}