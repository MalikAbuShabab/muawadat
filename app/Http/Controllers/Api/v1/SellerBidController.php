<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session,Str;
use Timezonelist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Front\FrontController;
use App\Models\{UserWishlist, User, Product, UserAddress, UserRefferal, ClientPreference, Client, Order, Transaction,UserDocs,UserRegistrationDocuments, UserVendor, UserDevice, EmailTemplate, P2pBid, P2pBidDocument, WithdrawBidContract, VendorMedia, ProductImage };
use App\Http\Traits\{ ApiResponser };
class SellerBidController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        try {
            $user = User::with('country', 'address')
                ->select('id', 'name', 'email', 'description', 'phone_number', 'dial_code', 'image', 'type', 'country_id', 'timezone')
                ->where('id', Auth::id())
                ->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // ✅ Fetch user addresses
            $user_addresses = UserAddress::where('user_id', $user->id)->get();

            // ✅ Check if user has a referral code
            $refferal_code = UserRefferal::where('user_id', $user->id)->first();
            if (!$refferal_code) {
                $userRefferal = new UserRefferal();
                $userRefferal->refferal_code = $this->randomData("user_refferals", 8, 'refferal_code');
                $userRefferal->user_id = $user->id;
                $userRefferal->save();
                $refferal_code = $userRefferal;
            }

            // ✅ Get status from URL parameter (default to 'all')
            $bidStatus = $request->query('bid_status', 'all');

            // ✅ Initialize query
            $bidsQuery = P2pBid::with(['product.media.image', 'product.vendor', 'seller', 'buyer'])
                ->where('seller_id', $user->id)
                ->whereNotIn('buyer_id', [$user->id]);

            // ✅ Apply status filter
            if ($bidStatus !== 'all') {
                if ($bidStatus === 'completed') {
                    $bidsQuery->whereIn('bid_status', ['closed', 'rejected']);
                } elseif ($bidStatus === 'matched') {
                    $bidsQuery->where('bid_status', 'matched');
                } elseif ($bidStatus === 'open') {
                    $bidsQuery->where('bid_status', 'open');
                }
            }

            $bids = $bidsQuery->orderByDesc('id')->get();

            // ✅ Get Timezone List
            $timezone_list = Timezonelist::create('timezone', $user->timezone, [
                'id'    => 'timezone',
                'class' => 'styled form-control',
            ]);

            // ✅ Return API Response
            $data = [
                'user' => $user,
                'bids' => $bids,
            ];

            return $this->successResponse($data, null, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }


    


}
