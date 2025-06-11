<?php

namespace App\Http\Controllers\Client\CMS;
use Illuminate\Http\Request;
use App\Models\NotificationTemplate;
use App\Http\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    use ApiResponser;

    public function index(){
        $notification_templates = NotificationTemplate::all();
        return view('backend.cms.notification.index', compact('notification_templates'));
    }
    public function show(Request $request, $domain = '', $id){
        $notification_template =  NotificationTemplate::where('id', $id)->first();
        return $this->successResponse($notification_template);
    }
    public function update(Request $request, $id){
        $rules = array(
            'subject' => 'required',
            'content' => 'required',
        );
        $validation  = Validator::make($request->all(), $rules)->validate();
        $notification_template = NotificationTemplate::where('id', $request->email_template_id)->firstOrFail();
        $notification_template->subject = $request->subject;
        $notification_template->content = $request->content;
        $notification_template->save();
        return $this->successResponse($notification_template, 'Notification Template Updated Successfully.');
    }


    public function getUnreadNotifications()
    {
        $notifications = Auth::user()->unreadNotifications;
        return response()->json($notifications);
    }
    
    public function getUserUnreadNotifications()
    {
        $user = Auth::user();
        if ($user->is_superadmin) {
            return response()->json([]);
        }
        $notifications = $user->unreadNotifications()->get();
        return response()->json($notifications);
    }

    public function markAsRead($domain, $id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    }


}
