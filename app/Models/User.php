<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// use Laravel\Fortify\TwoFactorAuthentication;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable ; //TwoFactorAuthentication

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userName',
        'firstName',
        'lastName',
        'phone',
        'bio',
        'ip',
        'avatar',
        'status',
        'email',
        'password',
        'countrylist_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get User Wallet Address
     */
    public function getUserbyWallet()
    {
        return $this->hasMany(Wallet::class);
    }

    public function getUserwithflag()
    {
        return $this->belongsTo(Countrylist::class);
        //return $this->hasOne(Countrylist::class);
    }
}
