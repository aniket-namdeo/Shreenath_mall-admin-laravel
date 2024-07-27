<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function getCategory()
    {
        $categories = Category::select('id', 'name', 'parentCategoryId', 'image')->where('status', 1)->orderBy('id', 'desc')->get();

        $categoriesArray = $categories->keyBy('id')->toArray();

        $structuredCategories = [];

        foreach ($categoriesArray as $id => &$category) {
            if ($category['parentCategoryId']) {
                if (!isset($categoriesArray[$category['parentCategoryId']]['children'])) {
                    $categoriesArray[$category['parentCategoryId']]['subcategory'] = [];
                }
                $categoriesArray[$category['parentCategoryId']]['subcategory'][] = $category;
            } else {
                $structuredCategories[] = $category;
            }
        }

        return response()->json(['data' => $structuredCategories], 200);
    }



}
