<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use Notifiable, HasApiTokens;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
     * Mutators
    */
    public function setEmailAttribute($value) 
    {
        $this->attributes['email'] = strtolower($value);
    }
    
    public function setNameAttribute($value) 
    {
        $value = strtolower($value);
        $this->attributes['name'] = ucwords($value);
    }

    /**
     * Relationships
     */
    public function emailVerification()
    {
        return $this->hasOne(EmailVerification::class,'user_id');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class);
    }
}
