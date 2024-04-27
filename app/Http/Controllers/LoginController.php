<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Student;
use Toastr;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try{
            $request->validate([
                'user_name' => 'required',
                'password' => 'required|min:6|max:255',
            ]);

            $user = User::where('email', $request->user_name)->first();
            $student = Student::where('email', $request->user_name)->first();
            if ($user && (Hash::check($request->password, $user->password))) {
                $user->fcm_token = $request->fcm_token;
                $user->save();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'User Login successful',
                    'login_flag' => 0
                ]);
            } else if ($student && Hash::check($request->password, $student->password)) {
                    $student->fcm_token = $request->fcm_token;
                    $student->save();
                    return response()->json([
                        'status_code' => 200,
                        'message' => 'Student Login successful',
                        'login_flag' => 1
                    ]);
            } else {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Login Failed. Invalid Credentials'
                ]);
            }
        } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));
    
            return redirect()->back();
        }
    }
}
