<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use Yajra\DataTables\Facades\DataTables;

class NewsletterController extends Controller
{
    public function subscribe(Request $request) {
        \Log::info(['Subscribing to newsletter' => $request->all()]);
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);
        
        Newsletter::create(['email' => $request->email]);
        return response()->json(['message' => 'Subscribed successfully!']);
    }

    public function showNewsletterSubscribers(Request $request)
    {
        
        if ($request->ajax()) {
            $query = Newsletter::select('id', 'email', 'created_at');
            
            return DataTables::of($query)
                ->addColumn('created_at', function ($subscription) {
                    return $subscription->created_at->format('d M Y');
                })
                ->make(true);
        }

        return view('backend.subscriptions.subscribed_user');
    }
}
