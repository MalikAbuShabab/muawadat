<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Session,Str;
use Timezonelist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\v1\BaseController;
use App\Models\{UserWishlist, User, Product, UserAddress, UserRefferal, ClientPreference, Client, Order, Transaction,UserDocs,UserRegistrationDocuments, UserVendor, UserDevice, P2pBid, P2pBidDocument };
use App\Http\Traits\{ ApiResponser };
 

class BuyerBidController extends BaseController
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
                return $this->errorResponse('User not found', 404);
            }

            // Get bid status from URL parameter
            $bidStatus = $request->query('bid_status', 'all'); // Default: 'all'

            // Fetch bids based on status
            $bidsQuery = P2pBid::with(['product.media.image', 'product.vendor'])
                ->where('buyer_id', Auth::id())
                ->where('seller_id', '!=', Auth::id());

            if ($bidStatus !== 'all') {
                if ($bidStatus === 'completed') {
                    $bidsQuery->whereIn('bid_status', ['closed', 'rejected']);
                } elseif($bidStatus === 'matched'){
                    $bidsQuery->where('bid_status', 'matched');
                }elseif($bidStatus === 'open') {
                    $bidsQuery->where('bid_status','open');
                }
            }
            
            $bids = $bidsQuery->orderByDesc('id')->get();

            $data = [
                'user' => $user,
                'bids' => $bids, // Filtered bids based on status
            ];

            return $this->successResponse($data, null, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
