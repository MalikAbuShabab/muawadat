<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BidController;
use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\ToasterResponser;
use App\Http\Controllers\Client\{BaseController};
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\HomeController;
use App\Models\{Bid, BidProduct, BidRequest, UserVendor, Vendor, P2pBid};
use App\Http\Traits\{ApiResponser,BiddingCartTrait};
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class VendorBidController extends BaseController{
    use ApiResponser,BiddingCartTrait;
    use ToasterResponser;

    public function __construct(){
        
    }

    public function bidList(Request $request){
        try{
            return view('backend/bidding_module/list');
        }catch(\Exception $e){

        }
    }

    public function updateStatus(Request $request)
    {
        $bid = P2pBid::find($request->bid_id);
        if ($bid) {
            $bid->bid_status = $request->status;
            $bid->save();
            return response()->json(['success' => 'Status updated successfully!']);
        }
        return response()->json(['error' => 'Bid not found'], 404);
    }
    
    public function fetchList(Request $request){
        try{
          
            if ($request->ajax()) {
                $p2pbid = P2pBid::with(['seller', 'buyer'])
                    ->join('products', 'p2p_bids.product_id', '=', 'products.id')
                    ->select('p2p_bids.*', 'products.title as company_name');
                
                if ($request->has('order')) {
                    $columns = ['p2p_bids.id', 'products.title', 'p2p_bids.bid_status', 'p2p_bids.created_at']; // Allowed sortable columns
                    $orderColumn = $columns[$request->order[0]['column'] - 1] ?? 'id';
                    $orderDir = $request->order[0]['dir'] ?? 'desc';
                    $p2pbid->orderBy($orderColumn, $orderDir); 
                } 
                return DataTables::of($p2pbid)
                    ->addColumn('id', function ($bid) {
                        return $bid->id ? '#000'.$bid->id : 'N/A';
                    })
                    ->addColumn('seller_name', function ($bid) {
                        return $bid->seller ? $bid->seller->name : 'N/A';
                    })
                    ->addColumn('buyer_name', function ($bid) {
                        return $bid->buyer ? $bid->buyer->name : 'N/A';
                    })
                    ->addColumn('company_name', function ($bid) {
                        return $bid->product->title ? $bid->product->title : 'N/A';
                    })
                    ->addColumn('bid_amount', function ($bid) {
                        return $bid->bid_amount ? $bid->bid_amount : '0.00';
                    })
                    ->addColumn('action', function ($bid) {
                        return "<a href='#' data-id='{$bid->product_id}' class='btn btn-sm btn-primary view-btn'>View</a>";
                    })
                    ->addColumn('bid_status', function ($bid) {
                        return $bid->bid_status ? $bid->bid_status : 'N/A';
                    })
                    ->addColumn('match_date', function ($bid) {
                        return $bid->match_date ? Carbon::parse($bid->match_date)->format('F j, Y') : 'N/A';
                    })
                    ->addColumn('status', function ($bid) {
                        $statuses = ['open', 'matched', 'closed','rejected'];
                        $options = "";
                        foreach ($statuses as $status) {
                            $selected = $bid->bid_status == $status ? 'selected' : '';
                            $options .= "<option value='$status' $selected>$status</option>";
                        }
                        return "<select class='status-dropdown' data-id='{$bid->id}'>$options</select>";
                    })
                    ->filter(function ($query) use ($request) {
                        if ($request->has('search') && $request->search['value']) {
                            $searchValue = $request->search['value'];
                            $query->where(function ($q) use ($searchValue) {
                                // $q->where('id', 'LIKE', "%{$searchValue}%")
                                $q->where('bid_amount', 'LIKE', "%{$searchValue}%")
                                  ->orWhereHas('seller', function ($q) use ($searchValue) {
                                      $q->where('name', 'LIKE', "%{$searchValue}%");
                                  })
                                  ->orWhereHas('buyer', function ($q) use ($searchValue) {
                                      $q->where('name', 'LIKE', "%{$searchValue}%");
                                  })
                                  ->orWhereHas('product', function ($q) use ($searchValue) {
                                    $q->where('title', 'LIKE', "%{$searchValue}%");
                                 });
                            });
                        }
                    })
                     
                    ->rawColumns(['seller_name', 'buyer_name', 'action', 'status'])
                    ->toJson();
            }
            return response()->json(['error' => 'Unauthorized'], 403);
             
        }catch(\Exception $e){
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }  




    public function bidRequests(Request $request,$domain = '',$id = null)
    {
        $prescriptions = BidRequest::withCount(['bid'=>function($q) use ($id)
        {
            $q->where('vendor_id',$id);
        }])->where('status' , '=' , 0)->orderBy('id','desc')->get();
        return view('backend.bidding_module.vendorBidRequests', compact('prescriptions','id'));
    }

    public function storeBidRequests(Request $request)
    {
        
    try{
            $vendors = Vendor::where('status','1');
            if (Auth::user()->is_superadmin == 0) {
                $vendors = $vendors->whereHas('permissionToUser', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            }
            $prod_vendor =  $vendors->first();

            if(!$prod_vendor){
                    // Session::flash('error', 'Somthing went wrong!');
                    // return $this->successResponse(__('Somthing went wrong!'),'400');
                    return redirect()->back()->with('error','Somthing went wrong!');
            }
            $vendor_id = $prod_vendor->id;
            
            $products    = json_decode($request->data,true);
            $discount = $products[0]['discount'];
            $vendor_id = $products[0]['vendor_id'];
            $prescription_id = $products[0]['prescription_id'];

            if($products){
                $total = 0;
                foreach ($products as $key => $bidTotal) {
                    $total += $bidTotal['qty'] * $bidTotal['price'];
                }
                $amountPayable = $total - ($total * ($discount/ 100));
                $data = [
                    'bid_req_id' => (int) $prescription_id,
                    'vendor_id'    => $vendor_id,
                    'discount'     => $discount,
                    'bid_total'    => $total,
                    'final_amount' => $amountPayable,
                    'bid_order_number'=> time()
                ];

                $vendor_bids = Bid::create($data);
                $total = 0;
                foreach ($products as $key => $data) {
                    $total = $data['qty'] * $data['price'];
                $bids = BidProduct::create([
                    'bid_id'       =>  $vendor_bids->id,
                    'product_id'   =>  $data['id'],
                    'quantity'     =>  $data['qty'],
                    'price'        =>  $data['price'],
                    'total'        =>  $total,
                    ]);
                }

            }
            $bidUserId = BidRequest::where('id' ,$prescription_id)->first();
            $sendNoti = New BidController();
            $sendNoti->sendBidPushNotificationUser($bidUserId->user_id);

            Session()->flash('success', 'Bid Placed Successfully');
            return ['status'=>1];
        }catch(\Exception $e)
        {
            Session()->flash('error', $e->getMessage());
            return ['status'=>0];
        }
    //    return redirect()->back()->with('success','Bid Placed Successfully');
    }


    public function search(Request $request)
    {
        $response = [];
        $keyword = $request->input('keyword');
        $vendorId[] = $request->input('vendor_id');
        $language_id = Session()->get('customerLanguage')??1;
        // $area = new FrontController();
        // $allowed_vendors = $area->getServiceAreaVendors();
        $response  = $this->searchProduct($language_id,$keyword,$vendorId);
        return $this->successResponse($response);
    }

}
