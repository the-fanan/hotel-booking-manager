<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function createBookingForUnregisteredUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "customer_name" => ["required", "string"],
            "customer_email" => ["required", "string"],
            "room_id" => ["required", "numeric"],
            "start_date" => ["required", "date"],
            "end_date" => ["required", "date"],
        ]);

        if ($validator->fails()) {
            $error["message"] = "Invalid or missing input fields";
            $validation_messages = "";
            foreach ($validator->errors()->toArray() as $name => $value) {
                $validation_messages .= $value[0] . " ";
            }
            $error["validation_messages"] = $validation_messages;
            $error["status"] = "error";
            return response()->json($error, 401);
        }

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $possibleConflict = $hotel->bookings()->where('room_id', '=', $request->room_id)
        ->where(function($q) use ($startDate, $endDate) {
            $q->where(function($q2) use ($startDate) {
                $q2->where('end_date', '>', $startDate)
                ->Where('start_date', '<', $startDate);
            })->orWhere(function($q3) use ($endDate) {
                $q3->where('end_date', '>', $endDate)
                ->Where('start_date', '<', $endDate);
            });    
        })->get();

        if (!$possibleConflict->isEmpty()) {
            //if conflicts exist
            $error["message"] = "The selected room already has a booking that will conflict with this one.";
            $validation_messages = "";
            $error["validation_messages"] = $validation_messages;
            $error["status"] = "error";
            return response()->json($error, 401);
        }


        $bookingFields = $request->only(["customer_name", "customer_email", "room_id", "start_date", "end_date",]);
        $newBooking = Booking::create($bookingFields);
        $response = [
            "message" => "New booking created succesfully",
            "booking" => $newBooking,
            "status" => "success",
        ];

        return response()->json($response,200);
    }
}
