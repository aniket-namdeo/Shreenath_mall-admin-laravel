<?php

namespace App\Http\Controllers\cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContractorCashier;
use App\Models\DeliveryUser;
use App\Models\Order;
use App\Models\DeliveryTracking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContractorController extends Controller
{
    public function index()
    {
        $page_name = 'delivery-user/list';
        $current_page = 'delivery-user';
        $page_title = 'Manage Delivery User';

        $user_id = session('user_id');

        $deliveryUser = DeliveryUser::where(array('added_by'=>$user_id))->orderBy('id', 'desc')->paginate(20);
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title', 'deliveryUser'));
    }

    public function create()
    {
        $page_name = 'delivery-user/create';
        $current_page = 'delivery-user-add';
        $page_title = 'Manage Delivery User';
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title'));
    }

    public function store(Request $request){

        $validated = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_user,email',
            'contact' => 'required|string|digits:10',
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|max:10',
            'profile_image' => 'nullable|image|max:2048',
        ];

        $validator = Validator::make($request->all(), $validated);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        } else{

            try {
                $deliveryUser = new DeliveryUser($request->all());

                if ($request->hasFile('profile_image')) {
                    $fileName = time() . '.' . $request->profile_image->extension();
                    $request->profile_image->move(public_path('uploads/delivery_users'), $fileName);
                    $deliveryUser->profile_image = $fileName;
                }

                $deliveryUser->referral_code = strtoupper(Str::random(8));

                $deliveryUser->password = bcrypt($request->password);
                $deliveryUser->user_type = 'delivery_user';
                $deliveryUser->added_by = session('user_id');
                $deliveryUser->save();

                return redirect(url('cashier/cashier-delivery-user'))->with('success', 'Delivery User added successfully');

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
            }
        }
    }

    public function show($id)
    {
        $page_name = 'delivery-user/show';
        $current_page = 'delivery-user';
        $page_title = 'Manage Delivery User';

        $list = DeliveryTracking::select('delivery_tracking.*','orders.total_amount','orders.payment_status','orders.delivery_status')->where(array('delivery_user_id'=>$id))->leftJoin('orders','orders.id','delivery_tracking.order_id')->orderBy('id','desc')->paginate(20);
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title','list'));
    }

    public function edit($id)
    {
        $page_name = 'delivery-user/edit';
        $current_page = 'delivery-user';
        $page_title = 'Manage Delivery User';

        $deliveryUser = DeliveryUser::where(array('id'=>$id))->first();
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title','deliveryUser'));
    }

    public function update(Request $request, $id){

        try {

            $data = [
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
                        'incentive_type' => $request->incentive_type,
                        'incentive' => $request->incentive,
                    ];

            if(!empty($request->password)){
                $data  += array('password' => bcrypt($request->password));
            }

            $deliveryUser =  DeliveryUser::where(array('id'=>$id))->update($data);

            return redirect(url('cashier/cashier-delivery-user'))->with('success', 'Delivery User added successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }

    public function commission_list()
    {
        $page_name = 'delivery-user/order-commission';
        $current_page = 'delivery-order-commission';
        $page_title = 'Manage Delivery Orde Commission';

        $user_id = session('user_id');

        $list = Order::select('orders.*', 
                    'delivery_tracking.delivery_user_id', 
                    'delivery_user.name', 
                    'delivery_user.contact', 
                    'delivery_user.email', 
                    'delivery_user.incentive_type', 
                    'delivery_user.incentive')
                ->leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
                ->leftJoin('delivery_user', 'delivery_user.id', '=', 'delivery_tracking.delivery_user_id')
                ->where('delivery_user.added_by', $user_id)
                ->where('orders.delivery_status', 'delivered')
                ->orderBy('orders.id', 'desc')
                ->groupBy('orders.id')
                ->paginate(20);

        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title','list'));
    }

    public function our_commission_list()
    {
        $page_name = 'delivery-user/our-commission';
        $current_page = 'our-order-commission';
        $page_title = 'Manage Delivery Orde Commission';

        $user_id = session('user_id');

        $list = Order::select('orders.*', 'contractor_cashier.commission_type', 'contractor_cashier.commission')
                ->leftJoin('delivery_tracking', 'orders.id', '=', 'delivery_tracking.order_id')
                ->leftJoin('delivery_user', 'delivery_user.id', '=', 'delivery_tracking.delivery_user_id')
                ->leftJoin('contractor_cashier', 'contractor_cashier.id', '=', 'delivery_user.added_by')
                ->where('contractor_cashier.id', $user_id)
                ->where('orders.delivery_status', 'delivered')
                ->orderBy('orders.id', 'desc')
                ->groupBy('orders.id')
                ->paginate(20);
        
        return view('backend/cashier/main', compact('page_name', 'current_page', 'page_title','list'));
    }
}
