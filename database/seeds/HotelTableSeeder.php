<?php

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hotel::create([
            "name" => "Code Line Hotel",
            "address" => "16 A, Simpson Street",
            "city" => "Lekki",
            "state" => "Lagos",
            "country" => "Nigeria",
            "zipcode" => "12345",
            "phone" => "+4480984734",
            "email" => "info@codelinehotel.com",
            "image" => "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106753/architecture-building-casino-812628_pqdnai.jpg",
        ]);
    }
}
