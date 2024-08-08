<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{

    public function show()
    {
        $page_name = 'brand/add';
        $current_page = 'add-brand';
        $page_title = 'Add Brand';
        $list = Brand::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function store(Request $request)
    {
        $data['name'] = $request->name;
        if ($request->description) {
            $data['description'] = $request->description;
        }

        $url_slug = Str::slug($request->name . "-");
        $data['slug'] = $url_slug;

        if (!empty($request->logo)) {
            $imageName = time() . '_image_img.' . $request->logo->extension();
            $request->logo->move(public_path('uploads/brand'), $imageName);
            $full_path = "uploads/brand/" . $imageName;
            $data['logo'] = $full_path;
        }
        $response = Brand::create($data);
        // return redirect('/admin/dashboard')->with('success', 'Brand created');
        return redirect()->route('brand-list.list')->with('success', 'Brand updated');

    }

    public function list()
    {
        $page_name = 'brand/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = Brand::where('status', 1)->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }


    public function brandEdit(Brand $id)
    {
        $page_name = "brand/edit";
        $page_title = "Manage brand";
        $current_page = "brand";
        $details = $id;
        $list = Brand::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'list'));
    }

    public function brandUpdate(Request $request, $id)
    {
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        if ($request->logo) {
            if (!empty($request->logo)) {
                $imageName = time() . '_image_img.' . $request->logo->extension();
                $request->logo->move(public_path('uploads/brand'), $imageName);
                $full_path = "uploads/brand/" . $imageName;
                $data['logo'] = $full_path;
            }
        }
        $response = Brand::where(array('id' => $id))->update($data);

        if ($response > 0) {
            return redirect()->route('brand-list.list')->with('success', 'Brand updated');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

}
