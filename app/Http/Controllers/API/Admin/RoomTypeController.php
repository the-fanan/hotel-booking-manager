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
}
