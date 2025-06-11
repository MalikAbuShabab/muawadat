<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
 

    public function customerSupportForm(Request $request){
        return view('frontend/account/support_ticket');
    }

    public function customerSupportTickets(Request $request){

        $tickets = SupportTicket::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('frontend/account/support_ticket_list', compact('tickets'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your support ticker has been !');
    }

    public function index()
    {
        $tickets = SupportTicket::with('user')->latest()->get();
        return view('admin.support.index', compact('tickets'));
    }

    public function update(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $request->validate([
            'admin_response' => 'required|string',
            'status' => 'required|in:open,pending,resolved',
        ]);

        $ticket->update([
            'admin_response' => $request->admin_response,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Response sent successfully!');
    }


}
