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
}
