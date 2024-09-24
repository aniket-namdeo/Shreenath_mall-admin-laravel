<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractorCashier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContractorCashierController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    
        $this->rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:contractor_cashier',
            'contact' => 'required|min:10|max:10',
            'password' => 'required|min:5',
            'user_type' => 'required',
            'commission_type' => 'required',
            'commission' => 'required',
        ];
    }

    public function index(){
        
        $page_name = 'contractor-cashier/list';
        
        $current_page = 'contractor-cashier';
        
        $page_title = 'List Of Contractors & Cashier';
        
        $list = ContractorCashier::where(array('status' => 1))->orderBy('id', 'desc')->paginate(20);
        
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'list'));

    }
    
    public function create(){
        
        $page_name = 'contractor-cashier/create';
        
        $current_page = 'contractor-cashier';
        
        $page_title = 'Add Contractors & Cashier';
        
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title'));
    }
    
    public function store(Request $request){
        
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        } else{

            $data = $request->all();
            
            if(!empty($request->aadhar_image)){
                
                $imageName = time().'-aadhar.'.$request->aadhar_image->extension();
                
                $request->aadhar_image->move(public_path('uploads/contractor-cashier'), $imageName);    
                
                $full_path = "uploads/contractor-cashier/".$imageName;                

                $data['aadhar_image'] = $full_path;

            }
            
            if(!empty($request->pan_image)){
                
                $imageName = time().'-pan.'.$request->pan_image->extension();
                
                $request->pan_image->move(public_path('uploads/contractor-cashier'), $imageName);    
                
                $full_path = "uploads/contractor-cashier/".$imageName;                

                $data['pan_image'] = $full_path;

            }

            $result = ContractorCashier::create($data);

            if($result->id > 0){
                return redirect()->back()->with('success', 'Contractor Cashier Added successfully');
            }else{
                return redirect()->back()->with('error', 'Something went Wrong');
            }
        }
    }

    
    
    public function edit($id){
        
        $page_name = 'contractor-cashier/edit';
        
        $current_page = 'contractor-cashier';
        
        $page_title = 'Update Contractors & Cashier';
        
        $details = ContractorCashier::where(array('status' => 1,'id'=>$id))->first();
        
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'details'));
    }

    
    public function update(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'email' => [
                    'required',
                    Rule::unique('contractor_cashier')->ignore($id),
                ],
                'contact' => 'required|min:10|max:10',
                'password' => 'required|min:5',
                'user_type' => 'required',
                'commission_type' => 'required',
                'commission' => 'required',
            ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        } else{

            $data = array('name'=>$request->name,'email'=>$request->email,'contact'=>$request->contact,'password'=>$request->password,'user_type'=>$request->user_type,'commission_type'=>$request->commission_type,'commission'=>$request->commission,'aadhar_card'=>$request->aadhar_card,'pancard'=>$request->pancard,'account_number'=>$request->account_number,'account_type'=>$request->account_type,'bank_name'=>$request->bank_name,'bank_ifsc'=>$request->bank_ifsc);
            
            if(!empty($request->aadhar_image)){
                
                $imageName = time().'-aadhar.'.$request->aadhar_image->extension();
                
                $request->aadhar_image->move(public_path('uploads/contractor-cashier'), $imageName);    
                
                $full_path = "uploads/contractor-cashier/".$imageName;                

                $data['aadhar_image'] = $full_path;

            }
            
            if(!empty($request->pan_image)){
                
                $imageName = time().'-pan.'.$request->pan_image->extension();
                
                $request->pan_image->move(public_path('uploads/contractor-cashier'), $imageName);    
                
                $full_path = "uploads/contractor-cashier/".$imageName;                

                $data['pan_image'] = $full_path;

            }

            $result = ContractorCashier::where(array('id'=>$id))->update($data);

            if($result > 0){
                return redirect()->back()->with('success', 'Contractor Cashier Updated successfully');
            }else{
                return redirect()->back()->with('error', 'Something went Wrong');
            }
        }
    }

    
    
    public function destroy($id){
        
        $data = array('status'=>0);
        
        $result = ContractorCashier::where(array('id'=>$id))->update($data);

        if($result > 0){

            return redirect()->back()->with('success', 'Contractor Cashier Deleted successfully');
        
        }else{
        
            return redirect()->back()->with('error', 'Something went Wrong');
        
        }
    }
}
