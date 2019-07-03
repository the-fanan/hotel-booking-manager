<?php

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Room::class, 15)->create()->each(function ($room) {
            $room->bookings()->save(factory(Booking::class)->make());
        });
    }
}
