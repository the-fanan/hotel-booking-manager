<?php

use Illuminate\Database\Seeder;
use App\Models\Hotel; 

class RoomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel = Hotel::find(1);
        $hotel->roomTypes()->createMany([
            ["name" => "Master", "price_list_id" => 1],
            ["name" => "Deluxe", "price_list_id" => 2],
            ["name" => "Standared", "price_list_id" => 3],
        ]);
    }
}
