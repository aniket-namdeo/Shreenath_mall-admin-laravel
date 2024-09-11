<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\TermsAndCondition;
use Illuminate\Support\Str;

class TermsAndConditionController extends Controller
{

    public function show()
    {
        $page_name = 'terms_and_condition/add';
        $current_page = 'add-terms_and_condition';
        $page_title = 'Add Terms And Condition';
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function store(Request $request)
    {
        $data['content'] = $request->content;

        $response = TermsAndCondition::create($data);
        return redirect()->route('terms_and_condition-list.list')->with('success', 'Privacy policy created');

    }

    public function list()
    {
        $page_name = 'terms_and_condition/list';
        $current_page = 'List';
        $page_title = 'List';
        $list = TermsAndCondition::where(array('status' => 1))->get();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));
    }


    public function terms_and_conditionEdit(TermsAndCondition $id)
    {
        $page_name = "terms_and_condition/edit";
        $page_title = "Manage Terms and Condition";
        $current_page = "terms__and_condition";
        $details = $id;
        $list = TermsAndCondition::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        return view('backend/admin/main', compact('page_name', 'page_title', 'current_page', 'details', 'list'));
    }

    public function termsconditionUpdate(Request $request, $id)
    {
        $data['content'] = $request->content;
        $response = TermsAndCondition::where(array('id' => $id))->update($data);

        if ($response > 0) {
            return redirect()->route('terms_and_condition-list.list')->with('success', 'Privacy policy updated');
        } else {
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }

}
