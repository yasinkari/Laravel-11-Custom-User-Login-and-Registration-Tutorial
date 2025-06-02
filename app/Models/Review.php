<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'reviewID';
    protected $fillable = [
        'orderID',
        'comment',
        'rating',
        'showName'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderID');
    }

    // Helper method to get star display
    public function getStarDisplayAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-muted"></i>';
            }
        }
        return $stars;
    }
    
    // New method to get reviews by cartID
    public static function getReviewsByCartID($cartID)
    {
        return self::whereHas('order.cart', function($query) use ($cartID) {
            $query->where('cartID', $cartID);
        })->with(['order.user', 'order.cartRecords.productSizing.productVariant.product'])
          ->latest()
          ->get();
    }
    
    // Method to get reviews by cartRecordID
    public static function getReviewsByCartRecordID($cartRecordID)
    {
        $cartRecord = CartRecord::find($cartRecordID);
        
        if (!$cartRecord) {
            return collect();
        }
        
        return self::whereHas('order.cartRecords', function($query) use ($cartRecord) {
            $query->where('cart_recordID', $cartRecord->cart_recordID)
                  ->where('product_sizingID', $cartRecord->product_sizingID);
        })->with(['order.user'])
          ->latest()
          ->get();
    }
}