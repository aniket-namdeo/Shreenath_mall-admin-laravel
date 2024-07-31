<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
                // 'address' => $request->input('address')
            ]);

            // Redirect to the user list with a success message
            return redirect('/admin/users-list')->with('success', 'User added successfully');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error creating user: ' . $e->getMessage());

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
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details'));
    }

    public function userUpdate(Request $request, $id)
    {
        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'user_type' => "User",
            // 'address' => $request->input('address')
        );

        $result = User::where(array('id' => $id))->update($data);

        if ($result > 0) {
            return redirect()->route('users-list.list')->with('success', 'User Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

    // public function addUserAddress(Request $request, $id){

    // }

    public function addUserAddress(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'house_address' => 'required|string',
            'street_address' => 'required|string',
            'landmark' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'pincode' => 'required|string',
            'default_address' => 'nullable|integer|in:0,1',
        ]);

        $address = User_addresses::create($validated);

        if ($request->input('default_address') == 1) {
            User_addresses::where('user_id', $request->input('user_id'))
                ->where('id', '!=', $address->id)
                ->update(['default_address' => 0]);
        }

        if ($address > 0) {
            return redirect()->route('users-list.list')->with('success', 'User Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }

        // return response()->json(['message' => 'Address created successfully', 'data' => $address], 201);
    }
}
