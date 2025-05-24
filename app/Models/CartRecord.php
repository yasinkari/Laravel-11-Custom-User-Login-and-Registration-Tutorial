<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_recordID';
    protected $fillable = [
        'cartID',
        'product_sizingID',
        'quantity'
    ];
    
    public function productSizing()
    {
        return $this->belongsTo(ProductSizing::class, 'product_sizingID');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cartID');
    }
}