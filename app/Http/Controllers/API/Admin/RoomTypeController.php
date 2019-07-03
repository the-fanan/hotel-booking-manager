<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RoomTypeController extends Controller
{
    public function roomTypes(Request $request)
    {
        $hotel = $request->user()->hotels()->first();
        return response()->json($hotel->roomTypes()->get(),200);
    }

    public function createRoomType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "price_list_id" => ["required", "numeric"],
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

        $roomTypeFields = $request->only(["name", "price_list_id"]);
        $hotel = $request->user()->hotels()->first();
        $newRoomType = $hotel->roomTypes()->create($roomTypeFields);

        $response = [
            "message" => "New room type created succesfully",
            "roomType" => $newRoomType,
            "status" => "success",
        ];

        return response()->json($response,200);
    }

    public function editRoomType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => ["required", "numeric"],
            "name" => ["required", "string"],
            "price_list_id" => ["required", "numeric"],
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

        $roomTypeFields = $request->only(["name", "price_list_id"]);
        $hotel = $request->user()->hotels()->first();
        $roomType = $hotel->roomTypes()->where("id", $request->id)->first();
        $roomType->fill($roomTypeFields);
        $roomType->save();

        $response = [
            "message" => "Room type details updated succesfully",
            "status" => "success",
        ];

        return response()->json($response,200);
    }

    
}
