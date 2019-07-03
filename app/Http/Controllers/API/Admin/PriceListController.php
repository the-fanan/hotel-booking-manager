<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PriceListController extends Controller
{
    public function prices(Request $request)
    {
        $hotel = $request->user()->hotels()->first();
        return response()->json($hotel->priceLists()->get(),200);
    }

    public function createPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "description" => ["required", "string"],
            "price" => ["required", "numeric"],
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

        $priceFields = $request->only(["description", "price"]);
        $hotel = $request->user()->hotels()->first();
        $newPrice = $hotel->priceLists()->create($priceFields);

        $response = [
            "message" => "New price created succesfully",
            "price" => $newPrice,
            "status" => "success",
        ];

        return response()->json($response,200);
    }

    public function editPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => ["required", "numeric"],
            "description" => ["required", "string"],
            "price" => ["required", "numeric"],
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

        $priceFields = $request->only(["description", "price"]);
        $hotel = $request->user()->hotels()->first();
        $price = $hotel->priceLists()->where("id", $request->id)->first();
        $price->fill($priceFields);
        $price->save();

        $response = [
            "message" => "Price details updated succesfully",
            "status" => "success",
        ];

        return response()->json($response,200);
    }

    public function deletePrice()
    {

    }
}
