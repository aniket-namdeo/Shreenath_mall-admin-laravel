<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\User_addresses;

class UserController extends Controller
{
    public function index()
    {
        return view('add');
    }

    public function AddUser()
    {
        $page_name = 'users/add';
        $current_page = 'add-user';
        $page_title = 'Add User';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function UserList()
    {
        $page_name = 'users/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = User::where(array('status' => 1))->where('user_type', '!=', 'Admin')->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }

    public function AddUserPost(Request $request)
    {
        $emailExists = User::where('email', $request->input('email'))->exists();

        if ($emailExists) {
            // Redirect back with an error message if the email already exists
            return redirect()->back()->with('error', 'The email address is already registered.')->withInput();
        }

        try {
            // Create the user
            $result = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'contact' => $request->input('contact'),
                'password' => Hash::make($request->input('password')),
                'user_type' => "User",
            ]);

            $validatedAddressData = $request->validate([
                'house_address' => 'nullable|string',
                'street_address' => 'nullable|string',
                'landmark' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'country' => 'nullable|string',
                'pincode' => 'nullable|string',
                'default_address' => 'nullable|integer|in:0,1',
            ]);

            $validatedAddressData['user_id'] = $result->id;

            $address = User_addresses::create($validatedAddressData);

            if ($validatedAddressData['default_address'] == 1) {
                User_addresses::where('user_id', $result->id)
                    ->where('id', '!=', $address->id)
                    ->update(['default_address' => 0]);
            }

            if ($request->input('default_address') == 1) {
                User_addresses::where('user_id', $result->id)
                    ->where('id', '!=', $address->id)
                    ->update(['default_address' => 0]);
            }

            return redirect('/admin/users-list')->with('success', 'User added successfully');
        } catch (\Exception $e) {

            // Redirect back with a generic error message
            return redirect()->back()->with('error', 'Something went wrong while creating the user. Please try again.');
        }
    }

    public function userEdit(User $id)
    {
        $page_name = "users/edit";
        $page_title = "Manage Users";
        $current_page = "users";
        $details = $id;
        $detailAddress = User_addresses::where('user_id', $id->id)->get();
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'detailAddress'));
    }

    public function userUpdate(Request $request, $id)
    {
        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'user_type' => "User",
        );

        $result = User::where('id', $id)->update($data);

        if ($result) {
            // Validate address inputs
            $request->validate([
                'house_address.*' => 'nullable|string',
                'street_address.*' => 'nullable|string',
                'landmark.*' => 'nullable|string',
                'city.*' => 'nullable|string',
                'state.*' => 'nullable|string',
                'country.*' => 'nullable|string',
                'pincode.*' => 'nullable|string',
                'default_address.*' => 'nullable|integer|in:0,1',
            ]);

            $houseAddresses = $request->input('house_address');
            $streetAddresses = $request->input('street_address');
            $landmarks = $request->input('landmark');
            $cities = $request->input('city');
            $states = $request->input('state');
            $countries = $request->input('country');
            $pincodes = $request->input('pincode');
            $defaultAddresses = $request->input('default_address');

            // Fetch existing addresses
            $existingAddresses = User_addresses::where('user_id', $id)->get();
            $existingAddressesMap = $existingAddresses->keyBy('id');

            // Prepare to delete addresses that are not included in the update
            $submittedAddressIds = [];

            foreach ($houseAddresses as $index => $houseAddress) {
                // Create or update address
                $addressData = [
                    'user_id' => $id,
                    'house_address' => $houseAddresses[$index],
                    'street_address' => $streetAddresses[$index],
                    'landmark' => $landmarks[$index],
                    'city' => $cities[$index],
                    'state' => $states[$index],
                    'country' => $countries[$index],
                    'pincode' => $pincodes[$index],
                    'default_address' => $defaultAddresses[$index],
                ];

                $addressId = $request->input('address_id')[$index] ?? null; // Assuming you have address IDs
                if ($addressId) {
                    // Update existing address
                    User_addresses::where('id', $addressId)->update($addressData);
                    $submittedAddressIds[] = $addressId;
                } else {
                    // Create new address
                    $address = User_addresses::create($addressData);
                    $submittedAddressIds[] = $address->id;
                }

                // Set default address
                if ($addressData['default_address'] == 1) {
                    User_addresses::where('user_id', $id)
                        ->where('id', '!=', $addressId)
                        ->update(['default_address' => 0]);
                }
            }

            // Delete addresses that are not in the submitted list
            User_addresses::where('user_id', $id)
                ->whereNotIn('id', $submittedAddressIds)
                ->delete();

            return redirect()->route('users-list.list')->with('success', 'User Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

    public function state($country_id){
        
        $state = State::where(array('country_id'=>$country_id))->get();

        return $state;
    }

    public function city($state_id){
        
        $city = City::where(array('state_id'=>$state_id))->get();

        return $city;
    }

}
