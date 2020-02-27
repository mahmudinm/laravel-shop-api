<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all()->random(8);
        
        return response()->json($products);
    }

}
