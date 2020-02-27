<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Province;
use App\City;
use App\District;
use App\Product;
use App\Order;
use App\OrderDetail;

class CheckoutController extends Controller
{
    public function index()
    {
        $provinces = Province::select('id', 'name')->get();
        
        return response()->json($provinces);  
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'district_id' => 'required',
            'user_phone' => 'required',
            'user_address' => 'required',
            'sub_total' => 'required'            
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'district_id' => $request->user_id,
            'invoice' => Str::random(4).''.time(),
            'user_phone' => $request->user_phone,
            'user_address' => $request->user_address,
            'sub_total' => $request->sub_total,
            'status' => 'UNPAY',
        ]);

        foreach ($request->products as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'price' => $product['price'],
                'weight' => $product['weight'],
                'quantity' => $product['quantity']
            ]);
        }

        return response()->json(['status' => 'success', 'data' => $order]);
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
