<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function show()
    {
        $page_name = 'category/add';
        $current_page = 'add-category';
        $page_title = 'Add Category';
        $list = Category::where(array('status' => 1))->whereNull('parentCategoryId')->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function subCategoryShow()
    {
        $page_name = 'category/addSub';
        $current_page = 'add-subcategory';
        $page_title = 'Add Category';
        $list = Category::where(array('status' => 1))->whereNull('parentCategoryId')->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function store(Request $request)
    {
        $data['name'] = $request->name;

        $url_slug = Str::slug($request->name . "-");
        $data['slug'] = $url_slug;

        if (!empty($request->category)) {
            $data['parentCategoryId'] = $request->category;
        }

        if (!empty($request->image)) {
            $imageName = time() . '_image_img.' . $request->image->extension();
            $request->image->move(public_path('uploads/image'), $imageName);
            $full_path = "uploads/image/" . $imageName;
            $data['image'] = $full_path;
        }
        $response = Category::create($data);
        return redirect('/admin/category-list')->with('success', 'Category created');
    }

    public function categorylist()
    {
        $page_name = 'category/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = Category::from('category as c1')
            ->leftJoin('category as c2', 'c1.parentCategoryId', '=', 'c2.id')
            ->select('c1.*', 'c2.name as parentCategoryName')
            ->where('c1.status', 1)
            ->whereNull('c1.parentCategoryId')
            ->orderBy('c1.id', 'desc')
            ->paginate(20);

        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function subcategorylist()
    {
        $page_name = 'category/sublist';
        $current_page = 'Sub CategoryList';
        $page_title = 'List';
        $list = Category::from('category as c1')
            ->leftJoin('category as c2', 'c1.parentCategoryId', '=', 'c2.id')
            ->select('c1.*', 'c2.name as parentCategoryName')
            ->whereNotNull('c1.parentCategoryId')
            ->where('c1.status', 1)
            ->orderBy('c1.id', 'desc')
            ->paginate(20);

        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function categoryEdit(Category $id)
    {
        $page_name = "category/edit";
        $page_title = "Manage category";
        $current_page = "category";
        $details = $id;
        $list = Category::where(array('status' => 1))->whereNull('parentCategoryId')->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'list'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $data['name'] = $request->name;
        $data['parentCategoryId'] = $request->parentCategoryId;

        if ($request->image) {
            if (!empty($request->image)) {
                $imageName = time() . '_image_img.' . $request->image->extension();
                $request->image->move(public_path('uploads/image'), $imageName);
                $full_path = "uploads/image/" . $imageName;
                $data['image'] = $full_path;
            }
        }

        $data['tags'] = $request->tags;

        $response = Category::where(array('id' => $id))->update($data);

        if ($response > 0) {
            return redirect()->route('category-list.show')->with('success', 'Category updated');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

}
