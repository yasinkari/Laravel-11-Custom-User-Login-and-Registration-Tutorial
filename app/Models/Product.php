<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'productID';
    
    protected $fillable = [
        'product_name',
        'product_price',
        'product_description',
        'is_visible'
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'productID');
    }
    
    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'productID');
    }
    
    /**
     * Get active promotion for this product if any exists
     */
    public function getActivePromotionAttribute()
    {
        return $this->promotions()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where(function($query) {
                $query->where('end_date', '>=', now())
                      ->orWhereNull('end_date');
            })
            ->first();
    }
    
    /**
     * Get the current price after applying any active promotions
     */
    public function getCurrentPriceAttribute()
    {
        $promotion = $this->activePromotion;
        
        if (!$promotion) {
            return $this->product_price;
        }
        
        $price = $this->product_price;
        
        if ($promotion->promotion_type == 'percentage') {
            $price = $price * (1 - ($promotion->discount_amount / 100));
        } elseif ($promotion->promotion_type == 'fixed') {
            $price = $price - $promotion->discount_amount;
        }
        
        return max(0, $price);
    }
}
