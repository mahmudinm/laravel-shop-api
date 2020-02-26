<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Province;
use App\City;
use App\District;

class CheckoutController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        
        return response()->json($provinces);  
    }

    public function store(Request $request)
    {
                
    }

    public function getCity($province)
    {
        $cities = City::where('province_id', $province)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);        
    }

    public function getDistrict($city)
    {
        $districts = District::where('city_id', $city)->get();
        return response()->json(['status' => 'success', 'data' => $districts]);        
    }
}
