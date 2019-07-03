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
        return response()->json($hotel->priceLists(),200);
    }

    public function createPrice(Request $request)
    {

    }

    public function editPrice(Request $request)
    {
        
    }
}
