<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Booking;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    return [
        "hotel_id" => 1,
        "customer_name" => $faker->name,
        "customer_email" => $faker->email,
        "start_date" => Carbon::now(),
        "end_date" => Carbon::now()->addDays(4),
    ];
});
