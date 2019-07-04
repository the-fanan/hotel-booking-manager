<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function bookings(Request $request)
    {
        $hotel = $request->user()->hotels()->first();
        return response()->json($hotel->bookings()->get(),200);
    }

    public function createBooking(Request $request)
    {

    }

    public function editBooking(Request $request)
    {

    }

    public function deleteBooking(Request $request)
    {

    }
}
