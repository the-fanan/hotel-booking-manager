<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Relationships
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function priceLists()
    {
        return $this->hasMany(PriceList::class);
    }
}
