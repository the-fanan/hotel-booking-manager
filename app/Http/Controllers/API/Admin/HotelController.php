<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JD\Cloudder\Facades\Cloudder;

class HotelController extends Controller
{
    public function getHotel(Request $request)
    {
        $hotel = $request->user()->hotels()->first();
        return response()->json($hotel,200);
    }

    public function updateHotel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => ["required", "numeric"],
            "name" => ["required", "string"],
            "city" => ["required"],
            "state" => ["required"],
            "country" => ["required"],
            "zipcode" => ["required"],
            "phone" => ["required"],
            "email" => ["required", "email", "unique:hotels,email," . $request->id],
            "image" => ["sometimes", "mimetypes:image/bmp,image/gif,image/jpeg,image/png,image/tiff"]
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

        
        $hotelFields = $request->only(["name", "city", "state", "country", "zipcode", "phone", "email"]);
        $hotel = $request->user()->hotels()->first();

        if ($request->hasFile('image')) {
            $newImageUrl = $this->uploadFile($request->image);
            $hotel->image = $newImageUrl["secure_url"];
        }
       
        $hotel->fill($hotelFields);
        $hotel->save();

        $response = [
            "message" => "Hotel details updated succesfully",
            "hotel" => $hotel,
            "status" => "success",
        ];

        return response()->json($response,200);
    }

    /**
     * Functions not related to routes
     */
    public function uploadFile($resource) {
        $fileName = time() . str_random(4) . "." .  $resource->extension();
        Cloudder::upload($resource->getRealPath(), $fileName, ["unique_filename" => false]);
        return Cloudder::getResult();
    }
}
