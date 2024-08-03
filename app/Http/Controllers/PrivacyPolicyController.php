<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Str;

class PrivacyPolicyController extends Controller
{

    public function show()
    {
        $page_name = 'privacypolicy/add';
        $current_page = 'add-privacypolicy';
        $page_title = 'Add Privacy Policy';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function store(Request $request)
    {
        $data['content'] = $request->content;

        $response = PrivacyPolicy::create($data);
        return redirect('/admin/dashboard')->with('success', 'Privacy policy created');
    }

    public function list()
    {
        $page_name = 'privacypolicy/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = PrivacyPolicy::where(array('status' => 1))->get();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }


    public function privacypolicyEdit(PrivacyPolicy $id)
    {
        $page_name = "privacypolicy/edit";
        $page_title = "Manage privacypolicy";
        $current_page = "Privacy policy";
        $details = $id;
        $list = PrivacyPolicy::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'list'));
    }

    public function privacypolicyUpdate(Request $request, $id)
    {
        $data['content'] = $request->content;
        $response = PrivacyPolicy::where(array('id' => $id))->update($data);

        if ($response > 0) {
            return redirect()->route('privacypolicy-list.list')->with('success', 'Privacy policy updated');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

}
