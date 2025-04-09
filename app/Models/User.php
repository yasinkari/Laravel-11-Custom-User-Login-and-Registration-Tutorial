<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

<<<<<<< HEAD
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Add role if it's fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
=======
    protected $primaryKey = 'userID';
    protected $fillable = [
        'user_name',
        'email',
        'password',
        'user_phone',
        'user_address',
        'user_role'
    ];

>>>>>>> master
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
=======
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'userID');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'userID');
>>>>>>> master
    }
}
