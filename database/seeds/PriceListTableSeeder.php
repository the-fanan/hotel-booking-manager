<?php

use Illuminate\Database\Seeder;
use App\Models\Hotel; 

class PriceListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel = Hotel::find(1);
        $hotel->priceLists()->createMany([
            ["price" => 800, "description" => "Master Regular"],
            ["price" => 600, "description" => "Deluxe Regular"],
            ["price" => 400, "description" => "Standard Regular"],
            ["price" => 1000, "description" => "Master Christmas"],
            ["price" => 800, "description" => "Deluxe Chirstmas"],
            ["price" => 600, "description" => "Standard Chirstmas"],
        ]);
    }
}
