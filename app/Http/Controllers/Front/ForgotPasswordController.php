<?php

namespace App\Http\Controllers\Front;
use DB;
use Auth;
use Session;
use Password;
use Carbon\Carbon;
use Omnipay\Omnipay;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Omnipay\Common\CreditCard;
use App\Http\Traits\ApiResponser;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Front\FrontController;
use App\Models\{AppStyling, AppStylingOption, Currency, Client, Category, Brand, Cart, ReferAndEarn, ClientPreference, Vendor, ClientCurrency, User, Country, UserRefferal, Wallet, WalletHistory, CartProduct, PaymentOption, UserVendor,Permissions, UserPermissions, VendorDocs, VendorRegistrationDocument, EmailTemplate, WebStylingOption};

class ForgotPasswordController extends FrontController{
    use ApiResponser;
    public function getResetPasswordForm(Request $request,$domain = '',$token=false){

        $langId = Session::get('customerLanguage');
        $curId = Session::get('customerCurrency');
        $navCategories = $this->categoryNav($langId);
        $set_template = WebStylingOption::where('web_styling_id',1)->where('is_selected',1)->first();
        $reset_password_page = "account.resetPassword";
        if($set_template->template_id == 8)
        {
            $reset_password_page = "template_eight.account.resetPassword";
        }
        return view('frontend.'. $reset_password_page)->with(['navCategories' => $navCategories, 'token' => $token]);
    }

    public function resetSuccess($domain = ''){
        $langId = Session::get('customerLanguage');
        $curId = Session::get('customerCurrency');
        $navCategories = $this->categoryNav($langId);
        return view('frontend/account/resetSuccess')->with(['navCategories' => $navCategories]);
    }
    public function getForgotPasswordForm($domain = ''){
        $curId = Session::get('customerCurrency');
        $langId = Session::get('customerLanguage');
        $navCategories = $this->categoryNav($langId);
        return view('frontend/account/forgotPassword')->with(['navCategories' => $navCategories]);
    }

    public function forgetPasswordOtp(Request $request, $domain = ''){
        $email = $request->email ?? '';
        $onlyOtp=true;
        \Log::info('email: '.$email);
        $this->postForgotPassword($request, $domain = '',$onlyOtp);
        return response()->json([
            'status' => 'Success',
            'redirect' => url(route('customer.forgotPass.otp.form')) . '?email=' . $email,  
        ]);
    }

    public function forgetPasswordOtpForm(Request $request, $domain = ''){
       $userMail = $request->email;
       return view('frontend/account/forgetPasswordOtp')->with('forgetMail', $userMail);
    }

    public function postForgotPassword(Request $request, $domain = '', $onlyOtp=false){
         \Log::info($onlyOtp);
        try {
            $request->validate([
                'email' => 'required|email|exists:users',
            ],['email.required' => __('The email field is required.'),'email.exists' => __('You are not registered with us. Please sign up.')]);
            $client = Client::select('id', 'name', 'email', 'phone_number', 'logo')->where('id', '>', 0)->first();
            $user = User::where('email',$request->email)->first();
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
                DB::table('password_resets')->insert(['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]);
                $email_template_content = '';
                 
                if($onlyOtp){
                    // write custom otp template
                    $email_template = EmailTemplate::where('id', 12)->first();
                    $email_template_content = $email_template->content;
                    $email_template_content = str_ireplace("{code}", $otp, $email_template_content);
                    $email_template_content = str_ireplace("{customer_name}", ucwords($user->name), $email_template_content);
                    $data = [
                        'code' => $otp,
                        'link' => "link",
                        'email' => $sendto,
                        'mail_from' => $mail_from,
                        'client_name' => $client_name,
                        'logo' => $client->logo['original'],
                        'subject' => $email_template->subject,
                        'customer_name' => ucwords($user->name),
                        'email_template_content' => $email_template_content,
                    ];
                }else{
                    $email_template = EmailTemplate::where('id', 3)->first();
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

                }
                 
                dispatch(new \App\Jobs\sendForgotPasswordEmail($data))->onQueue('forgot_password_email');
               
                /* Send sms to user */
                // $prefer = ClientPreference::select('mail_type', 'mail_driver', 'mail_host', 'mail_port', 'mail_username','mail_password', 'mail_encryption', 'mail_from', 'sms_provider', 'sms_key', 'sms_secret', 'sms_from', 'theme_admin', 'distance_unit', 'map_provider', 'date_format', 'time_format', 'map_key', 'sms_provider', 'verify_email', 'verify_phone', 'app_template_id', 'web_template_id')->first();
                // if ($user->dial_code == "971") {
                //     $to = '+' . $user->dial_code . "0" . $user->phone_number;
                // } else {
                //     $to = '+' . $user->dial_code . $user->phone_number;
                // }
                // if(!empty($prefer->sms_key) && !empty($prefer->sms_secret) && !empty($prefer->sms_from)){
                //     $provider = $prefer->sms_provider;
                //     $body = "Dear ".ucwords($user->name)." reset password link is: ".url('/reset-password/'.$token);
                //     $this->sendSms($provider, $prefer->sms_key, $prefer->sms_secret, $prefer->sms_from, $to, $body);
                // }
            }
            return $this->successResponse([],__('We have e-mailed your password reset link!'));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
            
    }

    public function verifyForgetPasswordOtp(Request $request, $domain = ''){
        $otp = $request->input('otp_1').$request->input('otp_2').$request->input('otp_3').$request->input('otp_4');
        $user = User::where('email',$request->email)->where('email_token',$otp)->first();
        $resetToken = DB::table('password_resets')->where(['email' => $request->email])->first();
        if($user){
            Session::flash('success', 'Otp Verified Successfully!.');
            return redirect()->route('reset-password-link', ['token' => $resetToken->token]);
        }else{
            Session::flash('error', 'Invalid OTP !.');
            return redirect()->back();
            // return response()->json(['status' => 'error', 'message' => 'Invalid OTP']);
        } 

    }

    /**     * Display resetPassword Form     */
    public function postUpdateResetPassword(Request $request, $domain = ''){
        $request->validate([
            'token' => 'required',
            'password_confirmation' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => __('The password field is required.'), 
            'password.confirmed' => __('The password confirmation does not match.'),
            'password_confirmation.required' => __('The password confirmation field is required.')
        ]);
        $updatePassword = DB::table('password_resets')->where(['token' => $request->token])->first();
        if($updatePassword){
            $user = User::where('email', $updatePassword->email)->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();
            return $this->successResponse([],__('Your password has been changed!'));
        }else{
            return $this->errorResponse(__('Invalid Token!'), 400);
        }
    }
}
