<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cartID';
    protected $fillable = [
        'userID',
        'totalAmount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID');
    }

    public function cartRecords()
    {
        return $this->hasMany(CartRecord::class, 'cartID');
    }
}