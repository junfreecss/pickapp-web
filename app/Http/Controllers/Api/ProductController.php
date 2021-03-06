<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller {

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => ['required'],
            'category' => ['required'],
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
            'cover_url' => ['required'],
            'num_of_stock' => ['required'],
        ]);
        
        if ($validator->fails()) {
            // The given data did not pass validation
            return response()->json([
              "status" => false,
              "message" => 'Invalid details!',
              "errors" => $validator->errors()
            ], 200);
        }

        $product = new Product();
        $product->store_id = $request->store_id;
        $product->category = $request->category;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->cover_url = $request->cover_url;
        $product->num_of_stock = $request->num_of_stock;
        $product->save();

        return response()->json([
            "status" => "success",
            "products" => [$product]
        ]);
    }

    public function get(Request $request)
    {
        $products = Product::where('store_id', $request->store_id)
            ->where('category', $request->category)
            ->get();
            
        return response()->json([
            "status" => "success",
            "products" => $products
        ]);
    }

    public function getAll(Request $request, $category)
    {
        $products = Product::where('num_of_stock', '>', 0)
            ->where('category', $category)
            ->get();
            
        return response()->json([
            "status" => "success",
            "products" => $products
        ]);
    }

}