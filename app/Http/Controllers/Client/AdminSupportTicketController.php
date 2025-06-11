<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;


class AdminSupportTicketController extends BaseController
{

    public function __construct(){
        
    }

    public function edit(SupportTicket $ticket)
    {
        return view('admin.support_tickets.edit', compact('ticket'));
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,pending,resolved',
            'admin_response' => 'required|string',
        ]);

        $ticket->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
        ]);

        return redirect()->route('admin.support_tickets.index')->with('success', 'Support ticket updated successfully!');
    }
}
