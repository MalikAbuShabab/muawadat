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
use App\Models\{UserWishlist, User, Product, UserAddress, UserRefferal, ClientPreference, Client, Order, Transaction,UserDocs,UserRegistrationDocuments, UserVendor, EmailTemplate};
use App\Notifications\NewBidStatusNotification;
use App\Notifications\ownerShipTransferNotification;
class SellerBidController extends FrontController
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

        $openMarketPlace = P2pBid::with(['product.media.image','product.vendor','seller','buyer'])->where('seller_id', Auth::user()->id)->whereNotIn('buyer_id', [Auth::user()->id])->where(function ($query) {
            $query->where('bid_status', 'open');
        })->orderBy('id', 'DESC')->get();
       
        $matchedMarketPlace = P2pBid::with(['product.media.image','product.vendor','seller','buyer'])->where('seller_id', Auth::user()->id)->whereNotIn('buyer_id', [Auth::user()->id])->where('bid_status','matched')->orderBy('id', 'DESC')->get();

        // $closedMarketPlace = P2pBid::with(['product.media.image','product.vendor'])->where('seller_id', Auth::user()->id)->whereNotIn('buyer_id', [Auth::user()->id])->where('bid_status','closed')->get();

        
        $closedMarketPlace = P2pBid::with(['product.media.image', 'product.vendor','seller','buyer'])
        ->where('seller_id', Auth::user()->id)
        ->where('buyer_id', '!=', Auth::user()->id)
        ->where(function ($query) {
            $query->where('bid_status', 'closed')
                ->orWhere('bid_status', 'rejected');
        })->orderBy('id', 'DESC')->get();


        // $myMarketPlace = P2pBid::with(['product.media.image','product.vendor'])->where('seller_id', Auth::user()->id)->whereNotIn('buyer_id', [Auth::user()->id])->get();
       
        $timezone_list = Timezonelist::create('timezone', $user->timezone, [
            'id'    => 'timezone',
            'class' => 'styled form-control',
        ]);
        // pr($matchedMarketPlace);
        return view('frontend.template_nine.marketplace.list')->with(['user' => $user, 'navCategories' => $navCategories, 'userAddresses'=>$user_addresses, 'userRefferal' => $refferal_code,'timezone_list' => $timezone_list, 'openMarketPlace'=> $openMarketPlace,'matchedMarketPlace'=> $matchedMarketPlace, 'closedMarketPlace'=> $closedMarketPlace ,'bid_type' => 'incoming']);
    }


    public function updateBidStatus(Request $request){
        // \Log::info('updateBidStatus');
        // \Log::info($request->all());
        $request->validate([
            'bid_id' => 'required',
        ]);
        if($request->bid_status == 'accept'){
            $bid_status = 'matched';
            $matchDate = now();
        }else{
            $bid_status = 'rejected';
            $matchDate = null;
        }
        // $bid_status = 'Rejected';
        // $matchDate = now();
        try {
            $bid = P2pBid::find($request->bid_id);
            $bid->bid_status = $bid_status;
            // $bid_status = 'rejected';
            $bid->match_date = $matchDate;
            $bid->save();
            $bidData= P2pBid::with(['product.media.image','product.vendor','product.translation','seller','buyer'])->where('id',$bid->id)->get();
            $buyer = User::where('id', $bid->buyer_id)->first();   
            $buyer->notify(new NewBidStatusNotification($bid));

            return response()->json([
                'success' => true,
                'message' => 'Bid '.$bid_status.' Successfully.',
                'data' => $bid,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to raise the bid.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function uploadSignature(Request $request){
          \Log::info('uploadSignature');
        try{
            $p2pBid = P2pBid::where('id',$request->bid_id)->first();
            \Log::info(['request all' => $request->all()]);
            $img = P2pBidDocument::updateOrCreate(
                ['bid_id' => $request->bid_id], // Search criteria (Check if record exists)
                [
                    'document_name' => 'signature',
                    'document_path' => $request->file('signature')->store($this->folderName, 's3', 'public'),
                    'file_type' => 1,
                    'uploaded_by' => Auth::user()->id,
                    // 'upload_buyer_id' => $p2pBid->buyer_id,
                ]
            );
            // $img = new P2pBidDocument();
            // $img->bid_id = $request->bid_id;
            // $img->document_name = 'signature';
            // $img->document_path = $request->file('signature')->store($this->folderName, 's3', 'public');
            // $img->file_type = 1;
            // $img->uploaded_by = Auth::user()->id;
            // $img->save();
            // if($img){
            //     $bid = P2pBid::find($request->bid_id);
            //     $bid->bid_status = 'matched'; 
            //     $bid->save();
            // }

            return response()->json(['success' => true, 'message' => 'Contract Successfully Signed!','fileName' => $request->all()]);
        } catch (\Exception $e) {
            \Log::error('Error upload signature document: ' . $e->getMessage());
        }  
    }

    public function viewBidContract(Request $request){
        try{
            $user = Auth::user();
            $signatureImgs = [];
           
            // $sellerIncomingBid = P2pBid::with('bidContractSigned')->where('bid_status','matched')->where('seller_id', $user->id)->first();
            $bidDocuments = P2pBidDocument::with('bidData.product')->where('uploaded_by',$user->id)->orderBy('id', 'DESC')->get();
            // pr($user->id);
            //  pr($bidDocuments);
            if(count($bidDocuments) >0){
                foreach ($bidDocuments as $bidDocument) {
                    $img = 'default/default_image.png';
                    $buyerDocument = $bidDocument->buyer_signature ?? $img;
                    $sellerDocument = $bidDocument->document_path ?? $img;
                    // pr($bidDocument->bidData->product);
                    $signatureImg[] = [
                        'proxy_url' => \Config::get('app.IMG_URL1'),
                        'image_path' => \Config::get('app.IMG_URL2') . '/' . $sellerDocument,
                        'buyer_image_path' => \Config::get('app.IMG_URL2') . '/' . $buyerDocument,
                        'image_fit' => \Config::get('app.FIT_URL'),
                        'original_image' => \Storage::disk('s3')->url($sellerDocument),
                        'original_buyer_image' => \Storage::disk('s3')->url($buyerDocument),
                        'bidData' => $bidDocument->bidData,
                    ];

                }
                
                return view('frontend.account.seller_contract')->with(['signatureImgs' => $signatureImg]);
            }else{
                return view('frontend.account.seller_contract');
            }
             
        } catch (\Exception $e) {
            \Log::error('Error upload signature document: ' . $e->getMessage());
        } 
    }


    public function requestRaisedBid(Request $request){ // Rejected bid by seller
        try{
            $bid = P2pBid::find($request->bid_id);
            $bid->seller_reason = $request->reason;
            // $bid->bid_status = ($request->action_status == 1) ? 'open' : (($request->action_status == 2) ? 'rejected' : 'open');
            $bid->bid_status = 'rejected';
            $bid->is_raised = $request->action_status;
            $bid->save();
            $bidData= P2pBid::with(['product.media.image','product.vendor','product.translation','seller','buyer'])->where('id',$bid->id)->get();
            $buyer = User::where('id', $bid->buyer_id)->first();   
            $buyer->notify(new NewBidStatusNotification($bid));
            return response()->json(['success' => true, 'message' => 'Bid Rejected Successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error bid update by seller: ' . $e->getMessage());
        }  
    }


    public function postContractWithdrawOtp(Request $request, $domain = '', $onlyOtp=false){
        try {
            $request->validate([
                'email' => 'required|email|exists:users',
            ],['email.required' => __('The email field is required.'),'email.exists' => __('You are not registered with us. Please sign up.')]);
            $client = Client::select('id', 'name', 'email', 'phone_number', 'logo')->where('id', '>', 0)->first();
            $user = Auth::user();
            $otp = rand(1000, 9999);
            $sendto =$request->email;
            $user->email_token = $otp;
            $user->save();

            $data = ClientPreference::select('mail_type', 'mail_driver', 'mail_host', 'mail_port', 'mail_username', 'sms_provider', 'mail_password', 'mail_encryption', 'mail_from')->where('id', '>', 0)->first();
            if (!empty($data->mail_driver) && !empty($data->mail_host) && !empty($data->mail_port) && !empty($data->mail_port) && !empty($data->mail_password) && !empty($data->mail_encryption)) {
                $confirured = $this->setMailDetail($data->mail_driver, $data->mail_host, $data->mail_port, $data->mail_username, $data->mail_password, $data->mail_encryption);
                $token = Str::random(60);
                // dd(url('/reset-password/'.$token));
                $client_name = $client->name;
                $mail_from = $data->mail_from;
                // DB::table('password_resets')->insert(['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]);
                $email_template_content = '';

                
                $email_template = EmailTemplate::where('id', 13)->first();
                $email_template_content = $email_template->content;
                $email_template_content = str_ireplace("{reset_link}", url('/reset-password/'.$token), $email_template_content);
                $data = [
                    'token' => $token,
                    'mail_from' => $mail_from,
                    'email' => $request->email,
                    'client_name' => $client_name,
                    'logo' => $client->logo['original'],
                    'subject' => $email_template->subject,
                    'email_template_content' => $email_template_content,
                ];
                dispatch(new \App\Jobs\SendEmailOtpToContractWithdraw($data))->onQueue('contract_withdraw_email_otp');
                
            }
            return $this->successResponse([],__('We have e-mailed your password reset link!'));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
            
    }


    public function storeWithdrawReason(Request $request){

        try{
            $withDraw = new WithdrawBidContract();
            $withDraw->bid_id = $request->bid_id;
            $withDraw->withdraw_by =  $request->withdraw_by;
            $withDraw->reason = $request->withdraw_reason;
            $withDraw->withdrawn_at = now();
            $withDraw->save();
            if($withDraw){
                $bid = P2pBid::find($request->bid_id);
                $bid->withdraw_reason = $request->withdraw_reason; 
                $bid->withdraw_by = $request->withdraw_by; 
                $bid->bid_status = 'closed';
                $bid->save();
            }

            return response()->json(['success' => true, 'message' => 'Withdraw Reason Successfully Submit!']);
        }catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }


    public function ownerShipTransferConfirmed(Request $request){
        try{
            $bid = P2pBid::find($request->bid_id);
            $bid->confirm_term_condition = 1;
            $bid->confirm_processed_payment = 1;
            $bid->confirm_ownership_transfer = 1;
            $bid->bid_status = 'closed';
            $bid->save();
            // SEND NOTIFICTATION TO BUYER TO COMPLETE OWNERSHIP TRANSFER
            $buyerNotify = User::find($bid->buyer_id);
            $buyerNotify->notify(new ownerShipTransferNotification($bid));
            return response()->json(['success' => true, 'message' => 'Ownership Transferred Successfully!']);
        }catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    public function getSellerBidCount()
    {
        $sellerId = auth()->id();
        $bidCount = P2pBid::where('seller_id', $sellerId)
                                    ->where('is_viewed', false)
                                    ->count();
        return response()->json(['bid_count' => $bidCount]);
    }

    public function markBidsAsViewed()
    {
        $sellerId = auth()->id();
        P2pBid::where('seller_id', $sellerId)
                        ->where('is_viewed', false)
                        ->update(['is_viewed' => true]);
        return response()->json(['message' => 'Bids marked as viewed']);
    }
     
 

}
