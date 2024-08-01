<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{

    public function getProduct()
    {
        $product = Product::where('status', 1)->orderBy('id', 'desc')->get();

        return response()->json(['data' => $product], 200);
    }

    // public function getProductByCategory()
    // {
    //     $product = product::where('status', 1)->orderBy('id', 'desc')->get();
    //     return response()->json(['data' => $product], 200);
    // }

    public function getProductByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        $query = Product::where('status', 'active');
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $products = $query->orderBy('id', 'desc')->get();
        $products = $products->map(function ($product) {
            $product->price = (int) $product->price;
            $product->mrp = (int) $product->mrp;
            return $product;
        });
    
        return response()->json(['data' => $products], 200);
    }

    public function getProductById($id)
    {
        $product = Product::where('id', $id)->where('status', 1)->orderBy('id', 'desc')->first();

        if ($product) {

            return response()->json(['message' => "got product", 'data' => $product], 200);
        } else {
            return response()->json(['message' => "no product with this id", 'data' => null], 200);

        }
    }


}
