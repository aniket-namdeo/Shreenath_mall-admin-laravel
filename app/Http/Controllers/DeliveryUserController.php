<?php

namespace App\Http\Controllers;

use App\Models\DeliveryUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeliveryUserController extends Controller
{
    public function index()
    {
        return view('add');
    }

    public function AddDeliveryUser()
    {
        $page_name = 'delivery_user/add';
        $current_page = 'add-delivery_user';
        $page_title = 'Add Delivery User';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function DeliveryUserList()
    {
        $page_name = 'delivery_user/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = DeliveryUser::orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function AddDeliveryUserPost(Request $request)
    {
        $emailExists = DeliveryUser::where('email', $request->input('email'))->exists();

        if ($emailExists) {
            return redirect()->back()->with('error', 'The email address is already registered.')->withInput();
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_user,email',
            'contact' => 'required|string|digits:10',
            'password' => 'required|string|min:8',
            'address' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|max:10',
            'aadhar_card' => 'required|string|size:12',
            'pan_no' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'vehicle_name' => 'required|string|max:100',
            'vehicle_no' => 'required|string|max:20',
            'vehicle_type' => 'required|string|max:50',
            'vehicle_insurance' => 'required|string|max:50',
            'registration_no' => 'required|string|max:20',
            'driving_license' => 'required|string|max:20',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        try {
            $deliveryUser = new DeliveryUser($validated);

            if ($request->hasFile('profile_image')) {
                $fileName = time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('uploads/delivery_users'), $fileName);
                $deliveryUser->profile_image = $fileName;
            }

            $deliveryUser->password = bcrypt($request->password);
            $deliveryUser->save();

            return redirect()->route('admin.delivery_user.list')->with('success', 'Delivery User added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    public function deliveryUserEdit(DeliveryUser $id)
    {
        $page_name = "delivery_user/edit";
        $page_title = "Manage delivery user";
        $current_page = "delivery_user";
        $deliveryUser = $id;
        // dd($deliveryUser);
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'deliveryUser'));
    }

 
}
