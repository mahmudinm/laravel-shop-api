<?php

namespace App\Api\V1\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;
use App\Category;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $products->load('category');

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();

        return response()->json([
            'categories' => $categories, 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'status' => 'required',
        ]);

        $product = new Product;

        if ($request->file('image')) {
            $file = $request->file('image');
            $namaFile = time()."_".$file->getClientOriginalName();
            $tujuanUpload = public_path().'/image';
            $file->move($tujuanUpload, $namaFile);

            $product->image = $namaFile;
        }

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->status = $request->status;
        $product->save();

        return response()->json(['message' => 'success create data', 'data' => $product]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::find($id);
        $categories = Category::select('id', 'name')->get();

        return response()->json([
            'product' => $products, 
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'status' => 'required',
        ]);        

        $product = Product::find($id);

        if ($request->file('image')) {
            // check jika ada image maka image akan di hapus
            if ($product->image) {
                $imageExist = public_path("image/{$product->image}");
                // image akan di hapus disini
                if (File::exists($imageExist)) {
                    unlink($imageExist);
                }
            }

            $file = $request->file('image');
            $namaFile = time()."_".$file->getClientOriginalName();
            $tujuanUpload = public_path().'/image';
            $file->move($tujuanUpload, $namaFile);

            $product->image = $namaFile;
        }        

        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->status = $request->status;
        $product->save();

        return response()->json(['message' => 'success update data', 'data' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->image) {
            $imageExist = public_path("image/{$product->image}");
            // image akan di hapus disini
            if (File::exists($imageExist)) {
                unlink($imageExist);
            }
        }
                
        $product->delete();

        return response()->json(['message' => 'success delete data', 'data' => $product]);
    }

}
