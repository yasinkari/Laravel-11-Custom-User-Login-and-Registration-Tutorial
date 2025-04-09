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
        'total_amount'  // Changed from totalAmount to match migration
    ];

    // Remove product() relationship as it's not in the migration
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function cartRecords()
    {
        return $this->hasMany(CartRecord::class, 'cartID');
    }
}