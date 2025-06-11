<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use PDF;
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
use App\Models\{UserWishlist, User, Product, UserAddress, UserRefferal, ClientPreference, Client, Order, Transaction,UserDocs,UserRegistrationDocuments, UserVendor};
use App\Notifications\buyerBidProductNotificationToseller;
use App\Models\PaymentMilestone;

class BuyerBidController extends FrontController
{
    private $folderName = 'prods';

    public function index(Request $request, $domain = ''){
        $curId = Session::get('customerCurrency');
        $langId = Session::get('customerLanguage');
        $navCategories = $this->categoryNav($langId);
        $user = User::with('country', 'address')->select('id', 'name', 'email', 'description', 'phone_number', 'dial_code', 'image', 'type', 'country_id', 'timezone')->where('id', Auth::user()->id)->first();
        $user_addresses = UserAddress::where('user_id', Auth::user()->id)->get();
        $refferal_code = UserRefferal::where('user_id', Auth::user()->id)->first();
        if(!$refferal_code){
            $userRefferal = new UserRefferal();
            $userRefferal->refferal_code = $this->randomData("user_refferals", 8, 'refferal_code');
            $userRefferal->user_id = Auth::user()->id;
            $userRefferal->save();
        }
        $timezone_list = Timezonelist::create('timezone', $user->timezone, [
            'id'    => 'timezone',
            'class' => 'styled form-control',
        ]);

        // $openBids = P2pBid::with(['product.media.image', 'product.vendor'])
        // ->where('buyer_id', Auth::user()->id)
        // ->where('seller_id', '!=', Auth::user()->id)
        // ->where(function ($query) {
        //     $query->where('bid_status', 'open');
                 
        // })
        // ->get();
        
        $openBids = P2pBid::with(['product.media.image','product.vendor'])->where('buyer_id', Auth::user()->id)->where('seller_id','!=',Auth::user()->id)->where('bid_status','open')->orderBy('id', 'DESC')->get();
        
        $matchedBid = P2pBid::with(['product.media.image', 'product.vendor', 'bidDocument', 'bidMilestones'])
        ->where('buyer_id', Auth::user()->id)
        ->where('seller_id', '!=', Auth::user()->id)
        ->where('bid_status', 'matched')
        ->orderBy('id', 'DESC')
        ->get()
        ->map(function($bid) {
            $progress = 25; // Initial progress
            $bid->matched_progress = 25;
            if ($bid->bidDocument) {
                if ($bid->bidDocument->document_path) {
                    $progress += 12.50;
                    $bid->seller_signed_progress = 12.50;
                }
                if ($bid->bidDocument->buyer_signature) {
                    $progress += 12.50;
                    $bid->buyer_signed_progress = 12.50;
                }
            }
            
            // Check payment milestone status
            $milestone = PaymentMilestone::where('bid_id', $bid->id)->first();
            if ($milestone) {
                $progress += 15; // Base progress for milestone existence
                $bid->milestone_progress = 15;
                if ($milestone->is_approved == 1) {
                    $progress += 5; // Additional progress for paid milestone
                    $bid->milestone_approve_progress = 5;
                }

                if ($milestone->is_paid == 'completed') {
                    $progress += 20; // Additional progress for paid milestone
                    $bid->milestone_payment_progress = 20;
                }
                
                if ($milestone->status == 'completed') {
                    $progress += 5; // Additional progress for completed status
                    $bid->milestone_payment_approved_progress = 5;
                }
            }
            // Add 5% progress for completed ownership transfer
            if ($bid->bid_status == 'closed' && empty($bid->withdraw_by) && $bid->confirm_ownership_transfer == 1) {
                $progress += 5;
                $bid->owner_transfer_progress = 20;
            }
            $bid->progress = $progress;
            return $bid;
        });
        // pr($matchedBid);
        // $stepsCompleted = $bid->step1 + $bid->step2 + $bid->step3 + $bid->step4 + $bid->step5;
        // $totalSteps = 5;
        // $progress = ($stepsCompleted / $totalSteps) * 100;

        // $completedBid = P2pBid::with(['product.media.image','product.vendor'])->where('buyer_id', Auth::user()->id)->where('seller_id','!=',Auth::user()->id)->where('bid_status','closed')->get();

        $completedBid = P2pBid::with(['product.media.image', 'product.vendor'])
        ->where('buyer_id', Auth::user()->id)
        ->where('seller_id', '!=', Auth::user()->id)
        ->where(function ($query) {
            $query->where('bid_status', 'closed')
                ->orWhere('bid_status', 'rejected');
        })->orderBy('id', 'DESC')->get(); 
      
         
        return view('frontend.template_nine.bid.bid_list')->with(['user' => $user, 'navCategories' => $navCategories, 'userAddresses'=>$user_addresses, 'userRefferal' => $refferal_code,'timezone_list' => $timezone_list, 'openBids' => $openBids, 'matchedbids' => $matchedBid, 'completedBids' => $completedBid]);

    }

    public function storeRaisedBidByBuyer(Request $request){
        if(!auth()->check()) {
             
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Please log in first.',
            ], 401);
        }else{
             
        }
     
        $validated = $request->validate([
            'buyer_id' => 'required', // Ensure the buyer exists
            'product_id' => 'required|exists:products,id', // Ensure the product exists
            'bid_amount' => 'required|numeric|min:1', // Bid amount must be a positive number
            'seller_id' => 'required',
        ]);
    
        try {
            $bid = P2pBid::updateOrCreate(
                [
                    'buyer_id' => $validated['buyer_id'],
                    'seller_id' => $validated['seller_id'],
                    'product_id' => $validated['product_id'],
                    'bid_status' => 'open',
                ],
                [
                    'bid_amount' => $validated['bid_amount'],
                ]
            );
             
            // Notification to seller
            $seller = User::find($validated['seller_id']);

            // Send notification to the seller (Email + Web)
            $seller->notify(new buyerBidProductNotificationToseller($bid));
    
            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Bid raised successfully.',
                'data' => $bid,
            ], 201);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to raise the bid.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    
    public function uploadBidSignaure(Request $request){
        try{
            $request->validate([
                'signature' => 'required',
            ]);
            $p2pBid = P2pBid::where('id',$request->bid_id)->first();
            \Log::info(['upload signature' => $request->all()]);


            $img = P2pBidDocument::updateOrCreate(
                ['bid_id' => $request->bid_id], // Search criteria (Check if record exists)
                [
                    'document_name' => 'signature',
                    'buyer_signature' => $request->file('signature')->store($this->folderName, 's3', 'public'),
                    'file_type' => 1,
                    'uploaded_by' => $p2pBid->seller_id,
                    'upload_buyer_id' => Auth::user()->id,
                ]
            );
            
            // Update bid status if document is saved/updated
            if ($img) {
                $bid = P2pBid::find($request->bid_id);
                if ($bid) {
                    $bid->bid_status = 'matched';
                    $bid->save();
                }
            }
            // if(!empty($img->document_path)){
                // $img = new P2pBidDocument();
                // $img->bid_id = $request->bid_id;
                // $img->document_name = 'signature';
                // $img->buyer_signature = $request->file('signature')->store($this->folderName, 's3', 'public');
                // $img->file_type = 1;
                // $img->uploaded_by = $p2pBid->seller_id;
                // $img->upload_buyer_id = Auth::user()->id;
                // $img->save();
                // if($img){
                //     $bid = P2pBid::find($request->bid_id);
                //     $bid->bid_status = 'matched'; 
                //     $bid->save();
                // }
                return response()->json(['success' => true, 'message' => 'Contract Successfully Signed!']);
            // }else{
            //     return response()->json(['success' => false, 'message' => 'Buyer Cannot Contract Sign Before Seller Contract 345!']);
            // }

             
        } catch (\Exception $e) {
            \Log::error('Error upload signature document: ' . $e->getMessage());
        }  
    }


    public function viewBuyerBidContract(Request $request){
        try{
            $user = Auth::user();
            $signatureImgs = [];
           
            // $sellerIncomingBid = P2pBid::with('bidContractSigned')->where('bid_status','matched')->where('seller_id', $user->id)->first();
            $bidDocuments = P2pBidDocument::with('bidData.product')->where('upload_buyer_id', $user->id)->orderBy('id', 'DESC')->get();
            // pr($user->id);

            if(count($bidDocuments) >0){
                foreach ($bidDocuments as $bidDocument) {
                    $img = 'default/default_image.png';
                    $buyerDocument = $bidDocument->buyer_signature ?? $img;
                    $sellerDocument = $bidDocument->document_path ?? $img;
                    
                    $signatureImg[] = [
                        'proxy_url' => \Config::get('app.IMG_URL1'),
                        'image_path' => \Config::get('app.IMG_URL2') . '/' . $buyerDocument,
                        'seller_image_path' => \Config::get('app.IMG_URL2') . '/' . $sellerDocument,
                        'image_fit' => \Config::get('app.FIT_URL'),
                        'original_image' => \Storage::disk('s3')->url($buyerDocument),
                        'original_seller_image' => \Storage::disk('s3')->url($sellerDocument),
                        'bidData' => $bidDocument->bidData,
                    ];

                    

                }
                // pr($signatureImg);
                return view('frontend.account.buyer_contract')->with(['signatureImgs' => $signatureImg]);
            }else{
                return view('frontend.account.buyer_contract');
            }
             
        } catch (\Exception $e) {
            \Log::error('Error upload signature document: ' . $e->getMessage());
        } 
    }

    public function downloadContractSign($domain, $id)
    {
         
        $data = P2pBidDocument::with('bidData.product')->where('bid_id', $id)->first();
            $img = 'default/default_image.png';
            $buyerDocument = $data->buyer_signature ?? $img;
            $sellerDocument = $data->document_path ?? $img;
            
            $signatureImg[] = [
                'proxy_url' => \Config::get('app.IMG_URL1'),
                'image_path' => \Config::get('app.IMG_URL2') . '/' . $buyerDocument,
                'seller_image_path' => \Config::get('app.IMG_URL2') . '/' . $sellerDocument,
                'image_fit' => \Config::get('app.FIT_URL'),
                'original_image' => \Storage::disk('s3')->url($buyerDocument),
                'original_seller_image' => \Storage::disk('s3')->url($sellerDocument),
                'bidData' => $data->bidData,
            ];
            $pdf = PDF::loadView('frontend/template_nine/pdf/signed_contract', compact('signatureImg')); 
            $pdf->setPaper('A4', 'portrait');

        // Download the PDF
        return $pdf->download('dsigned-contract.pdf');
    }


    public function getOngoingBidProgress($bidId)
    {
        $bid = P2pBid::find($bidId);

        // Assume each step is saved as a boolean (0 or 1) in DB
        $stepsCompleted = $bid->step1 + $bid->step2 + $bid->step3 + $bid->step4 + $bid->step5;
        $totalSteps = 5;

        $progress = ($stepsCompleted / $totalSteps) * 100;

        return response()->json(['progress' => $progress]);
    }
     
}

     
