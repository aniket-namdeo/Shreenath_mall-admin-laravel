<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AboutUs;
use Illuminate\Support\Str;

class AboutUsController extends Controller
{

    public function show()
    {
        $page_name = 'aboutus/add';
        $current_page = 'add-aboutus';
        $page_title = 'Add Privacy Policy';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function store(Request $request)
    {
        $data['content'] = $request->content;

        $response = AboutUs::create($data);
        return redirect()->route('aboutus-list.list')->with('success', 'About Us created');
    }

    public function list()
    {
        $page_name = 'aboutus/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = AboutUs::where(array('status' => 1))->get();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }


    public function aboutusEdit(AboutUs $id)
    {
        $page_name = "aboutus/edit";
        $page_title = "Manage aboutus";
        $current_page = "About Us";
        $details = $id;
        $list = AboutUs::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'list'));
    }

    public function aboutusUpdate(Request $request, $id)
    {
        $data['content'] = $request->content;
        $response = AboutUs::where(array('id' => $id))->update($data);

        if ($response > 0) {
            return redirect()->route('aboutus-list.list')->with('success', 'About Us updated');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

}
