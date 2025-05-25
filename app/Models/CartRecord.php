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

    public function productVariant()
    {
        return $this->hasOneThrough(
            ProductVariant::class,
            ProductSizing::class,
            'product_sizingID', // Foreign key on ProductSizing table
            'product_variantID', // Foreign key on ProductVariant table
            'product_sizingID', // Local key on CartRecord table
            'product_variantID' // Local key on ProductSizing table
        );
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cartID');
    }
}