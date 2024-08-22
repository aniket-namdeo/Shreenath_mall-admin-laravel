<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\OfferSlider;
use Illuminate\Support\Str;

class OfferSliderController extends Controller
{

    public function show()
    {
        $page_name = 'offerSlider/add';
        $current_page = 'offer-slider';
        $page_title = 'Add Offer Slider';
        $list = Category::where(array('status' => 1))->whereNotNull('parentCategoryId')->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function store(Request $request)
    {
        $data['subCategoryId'] = $request->subCategoryId;
        if (!empty($request->banner)) {
            $imageName = time() . '_image_img.' . $request->banner->extension();
            $request->banner->move(public_path('uploads/offerSlider'), $imageName);
            $full_path = "uploads/offerSlider/" . $imageName;
            $data['banner'] = $full_path;
        }

        $response = OfferSlider::create($data);
        return redirect()->route('offer-slider-list.list')->with('success', 'Offer Slider created');
    }

    public function list()
    {
        $page_name = 'offerSlider/list';
        $current_page = 'List';
        $page_title = 'List';

        $list = OfferSlider::select('category.id', 'category.name as category_name', 'offer_slider.*')->leftJoin('category', 'offer_slider.subCategoryId', '=', 'category.id')->where(array('offer_slider.status' => 1))->get();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }


    public function offerSliderEdit(OfferSlider $id)
    {
        $page_name = "offerSlider/edit";
        $page_title = "Manage offerSlider";
        $current_page = "edit-office-slider";
        $details = $id;
        $list = OfferSlider::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        $categorylist = Category::where(array('status' => 1))->whereNotNull('parentCategoryId')->orderBy('id', 'desc')->paginate(20);

        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'list','categorylist'));
    }

    public function offerSliderUpdate(Request $request, $id)
    {
        if ($request->subCategoryId) {
            $data['subCategoryId'] = $request->subCategoryId;
        }
        if (!empty($request->banner)) {
            $imageName = time() . '_image_img.' . $request->banner->extension();
            $request->banner->move(public_path('uploads/offerSlider'), $imageName);
            $full_path = "uploads/offerSlider/" . $imageName;
            $data['banner'] = $full_path;
        }
        if($request->status){
            $data['status'] = $request->status;
        }
        $response = OfferSlider::where(array('id' => $id))->update($data);

        if ($response > 0) {
            return redirect()->route('offer-slider-list.list')->with('success', 'Offer Slider updated');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

}
