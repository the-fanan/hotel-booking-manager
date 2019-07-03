<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        "name" => ucfirst($faker->randomLetter()) . $faker->randomDigit(),
        "hotel_id" => 1,
        "room_type_id" => $faker->numberBetween(1,3),
        "image" => $faker->randomElements(["https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106755/bed-bedroom-furniture-279746_xcfm0v.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106755/bed-bedroom-chair-271619_kk6pey.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106755/bed-bedroom-clean-775219_q6rf1l.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106755/bed-bedroom-cozy-164595_c2o9lp.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106755/bed-bedroom-furniture-271616_x2r8vm.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106754/bed-bedroom-blue-172872_qx1xyy.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106754/bed-bedroom-blanket-1743231_plrmbw.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106753/apartment-beach-bed-271643_c2lac1.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106753/accommodation-beach-bed-1531672_czmk5z.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106753/apartment-bed-bedroom-271618_bghgqz.jpg", "https://res.cloudinary.com/dxmdrnjfo/image/upload/v1562106753/apartment-bed-bedroom-545034_a3gbtq.jpg"],1,true)[0],
        
    ];
});
