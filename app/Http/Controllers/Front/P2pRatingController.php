<?php

namespace App\Http\Controllers\Front;


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
use App\Models\UserDevice;
use App\Models\P2pBid;
use App\Models\P2pBidDocument;
use App\Models\WithdrawBidContract;
use App\Models\VendorMedia;
use App\Models\ProductImage;
use App\Models\P2pBidRating;
use App\Models\{UserWishlist, User, Product, UserAddress, UserRefferal, ClientPreference, Client, Order, Transaction,UserDocs,UserRegistrationDocuments, UserVendor, EmailTemplate};


class P2pRatingController extends Controller
{
    public function store(Request $request){
        try{
            $bid = P2pBid::find($request->bid_id);
            // $rating = P2pBidRating::create([
            //     'bid_id' => $request->bid_id,
            //     'user_id' => $bid->seller_id,
            //     'rated_user_id' => $bid->buyer_id,
            //     'rating' => $request->rating,
            //     'feedback' => json_encode($request->feedback), // Assuming feedback is an array
            //     'suggestion' => $request->suggestion,
            // ]);

            $rating = P2pBidRating::updateOrCreate(
                [
                    'bid_id' => $request->bid_id, // Unique identifier for the bid
                    'user_id' => $bid->seller_id, // User giving the rating
                    'rated_user_id' => $bid->buyer_id, // User being rated
                ],
                [
                    'rating' => $request->rating, // 1-5 Star rating
                    'feedback' => json_encode($request->feedback), // Feedback options as JSON
                    'suggestion' => $request->suggestion, // Optional suggestion
                ]
            );
        
            return response()->json(['success' => true, 'message' => 'Thanks For Loving Us !']);
        }catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
