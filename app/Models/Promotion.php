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
        'promotion_name',
        'promotion_type',
        'start_date',
        'end_date',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the products associated with the promotion through promotion records.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_records', 'promotionID', 'productID');
    }

    /**
     * Get the promotion records for this promotion.
     */
    public function promotionRecords()
    {
        return $this->hasMany(PromotionRecord::class, 'promotionID', 'promotionID');
    }
}