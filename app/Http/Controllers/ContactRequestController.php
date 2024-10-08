<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactRquest;

class ContactRequestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $page_name = "contact-request/list";
        
        $page_title = "Manage Contact Request";
        
        $current_page = "contact-request";

        $request_list = ContactRquest::where(array('status'=>1))->orderBy('id','desc')->paginate(20);

        return view('backend/admin/main', compact('page_name','page_title','current_page','request_list'));
    }
    
    public function update_contact_status(Request $request, $id) {
       
        $data = array($request->attr_name=>$request->attr_value);

        $result = ContactRquest::where(array('id'=>$id))->update($data);
        
        if($result > 0){
            return true;
        }else{
            return false;
        }
    }
    
    
    public function update(Request $request) {
        $data = array('contact_status' =>$request->contact_status,'remark' =>$request->remark);

        $result = ContactRquest::where(array('id'=>$request->id))->update($data);
        
        if($result > 0){
            return redirect()->back()->with('success', 'Remark Status Updated successfully');
        }else{
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }
    public function destroy($id){
      
        $data = array('status' =>0);

        $result = ContactRquest::where(array('id'=>$id))->update($data);

        if($result > 0){
            return redirect()->back()->with('success', 'User Deleted successfully');
        }else{
            return redirect()->back()->with('error', 'Something went Wrong');
        }
    }
}
