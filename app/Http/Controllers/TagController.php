<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Tag_Product_Assign;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function show()
    {
        $page_name = 'tags/add';
        $current_page = 'add-tag';
        $page_title = 'Add tag';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function store(Request $request)
    {
        $data['name'] = $request->name;
        $url_slug = Str::slug($request->name . "-");
        $data['slug'] = $url_slug;

        $response = tag::create($data);
        return redirect()->route('tag-list.list')->with('success', 'Tag created');
    }

    public function list()
    {
        $page_name = 'tags/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = tag::where(array('status' => 1))->get();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function tagEdit(tag $id)
    {
        $page_name = "tags/edit";
        $page_title = "Manage tag";
        $current_page = "tag";
        $details = $id;
        $list = tag::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'list'));
    }

    public function tagUpdate(Request $request, $id)
    {
        $data['name'] = $request->name;
        $response = tag::where(array('id' => $id))->update($data);

        if ($response > 0) {
            return redirect()->route('tag-list.list')->with('success', 'Tag updated');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

    public function productTagAssign(Request $request, $id)
    {
        $page_name = "tags/assign-product";
        $page_title = "Manage assign product";
        $current_page = "tag assign product";
        $productData = Product::where('status', 1)->limit(10)->get();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'productData', 'id'));
    }

    public function AssignProductTags(Request $request)
    {
        $productIds = $request->input('product');
        $tagId = $request->input('tag_id');

        foreach ($productIds as $productId) {
            Tag_Product_Assign::create([
                'productId' => $productId,
                'tagId' => $tagId,
            ]);
        }

        return redirect(url('/admin/productTagAssign-list/'.$tagId))->with('success', 'Tags assigned to products successfully.');
    }



}
