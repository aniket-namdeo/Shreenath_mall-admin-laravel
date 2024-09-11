<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTracking;
use App\Models\DeliveryUser;
use App\Models\Order;
use App\Models\Referrals;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ReferralListController extends Controller
{
    public function referralList()
    {
        $page_name = 'refferal_list/list';
        $current_page = 'List';
        $page_title = 'List';

        $referrals = Referrals::query()
            ->leftJoin('users as referred', 'referral.referred_id', '=', 'referred.id')
            ->leftJoin('users as referrer_user', 'referral.referrer_id', '=', 'referrer_user.id')
            ->leftJoin('delivery_user as referrer_delivery', 'referral.referrer_id', '=', 'referrer_delivery.id')
            ->select(
                'referred.name as referred_name',
                'referred.contact as referred_contact',
                'referred.wallet_balance as referred_wallet_balance',
                'referrer_user.name as referrer_name_user',
                'referrer_user.contact as referrer_contact_user',
                'referrer_user.wallet_balance as referrer_wallet_balance_user',
                'referrer_delivery.name as referrer_name_delivery',
                'referrer_delivery.contact as referrer_contact_delivery',
                'referrer_delivery.wallet_balance as referrer_wallet_balance_delivery'
            )
            ->where('referred.user_type', 'User')
            ->get();

        $formattedReferrals = $referrals->map(function ($referral) {
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
            ];
        });

        return view('backend/admin/main', compact('page_name', 'current_page', 'page_title', 'formattedReferrals'));
    }

}
