<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            "name" => "Fanan Dala",
            "email" => "fanan.dala@yahoo.com",
            "password" => Hash::make("fanan123"),
            "email_verified" => 1,
        ]);
    }
}
