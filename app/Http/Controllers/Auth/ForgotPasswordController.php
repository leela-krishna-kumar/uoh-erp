<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Mail\ForgotPassword;
use App\Models\MailSetting;
use App\User;
use Password;
use Auth;
use Mail;
use DB;
use Toastr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm ()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        Log::info('sendResetLinkEmail');
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->orWhere('secondary_email', $request->email)->first();
        $mail = MailSetting::where('status', '1')->first();

        if(isset($user) && isset($mail->sender_email) && isset($mail->sender_name)){
            $token = str_random(32);
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
            ]);

            // Passing data to email template
            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['email'] = $user->email;
            $data['token'] = $token;

            // Mail Information
            $data['subject'] = __('auth_reset_password_notification');
            $data['from'] = $mail->sender_email;
            $data['sender'] = $mail->sender_name;

            $message = "Dear " . $user->first_name . " " . $user->last_name . "\n\nThe password for login is -" . Crypt::decryptString($user->password_text) . "\n\nNote: For security concerns, please change your password as soon as possible.\n\nThanks & Regards\nTeam ";
            Log::info("checking");
            mail($data['email'], $data['subject'], $message);

            if($user->secondary_email != null && $user->secondary_email != '')
            {
                mail($user->secondary_email, $data['subject'], $message);
            }
            Log::info($message);
            Log::info($data['subject']);

            Log::info($data['email']);

            // Mail::to($data['email'])->send(new ForgotPassword($data));
            Toastr::success(__(''), __('auth_password_reset_link_mailed'));

            return redirect()->back()->with('success', __('auth_password_reset_link_mailed'));
        }
        Toastr::error(__(''), __('auth_account_not_found'));

        return redirect()->back()->with('error', __('auth_account_not_found'));
    }
}
