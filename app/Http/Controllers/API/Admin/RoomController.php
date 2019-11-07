<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use JD\Cloudder\Facades\Cloudder;

class RoomController extends Controller
{
    public function rooms(Request $request)
    {
        $hotel = $request->user()->hotels()->first();
        return response()->json($hotel->rooms()->get(),200);
    }

    public function createRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "unique:rooms,name"],
            "room_type_id" => ["required", "numeric"],
            "image" => ["required", "mimetypes:image/bmp,image/gif,image/jpeg,image/png,image/tiff"],
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

        $roomFields = $request->only(["name", "room_type_id"]);
        $hotel = $request->user()->hotels()->first();
        //$imageUrl = $this->uploadFile($request->image);
        //$newRoom = $hotel->rooms()->create(array_merge($roomFields, ["image" => $imageUrl["secure_url"]]));
        $newRoom = $hotel->rooms()->create(array_merge($roomFields, ["image" => url($request->file('image')->store('uploads/rooms'))]));
        $response = [
            "message" => "New room created succesfully",
            "room" => $newRoom,
            "status" => "success",
        ];

        return response()->json($response,200);
    }

    public function editRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => ["required", "numeric"],
            "name" => ["required", "string", "unique:rooms,name," . $request->id],
            "room_type_id" => ["required", "numeric"],
            "image" => ["sometimes", "mimetypes:image/bmp,image/gif,image/jpeg,image/png,image/tiff"],
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

        $roomFields = $request->only(["name", "room_type_id"]);
        $hotel = $request->user()->hotels()->first();
        $room = $hotel->rooms()->where("id", $request->id)->first();
        $room->fill($roomFields);

        if ($request->hasFile('image')) {
           // $imageUrl = $this->uploadFile($request->image);
           // $room->image = $imageUrl["secure_url"];
            $room->image  = url($request->file('image')->store('uploads/rooms'));
        }
        $room->save();

        $response = [
            "message" => "Room details updated succesfully",
            "room" => $room,
            "status" => "success",
        ];

        return response()->json($response,200);
    }

    public function deleteRoom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => ["required", "numeric"],
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

        $hotel = $request->user()->hotels()->first();
        $room = $hotel->rooms()->where("id", $request->id)->first();
        $room->forceDelete();

        $response = [
            "message" => "Room deleted succesfully",
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
