<?php

namespace App\Http\Controllers;

use App\Models\DeliveryUser;
use App\Models\State;
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
        // dd($list);
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
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|max:10',
            'profile_image' => 'nullable|image|max:2048',
            // 'aadhar_card' => 'required|string|size:12',
            // 'pan_no' => 'required|string|max:10',
            // 'city' => 'required|string|max:100',
            // 'state' => 'required|string|max:100',
            // 'vehicle_name' => 'required|string|max:100',
            // 'vehicle_no' => 'required|string|max:20',
            // 'vehicle_type' => 'required|string|max:50',
            // 'vehicle_insurance' => 'required|string|max:50',
            // 'registration_no' => 'required|string|max:20',
            // 'driving_license' => 'required|string|max:20',
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
        $state = State::where(array('country_id' => 101))->get();
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'deliveryUser', 'state'));
    }

    public function DeliveryUserUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|min:10|max:10',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'address' => 'required|string|max:255',
            'state' => 'required|string',
            'city' => 'required|string',
            'vehicle_name' => 'required|string|max:255',
            'vehicle_no' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
        ]);

        $deliveryUser = DeliveryUser::findOrFail($id);

        $deliveryUser->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'address' => $request->address,
            'state' => $request->state,
            'city' => $request->city,
            'vehicle_name' => $request->vehicle_name,
            'vehicle_no' => $request->vehicle_no,
            'vehicle_type' => $request->vehicle_type,
        ]);
        if ($request->password) {
            $deliveryUser->update([
                'password' => Hash::make($request->password),
            ]);
        }
        return redirect()->back()->with('success', 'Basic details updated successfully.');
    }

    public function DeliveryUserDocupdate(Request $request, $id)
    {
        $request->validate([
            'aadhar_card' => 'required|string|max:255',
            'pan_no' => 'required|string|max:255',
            'registration_no' => 'required|string|max:255',
            'driving_license' => 'required|string|max:255',
            'vehicle_insurance' => 'required|string|max:255',
            'status' => 'required|string|in:pending,verified',
        ]);

        $deliveryUser = DeliveryUser::findOrFail($id);

        $data = [
            'aadhar_card' => $request->aadhar_card,
            'pan_no' => $request->pan_no,
            'registration_no' => $request->registration_no,
            'driving_license' => $request->driving_license,
            'vehicle_insurance' => $request->vehicle_insurance,
            'status' => $request->status,
        ];

        if (!empty($request->aadhar_doc)) {
            $imageName = time() . '_image_img.' . $request->aadhar_doc->extension();
            $request->aadhar_doc->move(public_path('uploads/deliveryUser'), $imageName);
            $full_path = "uploads/deliveryUser/" . $imageName;
            $data['aadhar_doc'] = $full_path;

        }
        if (!empty($request->pan_doc)) {
            $imageName = time() . '_image_img.' . $request->pan_doc->extension();
            $request->pan_doc->move(public_path('uploads/deliveryUser'), $imageName);
            $full_path = "uploads/deliveryUser/" . $imageName;
            $data['pan_doc'] = $full_path;
        }
        if (!empty($request->registration_doc)) {
            $imageName = time() . '_image_img.' . $request->registration_doc->extension();
            $request->registration_doc->move(public_path('uploads/deliveryUser'), $imageName);
            $full_path = "uploads/deliveryUser/" . $imageName;
            $data['registration_doc'] = $full_path;
        }
        if (!empty($request->license_doc)) {
            $imageName = time() . '_image_img.' . $request->license_doc->extension();
            $request->license_doc->move(public_path('uploads/deliveryUser'), $imageName);
            $full_path = "uploads/deliveryUser/" . $imageName;
            $data['license_doc'] = $full_path;
        }
        if (!empty($request->insurance_doc)) {
            $imageName = time() . '_image_img.' . $request->insurance_doc->extension();
            $request->insurance_doc->move(public_path('uploads/deliveryUser'), $imageName);
            $full_path = "uploads/deliveryUser/" . $imageName;
            $data['insurance_doc'] = $full_path;
        }

        $deliveryUser->update($data);

        return redirect()->back()->with('success', 'Additional details updated successfully.');
    }



}
