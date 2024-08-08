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
        $list = DeliveryUser::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
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

    // public function userUpdate(Request $request, $id)
    // {
    //     $data = array(
    //         'name' => $request->input('name'),
    //         'email' => $request->input('email'),
    //         'contact' => $request->input('contact'),
    //         'user_type' => "DeliveryUser",
    //     );

    //     $result = DeliveryUser::where('id', $id)->update($data);

    //     if ($result) {
    //         // Validate address inputs
    //         $request->validate([
    //             'house_address.*' => 'nullable|string',
    //             'street_address.*' => 'nullable|string',
    //             'landmark.*' => 'nullable|string',
    //             'city.*' => 'nullable|string',
    //             'state.*' => 'nullable|string',
    //             'country.*' => 'nullable|string',
    //             'pincode.*' => 'nullable|string',
    //             'default_address.*' => 'nullable|integer|in:0,1',
    //         ]);

    //         $houseAddresses = $request->input('house_address');
    //         $streetAddresses = $request->input('street_address');
    //         $landmarks = $request->input('landmark');
    //         $cities = $request->input('city');
    //         $states = $request->input('state');
    //         $countries = $request->input('country');
    //         $pincodes = $request->input('pincode');
    //         $defaultAddresses = $request->input('default_address');

    //         // Fetch existing addresses
    //         $existingAddresses = User_addresses::where('user_id', $id)->get();
    //         $existingAddressesMap = $existingAddresses->keyBy('id');

    //         // Prepare to delete addresses that are not included in the update
    //         $submittedAddressIds = [];

    //         foreach ($houseAddresses as $index => $houseAddress) {
    //             // Create or update address
    //             $addressData = [
    //                 'user_id' => $id,
    //                 'house_address' => $houseAddresses[$index],
    //                 'street_address' => $streetAddresses[$index],
    //                 'landmark' => $landmarks[$index],
    //                 'city' => $cities[$index],
    //                 'state' => $states[$index],
    //                 'country' => $countries[$index],
    //                 'pincode' => $pincodes[$index],
    //                 'default_address' => $defaultAddresses[$index],
    //             ];

    //             $addressId = $request->input('address_id')[$index] ?? null; // Assuming you have address IDs
    //             if ($addressId) {
    //                 // Update existing address
    //                 User_addresses::where('id', $addressId)->update($addressData);
    //                 $submittedAddressIds[] = $addressId;
    //             } else {
    //                 // Create new address
    //                 $address = User_addresses::create($addressData);
    //                 $submittedAddressIds[] = $address->id;
    //             }

    //             // Set default address
    //             if ($addressData['default_address'] == 1) {
    //                 User_addresses::where('user_id', $id)
    //                     ->where('id', '!=', $addressId)
    //                     ->update(['default_address' => 0]);
    //             }
    //         }

    //         // Delete addresses that are not in the submitted list
    //         User_addresses::where('user_id', $id)
    //             ->whereNotIn('id', $submittedAddressIds)
    //             ->delete();

    //         return redirect()->route('users-list.list')->with('success', 'DeliveryUser Updated successfully');
    //     } else {
    //         return redirect()->back()->with('error', 'Something went Wrong');
    //     }
    // }
}
