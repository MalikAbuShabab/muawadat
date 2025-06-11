<?php

namespace App\Http\Controllers\Front;

use DB;
use Log;
use Auth;
use Session;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Front\FrontController;
use App\Http\Traits\ChatTrait;
use App\Http\Traits\GlobalFunction;
use Illuminate\Support\Facades\Http;


use App\Models\{Client, Order, UserVendor, ClientPreference, LoyaltyCard,OrderProductRating};

class ChatDispatcherNotificationController extends FrontController
{
    use GlobalFunction;
    use ChatTrait;
    /**
     * Display a listing of the country resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $client_data;
    public function __construct()
    {
        
      
    }

    public function sendNotificationToUserByDispatcher(Request $request){
       
        try {
            $notiFY = $this->sendNotification($request,'from_dispatcher');
            return response()->json([ 'notiFY'=>$notiFY , 'status' => true, 'message' => __('sent!!!')]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'notiFY' => [] , 'message' => __('No Data found !!!')]);
        }

    }
    public function sendNotificationToUser(Request $request){
        try {
            $notiFY = $this->sendNotification($request,'');
            return response()->json([ 'notiFY'=>$notiFY , 'status' => true, 'message' => __('sent!!!')]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'notiFY' => [] , 'message' => __('No Data found !!!')]);
        }

    }

    public function uploadChatMedia(Request $request){
       
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $folderPath = 'uploads/chat-media/';
        
            // Upload to S3 with ACL 'public-read'
            $file->storeAs($folderPath, $fileName, [
                'disk' => 's3-chat',
                'ACL' => 'public-read'
            ]);
        
            $url = Storage::disk('s3-chat')->url($folderPath . $fileName);
        
            return response()->json(['status' => true, 'url' => $url]);
        }
        
    }

}

