<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = (New Product)->newQuery();

        if($request->price_min && $request->price_max) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        } else if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        } else if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }

        if(!empty($request->category_id)) {
            $query->whereIn('category_id', $request->category_id);
        }

        $query->with('category');
        $products = $query->paginate(10);
        $categories = Category::select('name', 'id')->get();

        return response()->json([
          'products' => $products,
          'categories' => $categories
        ]);  
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        $product->load('category');
        
        return response()->json($product);  
    }

}
