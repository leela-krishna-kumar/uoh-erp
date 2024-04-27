<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Student;
use App\User;
use Closure;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class SetpasswordController extends Controller
{
    public function showSetPasswordForm()
    {
        return view('auth.set_password',[
            'title' => 'Admin Reset Password',
            'loginRoute' => 'admin.set-password',
            'forgotPasswordRoute' => 'student.password.request',
        ]);
    }


    public function reset(Request $request)
    {
        //dd($request->all());

        // Field Validation
        $request->validate([
            'staff_id' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('staff_id', $request->staff_id)->first();

        if(Crypt::decryptString($user->password_text) == $request->password){
            return redirect()->back()->with('error', 'New password cannot be old password');
        }

        if(isset($user)){
                $user->password = Hash::make($request->password);
                $user->password_text = Crypt::encryptString($request->password);
                $user->update();

                Session::flush();

                return redirect('admin/login')->with('success', __('auth_password_changed_successfully'));
        }
        
        return redirect()->back()->with('error', __('auth_account_not_found'));
    }
}