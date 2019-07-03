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
}
