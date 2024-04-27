<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;
use App\Models\Student;

use Closure;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class SetpasswordController extends Controller
{
    public function showSetPasswordForm()
    {
        return view('web.student.set_password',[
            'title' => 'Student Login',
            'loginRoute' => 'student.login',
            'forgotPasswordRoute' => 'student.password.request',
        ]);
    }


    public function reset(Request $request)
    {
      //dd($request->all());

        // Field Validation
        $request->validate([
            'roll_no' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Student::where('roll_no', $request->roll_no)->first();

        if(Crypt::decryptString($user->password_text) == $request->password){
            return redirect()->back()->with('error', 'New password cannot be old password');
        }

        if(isset($user)){
                $user->password = Hash::make($request->password);
                $user->password_text = Crypt::encryptString($request->password);
                $user->update();

                Session::flush();

                return redirect()->route('student.login')->with('success', __('auth_password_changed_successfully'));
        }
        
        return redirect()->back()->with('error', __('auth_account_not_found'));
    }
}