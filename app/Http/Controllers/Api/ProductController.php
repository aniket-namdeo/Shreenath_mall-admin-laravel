<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;

class ProductController extends Controller
{

    public function getProduct()
    {
        $product = Product::where('status', 1)->orderBy('id', 'desc')->get();

        return response()->json(['data' => $product], 200);
    }

    // public function getProductByCategory(Request $request)
    // {
    //     $categoryId = $request->input('category_id');
    //     $query = Product::where('status', 'active');
    //     if ($categoryId) {
    //         $query->where('category_id', $categoryId);
    //     }
    //     $products = $query->orderBy('id', 'desc')->get();
    //     $products = $products->map(function ($product) {
    //         $product->price = (int) $product->price;
    //         $product->mrp = (int) $product->mrp;
    //         return $product;
    //     });

    //     return response()->json(['data' => $products], 200);
    // }


    // public function getProductByCategory(Request $request)
    // {
    //     $categoryId = $request->input('category_id');
    //     $filter = $request->input('filter');

    //     $query = Product::where('status', 'active');

    //     if ($categoryId) {
    //         $query->where('category_id', $categoryId);
    //     }

    //     if ($filter) {
    //         switch ($filter) {
    //             case 'price_asc':
    //                 $query->orderBy('price', 'asc');
    //                 break;
    //             case 'price_desc':
    //                 $query->orderBy('price', 'desc');
    //                 break;
    //             case 'popular':
    //                 $query->orderBy('tag', 'popular');
    //                 break;
    //             default:
    //                 $query->orderBy('id', 'desc');
    //                 break;
    //         }
    //     } else {
    //         $query->orderBy('id', 'desc');
    //     }

    //     $products = $query->get();
    //     $products = $products->map(function ($product) {
    //         $product->price = (int) $product->price;
    //         $product->mrp = (int) $product->mrp;
    //         return $product;
    //     });

    //     return response()->json(['data' => $products], 200);
    // }


    // public function getProductByCategory(Request $request)
    // {
    //     $categoryId = $request->input('category_id');
    //     $filter = $request->input('filter');
    //     $tag = $request->input('tag');

    //     $query = Product::where('products.status', 'active')
    //         ->join('category', 'products.category_id', '=', 'category.id')
    //         ->select('products.*');

    //     if ($categoryId) {
    //         $query->where('products.category_id', $categoryId);
    //     }

    //     if ($tag) {
    //         $query->whereRaw('FIND_IN_SET(?, category.tags)', [$tag]);
    //     }

    //     if ($filter) {
    //         switch ($filter) {
    //             case 'price_asc':
    //                 $query->orderBy('products.price', 'asc');
    //                 break;
    //             case 'price_desc':
    //                 $query->orderBy('products.price', 'desc');
    //                 break;
    //             case 'popular':
    //                 $query->orderBy('products.popularity', 'desc');
    //                 break;
    //             default:
    //                 $query->orderBy('products.id', 'desc');
    //                 break;
    //         }
    //     } else {
    //         $query->orderBy('products.id', 'desc');
    //     }

    //     $products = $query->get();

    //     $products = $products->map(function ($product) {
    //         $product->price = (int) $product->price;
    //         $product->mrp = (int) $product->mrp;
    //         return $product;
    //     });

    //     return response()->json(['data' => $products], 200);
    // }

    public function getProductByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        $filter = $request->input('filter');
        $tag = $request->input('tag');
        $productTag = $request->input('productTag');
        $brand = $request->input('brand');

        $query = Product::where('product.status', 'active')
            ->join('category', 'product.category_id', '=', 'category.id')
            ->leftJoin('brand', 'product.brand_id', '=', 'brand.id')
            ->select('product.*');

        if ($categoryId) {
            $query->where('product.category_id', $categoryId);
        }

        if ($productTag) {
            $query->whereRaw('FIND_IN_SET(?, product.tag)', [$productTag]);
        }

        if ($tag) {
            $query->whereRaw('FIND_IN_SET(?, category.tags)', [$tag]);
        }

        if ($brand) {
            $query->where('brand.slug', $brand);
        }

        if ($filter) {
            switch ($filter) {
                case 'price_asc':
                    $query->orderBy('product.price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('product.price', 'desc');
                    break;
                case 'popular':
                    $query->whereRaw('FIND_IN_SET(?, product.tag)', [$filter]);
                    break;
                default:
                    $query->orderBy('product.id', 'desc');
                    break;
            }
        } else {
            $query->orderBy('product.id', 'desc');
        }

        $products = $query->get();

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

    public function searchProduct1(Request $request)
    {
        $searchValue = $request->searchValue;

        $products = Product::where('product_name', 'like', '%' . $searchValue . '%')->get();

        return response()->json(['message' => "get product", 'data' => $products], 200);
    }


    public function searchProduct(Request $request)
    {
        $searchValue = $request->searchValue;

        $products = Product::join('category', 'product.category_id', '=', 'category.id')
            ->where('product.product_name', 'like', '%' . $searchValue . '%')
            ->orWhere('category.name', 'like', '%' . $searchValue . '%')
            ->select('product.*', 'category.name as category_name')
            ->get();

        if ($products->isEmpty()) {
            $products = Product::join('category', 'product.category_id', '=', 'category.id')
                ->where('category.name', 'like', '%' . $searchValue . '%')
                ->select('product.*', 'category.name as category_name')
                ->get();
        }

        return response()->json(['message' => "get product", 'data' => $products], 200);
    }

    public function getBrandsbyCategory(Request $request)
    {
        $categoryId = $request->id;

        if ($categoryId == 0) {
            $brands = Brand::limit(10)->get();
        } else {
            $products = Product::where('category_id', $categoryId)->get();
            $brandIds = $products->pluck('brand_id')->unique();
            $brands = Brand::whereIn('id', $brandIds)->get();
        }
        return response()->json(['success' => true, 'data' => $brands], 200);
    }

    public function getProductTagsByCategory(Request $request)
    {
        $categoryId = $request->id;
        $products = Product::where('category_id', $categoryId)
            ->whereNotNull('tag')
            ->pluck('tag')
            ->toArray();
        $allTags = [];
        foreach ($products as $tags) {
            $tagsArray = array_map('trim', explode(',', $tags));
            $allTags = array_merge($allTags, $tagsArray);
        }
        $uniqueTags = array_unique($allTags);
        return response()->json(['success' => true, 'tags' => array_values($uniqueTags)], 200);
    }

}
