<?php

namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Redirect;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Measurements;
use App\Models\P2pBid;
use App\Models\P2pBidDocument;
use App\Models\PaymentMilestone;
use App\Models\ProductMeasurement;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Front\FrontController;
use App\Http\Traits\{ProductActionTrait, ProductTrait,ProductVariantActionTrait};

class PaymentMilestoneController extends FrontController
{
    
    public function store(Request $request)
    {
         
        $request->validate([
            'milestone_type' => 'required|string',
            'milestone_count' => 'required|integer',
            'amount' => 'required|array',
            'dueDate' => 'required|array',
            'amount.*' => 'required|numeric',
            'dueDate.*' => 'required|date',
        ]);

        // Store the milestone data
        $isMileStone = PaymentMilestone::where('product_id', $request->product_id)->where('bid_id', $request->bid_id)->get();
        if ($isMileStone->count() > 0) {
            $isMileStone->each(function($milestone) {
                $milestone->delete(); // Delete each milestone in the collection
            });
        }
        for ($i = 0; $i < $request->milestone_count; $i++) {
            PaymentMilestone::create([
                'product_id' => $request->product_id,
                'bid_id' => $request->bid_id,
                'total_milestone' => $request->milestone_count,
                'amount' => $request->amount[$i],
                'milestone_type' => $request->milestone_type,
                'created_by' => Auth::user()->id,
                'due_date' => $request->dueDate[$i],
            ]);
        }

        // Return response
        return response()->json(['success' => true, 'message' => 'Milestones created successfully!']);
    }

    // public function update(Request $request, $id)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'amount' => 'required|numeric',
    //         'dueDate' => 'required|date',
    //     ]);

    //     // Find the milestone by ID
    //     $milestone = Milestone::findOrFail($id);

    //     // Update the milestone data
    //     $milestone->update([
    //         'amount' => $request->amount,
    //         'due_date' => $request->dueDate,
    //     ]);

        
    //     return response()->json(['success' => true, 'message' => 'Milestone updated successfully!']);
    // }

    public function list(Request $request){
        $milestone = P2pBid::with(['bidMilestones', 'product','buyer'])->where('seller_id', Auth::user()->id)->whereNull('withdraw_by')->where('bid_status' ,'!=', 'rejected')->orderBy('id', 'DESC')->get();
        
        return view('frontend.template_nine.marketplace.milestone_list')->with(['milestone' => $milestone]);
    }

    public function buyerMilstoneViewlist(Request $request){
        $milestone = P2pBid::with(['bidMilestones', 'product' ,'bidDocument','seller'])->where('buyer_id', Auth::user()->id)->whereNull('withdraw_by')->where('bid_status' ,'!=', 'rejected')->orderBy('id', 'DESC')->get();
        return view('frontend.template_nine.bid.buyer_milestone_list')->with(['milestone' => $milestone]);
    }

    public function toggleApproval($id, Request $request)
    {
       try {
        $milestones = PaymentMilestone::where('bid_id', $request->bid_id)->get();
        $approvalValue = $request->is_approved ? 1 : 0;
        
        foreach ($milestones as $milestone) {
            $milestone->is_approved = $approvalValue;
            $milestone->save();
        }

        // Return a JSON response
        return response()->json(['success' => true]);
       } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
       }
    }

    public function updateMarkPaymentStatus(Request $request){
        // return $request->all();

        $request->validate([
            'milestone_id' => 'required|exists:payments_milestones,id',
        ]);

        $milestone = PaymentMilestone::findOrFail($request->milestone_id);
        $milestone->status = 'completed';
        $milestone->save();

        return response()->json(['success' => true, 'message' => 'Pyament Marked Successfully !']);
    }


    
      
}
