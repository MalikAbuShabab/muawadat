<?php

namespace App\Http\Controllers\Client;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Client\BaseController;

use App\Models\{Product, ClientCurrency, ClientPreference, LoyaltyCard,OrderProductRating,OrderDriverRating, Vendor};
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReviewController extends BaseController
{
    /**
     * Display a listing of the country resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){


        $product = Product::whereHas('reviews')->withCount('reviews')->with('translation_one','media.image');
        if (Auth::user()->is_superadmin == 0) {
            $product = $product->whereHas('vendor.permissionToUser', function ($query) {
                $query->where('user_id', Auth::user()->id);
            });
        }

        $products = Product::join('p2p_bids', 'products.id', '=', 'p2p_bids.product_id')
        ->join('p2p_bid_ratings', 'p2p_bids.id', '=', 'p2p_bid_ratings.bid_id')
        ->join('users as buyers', 'p2p_bids.buyer_id', '=', 'buyers.id')  // Join for buyer
        ->join('users as sellers', 'p2p_bids.seller_id', '=', 'sellers.id') // Join for seller
        ->select(
            'products.title',
            'products.vendor_id',
            'buyers.name as buyer_name',
            'sellers.name as seller_name',
            'p2p_bid_ratings.rating as rating',
        )
        ->distinct()
        ->get();
        // pr($products);

       
        if ($request->ajax()) {
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('id', function ($row) {

                    return $row->title;
                })
                ->addColumn('product_name', function ($row) {

                 
                    return $row->title;
                })
                ->addColumn('rating', function ($row) {

                 
                    return $row->rating.'/5';
                })
                ->addColumn('seller', function ($row) {

                    return $row->seller_name;
                })
                ->addColumn('buyer', function ($row) {

                    return $row->buyer_name;
                })
                ->rawColumns(['id','product_name','rating', 'seller', 'buyer'])
                ->make(true);
        }
        return view('backend.review.index');

    }

    public function getVendorRating(Request $request){
        try {
            //dd($request->all());
            $rating_details = Vendor::where('id',$request->id)->first();
            if(isset($rating_details)){

                if ($request->ajax()) {
                 return \Response::json(\View::make('frontend.modals.vendor_rating', array('rating'=>  $rating_details->admin_rating,'vendor_id' => $request->id ,'rating_details' => $rating_details))->render());
                }

                return $this->successResponse($rating_details,'Rating Details.');
            }
            return \Response::json(\View::make('frontend.modals.vendor_rating', array('rating'=> 0 ,'vendor_id' => $request->id ,'rating_details' => '10'))->render());

            return $this->errorResponse('Invalid rating', 404);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Show the form for creating a new country resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    public function update_vendor_rating(Request $request){
        try{
           $ratings= Vendor::where('id', $request->vendor_id)->update(['admin_rating' => $request->rating]);

           if(isset($ratings)) {
            return 'Success';
        }
        return $this->errorResponse('Invalid order', 200);

        } catch (Exception $e) {
        return $this->errorResponse($e->getMessage(), 400);
        }
            }


    /**
     * Store a newly created country resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified country resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$domain = '',$product_sku)
    {
        $product =  Product::with('translation_one','media.image','vendor','allReviews.reviewFiles','allReviews.user')->where('sku',$product_sku)->first();
        // echo '<pre>';
        // print_r($product->toArray());
        return view('backend.review.detail',compact('product'));
    }

    /**
     * Show the form for editing the specified country resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
    }

    /**
     * Update the specified country resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $domain = '', int $id = 0)
    {
        $update = Arr::only($request->input(), ['status']);

        DB::transaction(function () use ($id, $update) {
            $orderProductRating = OrderProductRating::findOrFail($id);
            $orderProductRating->status = Arr::get($update, 'status', $orderProductRating->status);

            $orderProductRating->save();

            $product = Product::find($orderProductRating->product_id);
            $average = $product->reviews()->avg('rating');

            $product->averageRating = $average;
            $product->save();
        });

        if ($request->ajax()) {
            Session::flash('success', 'Review updated successfully');
            return response()->json([
                'status' => 'Success',
                'message' => 'Review updated successfully',
            ]);
        }

        return back()->with('success', 'Review updated successfully');
    }

    /**
     * Remove the specified country resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$domain = '',$review_id)
    {
        OrderProductRating::where('id',$review_id)->delete();
        return redirect()->back()->with('success', __('Review deleted successfully!'));
    }

      /**
     * update the specified country resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeCategoryStatus($category_id,Request $request)
    {

    }


}

