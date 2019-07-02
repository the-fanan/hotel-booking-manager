<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{
    public function getHotel(Request $request)
    {
        $hotel = $request->user()->hotels()->first();
        return response()->json($hotel,200);
    }

}
