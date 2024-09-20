<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTracking;
use App\Models\DeliveryUser;
use App\Models\Order;
use App\Models\Referrals;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ReferralListController extends Controller
{
    // public function referralList()
    // {
    //     $page_name = 'refferal_list/list';
    //     $current_page = 'List';
    //     $page_title = 'List';

    //     $referrals = Referrals::query()
    //         ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
    //         ->leftJoin('users as referrer_user', 'referral.referrer_id', '=', 'referrer_user.id')
    //         ->leftJoin('delivery_user as referrer_delivery', 'referral.referrer_id', '=', 'referrer_delivery.id')
    //         ->select(
    //             'referred.name as referred_name',
    //             'referred.contact as referred_contact',
    //             'referred.wallet_balance as referred_wallet_balance',
    //             'referrer_user.name as referrer_name_user',
    //             'referrer_user.contact as referrer_contact_user',
    //             'referrer_user.wallet_balance as referrer_wallet_balance_user',
    //             'referrer_delivery.name as referrer_name_delivery',
    //             'referrer_delivery.contact as referrer_contact_delivery',
    //             'referrer_delivery.wallet_balance as referrer_wallet_balance_delivery'
    //         )
    //         ->where('referred.user_type', 'User')
    //         ->get();

    //     $formattedReferrals = $referrals->map(function ($referral) {
    //         $referrerName = $referral->referrer_name_user ?? $referral->referrer_name_delivery;
    //         $referrerContact = $referral->referrer_contact_user ?? $referral->referrer_contact_delivery;
    //         $referrerWalletBalance = $referral->referrer_wallet_balance_user ?? $referral->referrer_wallet_balance_delivery;

    //         return [
    //             'referrer_name' => $referrerName,
    //             'referrer_contact' => $referrerContact,
    //             'referrer_wallet_balance' => $referrerWalletBalance,
    //             'referred_name' => $referral->referred_name,
    //             'referred_contact' => $referral->referred_contact,
    //             'referred_wallet_balance' => $referral->referred_wallet_balance,
    //         ];
    //     });

    //     return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'formattedReferrals'));
    // }

    public function referralListolddd()
    {
        $page_name = 'refferal_list/list';
        $current_page = 'List';
        $page_title = 'List';

        $formattedReferrals = Referrals::query()
            ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
            ->leftJoin('users as referrer_user', function ($join) {
                $join->on('referral.referrer_id', '=', 'referrer_user.id')
                    ->where('referral.referr_type', '=', 'user');
            })
            ->leftJoin('delivery_user as referrer_delivery', function ($join) {
                $join->on('referral.referrer_id', '=', 'referrer_delivery.id')
                    ->where('referral.referr_type', '=', 'marketing');
            })
            ->select(
                'referred.name as referred_name',
                'referred.contact as referred_contact',
                'referred.wallet_balance as referred_wallet_balance',
                'referrer_user.name as referrer_name_user',
                'referrer_user.contact as referrer_contact_user',
                'referrer_user.wallet_balance as referrer_wallet_balance_user',
                'referrer_delivery.name as referrer_name_delivery',
                'referrer_delivery.contact as referrer_contact_delivery',
                'referrer_delivery.wallet_balance as referrer_wallet_balance_delivery',
                'referral.referr_type',
                'referral.status as  referral_status',
                'referral.id as referral_id'
            )
            ->groupBy('referrer_name_user')
            ->get();

        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'formattedReferrals'));


    }

    public function referralListnew()
    {
        $page_name = 'refferal_list/list';
        $current_page = 'List';
        $page_title = 'List';

        $formattedReferrals = Referrals::query()
            ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
            ->leftJoin('users as referrer_user', function ($join) {
                $join->on('referral.referrer_id', '=', 'referrer_user.id')
                    ->where('referral.referr_type', '=', 'user');
            })
            ->leftJoin('delivery_user as referrer_delivery', function ($join) {
                $join->on('referral.referrer_id', '=', 'referrer_delivery.id')
                    ->where('referral.referr_type', '=', 'marketing');
            })
            ->select(
                'referred.name as referred_name',
                'referred.contact as referred_contact',
                'referred.wallet_balance as referred_wallet_balance',
                'referrer_user.name as referrer_name_user',
                'referrer_user.contact as referrer_contact_user',
                'referrer_user.wallet_balance as referrer_wallet_balance_user',
                'referrer_delivery.name as referrer_name_delivery',
                'referrer_delivery.contact as referrer_contact_delivery',
                'referrer_delivery.wallet_balance as referrer_wallet_balance_delivery',
                'referral.referr_type',
                'referral.status as referral_status',
                'referral.id as referral_id'
            )
            ->groupBy('referrer_name_delivery')
            ->get();

        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'formattedReferrals'));

    }

    public function referralListnewold()
    {
        $page_name = 'refferal_list/list';
        $current_page = 'List';
        $page_title = 'List';
        $formattedReferrals = Referrals::query()
            ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
            ->leftJoin('users as referrer_user', function ($join) {
                $join->on('referral.referrer_id', '=', 'referrer_user.id')
                    ->where('referral.referr_type', '=', 'user');
            })
            ->leftJoin('delivery_user as referrer_delivery', function ($join) {
                $join->on('referral.referrer_id', '=', 'referrer_delivery.id')
                    ->where('referral.referr_type', '=', 'marketing');
            })
            ->select(
                'referred.name as referred_name',
                'referred.contact as referred_contact',
                'referred.wallet_balance as referred_wallet_balance',
                'referrer_user.name as referrer_name_user',
                'referrer_user.contact as referrer_contact_user',
                'referrer_user.wallet_balance as referrer_wallet_balance_user',
                'referrer_delivery.name as referrer_name_delivery',
                'referrer_delivery.contact as referrer_contact_delivery',
                'referrer_delivery.wallet_balance as referrer_wallet_balance_delivery',
                'referral.referr_type',
                'referral.status as referral_status',
                'referral.id as referral_id'
            )
            ->groupBy('referred.name')
            ->get();
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'formattedReferrals'));
    }






    public function referralListold()
    {
        $page_name = 'refferal_list/list';
        $current_page = 'List';
        $page_title = 'List';

        $referrals = Referrals::query()
            ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
            ->leftJoin('users as referrer_user', function ($join) {
                $join->on('referral.referrer_id', '=', 'referrer_user.id')
                    ->where('referral.referr_type', '=', 'user');
            })
            ->leftJoin('delivery_user as referrer_delivery', function ($join) {
                $join->on('referral.referrer_id', '=', 'referrer_delivery.id')
                    ->where('referral.referr_type', '=', 'marketing');
            })
            ->select(
                'referred.name as referred_name',
                'referred.contact as referred_contact',
                'referred.wallet_balance as referred_wallet_balance',
                'referrer_user.name as referrer_name_user',
                'referrer_user.contact as referrer_contact_user',
                'referrer_user.wallet_balance as referrer_wallet_balance_user',
                'referrer_delivery.name as referrer_name_delivery',
                'referrer_delivery.contact as referrer_contact_delivery',
                'referrer_delivery.wallet_balance as referrer_wallet_balance_delivery',
                'referral.referr_type',
                'referral.status as  referral_status',
                'referral.id as referral_id'
            )
            ->where('referred.user_type', 'User')
            ->get();

        $formattedReferrals = $referrals->map(function ($referral) {
            // Choose the appropriate referrer data based on which is available
            $referrerName = $referral->referrer_name_user ?? $referral->referrer_name_delivery;
            $referrerContact = $referral->referrer_contact_user ?? $referral->referrer_contact_delivery;
            $referrerWalletBalance = $referral->referrer_wallet_balance_user ?? $referral->referrer_wallet_balance_delivery;

            return [
                'referrer_name' => $referrerName,
                'referrer_contact' => $referrerContact,
                'referrer_wallet_balance' => $referrerWalletBalance,
                'referred_name' => $referral->referred_name,
                'referred_contact' => $referral->referred_contact,
                'referred_wallet_balance' => $referral->referred_wallet_balance,
                'referr_type' => $referral->referr_type,
                'referral_status' => $referral->referral_status,
                'referral_id' => $referral->referral_id
            ];
        });

        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'formattedReferrals'));
    }


    public function referralList()
    {
        $page_name = 'refferal_list/referral_list';
        $current_page = 'List';
        $page_title = 'List';
        $formattedReferrals = Referrals::
            leftJoin('users', function ($join) {
                $join->on('referral.referrer_id', '=', 'users.id')
                    ->where('referral.referr_type', '=', 'user');
            })
            ->leftJoin('delivery_user', function ($join) {
                $join->on('referral.referrer_id', '=', 'delivery_user.id')
                    ->where('referral.referr_type', '=', 'marketing');
            })
            ->select(
                'referral.*',
                'users.name as referrer_user_name',
                'delivery_user.name as referrer_employee_name',
                DB::raw('COUNT(referral.id) as referral_count')
            )
            ->groupBy(
                'referral.referrer_id',
                'users.name',
                'delivery_user.name'
            )
            ->get();


        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'formattedReferrals'));
    }

    public function referralListByIdcasc(Request $request)
    {
        $page_name = 'refferal_list/view_referral_list';
        $current_page = 'List';
        $page_title = 'List';

        if ($request->referr_type == 'user') {
            $referrals = Referrals::where('referral.referrer_id', $request->referrerId)
                ->leftJoin('users', 'users.id', '=', 'referral.referred_id')
                ->leftJoin('users as referr_by', 'referr_by.id', '=', 'referral.referrer_id')
                ->select(
                    'referral.*',
                    'users.name as user_name',
                    'users.contact as user_contact',
                    'referr_by.name as referred_by_name',
                    'referr_by.contact as referred_by_contact'
                )
                ->get();
        } else if ($request->referr_type == 'marketing') {
            $referrals = Referrals::where('referral.referrer_id', $request->referrerId)
                ->leftJoin('users', 'users.id', '=', 'referral.referred_id')
                ->leftJoin('delivery_user as referr_by', 'referr_by.id', '=', 'referral.referrer_id')
                ->select(
                    'referral.*',
                    'users.name as user_name',
                    'users.contact as user_contact',
                    'referr_by.name as referred_by_name',
                    'referr_by.contact as referred_by_contact'
                )
                ->get();
        }

        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'referrals'));
    }

    public function referralListById(Request $request)
    {
        $page_name = 'refferal_list/view_referral_list';
        $current_page = 'List';
        $page_title = 'List';
    
        $referralsQuery = Referrals::query()
            ->where('referral.referrer_id', $request->referrerId)
            ->leftJoin('users', 'users.id', '=', 'referral.referred_id');
    
        if ($request->referr_type == 'user') {
            $referrals = $referralsQuery
                ->leftJoin('users as referr_user_by', 'referr_user_by.id', '=', 'referral.referrer_id')
                ->select(
                    'referral.*',
                    'users.name as user_name',
                    'users.contact as user_contact',
                    'referr_user_by.name as referred_by_name',
                    'referr_user_by.contact as referred_by_contact'
                )
                ->get();
        } elseif ($request->referr_type == 'marketing') {
            $referrals = $referralsQuery
                ->leftJoin('delivery_user as referr_marketing_by', 'referr_marketing_by.id', '=', 'referral.referrer_id')
                ->select(
                    'referral.*',
                    'users.name as user_name',
                    'users.contact as user_contact',
                    'referr_marketing_by.name as referred_by_name',
                    'referr_marketing_by.contact as referred_by_contact'
                )
                ->get();
        }
    
        $pendingCount = Referrals::query()
            ->where('referrer_id', $request->referrerId)
            ->where('status', 'pending')
            ->count();
    
        $redeemedCount = Referrals::query()
            ->where('referrer_id', $request->referrerId)
            ->where('status', 'redeemed')
            ->count();
    
        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'referrals', 'pendingCount', 'redeemedCount'));
    }
    


    public function updateReferralStatus(Request $request)
    {
        $referral = Referrals::where('id', $request->id)->first();
        $referral->status = $request->referral_status;
        $referral->save();



        return redirect()->back()->with('success', 'Referral status updated successfully!');
    }

}
