<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function show()
    {
        $page_name = 'coupon/add';
        $current_page = 'add-coupon';
        $page_title = 'Add Coupon';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'offtype' => 'required|in:percent,flat',
            'min_purc_amount' => 'required',
            'max_off_amount' => 'required',
            'expiry_date' => 'required|date',
        ]);

        if (!empty($request->image)) {
            $imageName = time() . '_image_img.' . $request->image->extension();
            $request->image->move(public_path('uploads/image'), $imageName);
            $full_path = "uploads/image/" . $imageName;
            $validated['imageUrl'] = $full_path;
        }

        $response = Coupon::create($validated);
        return redirect()->route('coupon-list.list')->with('success', 'Coupon created');
    }

    public function list()
    {
        $page_name = 'coupon/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = Coupon::where(array('status' => 1))->get();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }


    public function couponEdit(Coupon $id)
    {
        $page_name = "coupon/edit";
        $page_title = "Manage coupon";
        $current_page = "coupon";
        $details = $id;
        $list = Coupon::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'list'));
    }

    // public function couponUpdate(Request $request, $id)
    // {

    //     $data = [
    //         'title' => 'string|max:255',
    //         'code' => 'string|max:255',
    //         'offtype' => 'in:percent,flat',
    //         'min_purc_amount' => 'numeric',
    //         'max_off_amount' => 'numeric',
    //         'expiry_date' => 'date',
    //         'status' => 'string|max:255',
    //     ];

    //     if (!empty($request->image)) {
    //         $imageName = time() . '_image_img.' . $request->image->extension();
    //         $request->image->move(public_path('uploads/image'), $imageName);
    //         $full_path = "uploads/image/" . $imageName;
    //         $data['imageUrl'] = $full_path;
    //     }


    //     $response = Coupon::where(array('id' => $id))->update($data);

    //     if ($response > 0) {
    //         return redirect()->route('coupon-list.list')->with('success', 'Coupon updated');
    //     } else {
    //         return redirect()->back()->with('error', 'Something went Wrong');
    //     }
    // }

    public function couponUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'offtype' => 'required|in:percent,flat',
            'min_purc_amount' => 'required|numeric',
            'max_off_amount' => 'required|numeric',
            'status' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $coupon = Coupon::find($id);
        if (!$coupon) {
            return redirect()->back()->with('error', 'Coupon not found.');
        }

        $coupon->title = $request->input('title');
        $coupon->code = $request->input('code');
        $coupon->offtype = $request->input('offtype');
        $coupon->min_purc_amount = $request->input('min_purc_amount');
        $coupon->max_off_amount = $request->input('max_off_amount');
        // $coupon->expiry_date = $request->input('expiry_date');
        $coupon->status = $request->input('status');

        if ($request->hasFile('image')) {
            $imageName = time() . '_image_img.' . $request->image->extension();
            $request->image->move(public_path('uploads/image'), $imageName);
            $full_path = "uploads/image/" . $imageName;
            $coupon->imageUrl = $full_path;
        }

        $coupon->save();

        return redirect()->route('coupon-list.list')->with('success', 'Coupon updated successfully.');
    }


}
