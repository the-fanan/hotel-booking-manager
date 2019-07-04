<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
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
     * The following attributes are appended
     *
     * @return array
     */
    protected $appends = ['price', 'open'];
    /**
     * Accessor
    */
    public function getPriceAttribute() 
    {
        return $this->price();
    }

    public function getOpenAttribute() 
    {
        return false;
    }

    /**
     * Relationships
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * custom functions
     */
    public function price()
    {
        return $this->room->roomType->price()->first()->price;
    }
}
