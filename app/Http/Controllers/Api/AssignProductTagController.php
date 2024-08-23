<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Tag;
use App\Models\Tag_Product_Assign;
use App\Models\Product;
use Illuminate\Http\Request;

class AssignProductTagController extends Controller
{

    public function getAssignedTagProducts($tagId)
    {

        $data = Tag_Product_Assign::join('product', 'tag_product_assign.productId', '=', 'product.id')
            ->where('tag_product_assign.tagId', $tagId)
            ->select('product.id', 'product.product_name', 'product.description', 'product.price', 'product.created_at')
            ->get();

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Assigned tag products retrieved successfully',
                'data' => $data
            ], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'No data found.', 'data' => null], 500);

        }
    }

    // public function getTagsProduct()
    // {
    //     $tags = Tag::leftJoin('tag_product_assign', 'tag.id', '=', 'tag_product_assign.tagId')
    //         ->leftJoin('product', 'tag_product_assign.productId', '=', 'product.id')
    //         ->select('tag.id as tagId', 'tag.name as tagName', 'product.id as productId', 'product.product_name as productName')
    //         ->get();

    //     $taggedProducts = [];
    //     foreach ($tags as $tag) {
    //         if (!isset($taggedProducts[$tag->tagId])) {
    //             $taggedProducts[$tag->tagId] = [
    //                 'tagName' => $tag->tagName,
    //                 'products' => []
    //             ];
    //         }

    //         if ($tag->productId) {
    //             $taggedProducts[$tag->tagId]['products'][] = [
    //                 'productId' => $tag->productId,
    //                 'productName' => $tag->productName
    //             ];
    //         }
    //     }

    //     return $taggedProducts;
    // }

    public function getTagsProduct()
    {
        $tags = Tag::leftJoin('tag_product_assign', 'tag.id', '=', 'tag_product_assign.tagId')
            ->leftJoin('product', 'tag_product_assign.productId', '=', 'product.id')
            ->select('tag.id as tagId', 'tag.name as tagName', 'product.id as productId', 'product.product_name as productName', 'product.price as productPrice', 'product.mrp as productMrp', 'product.image_url1 as productImage')
            ->get();

        $taggedProducts = [];

        foreach ($tags as $tag) {
            $tagIndex = array_search($tag->tagId, array_column($taggedProducts, 'tagId'));

            if ($tagIndex === false) {
                $taggedProducts[] = [
                    'tagId' => $tag->tagId,
                    'tagName' => $tag->tagName,
                    'products' => []
                ];
                $tagIndex = count($taggedProducts) - 1; 
            }

            // Add product if exists
            if ($tag->productId) {
                $taggedProducts[$tagIndex]['products'][] = [
                    'productId' => $tag->productId,
                    'productName' => $tag->productName,
                    'productPrice' => $tag->productPrice,
                    'productMrp' => $tag->productMrp,
                    'productImage' => $tag->productImage,

                ];
            }
        }

        return $taggedProducts;
    }


}
