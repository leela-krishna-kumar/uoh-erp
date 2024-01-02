<?php 
/**
 *
 * @category zStarter
 *
 * @ref Defenzelite Product
 * @author <Defenzelite  hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 1.2.0>
 * @link <https://www.defenzelite.com>
 */ 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

use Laravel\Passport\PersonalAccessTokenResult;

class AuthController extends Controller
{

    //login
    public function login(Request $request)
    {
        $validData = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);
        if(!auth()->attempt($validData)){
            return response()->json([
                'message' => 'Invalid credentials!',
                'success' => 0
            ], 200);
        }
        $accessToken = Auth::user()->createToken('authToken');
        $token = $accessToken->accessToken;
        // $accessToken = Auth::user()->createToken('authToken')->plainTextToken;
        $user = User::where('id',auth()->id())->select('id','first_name','last_name','email','phone')->with('fleet',function($q){
            $q->select('id','vehicle_id','driver_id')->with('vehicle',function($q1){
                $q1->select('id','type','number');
            });
        })->first();
        return $this->successResponse($user,$token); 
    }


    //profile
    public function profile(Request $request)
    {
        // $user = User::where('id',auth()->id())->select('id','first_name','last_name','email','phone')->with('fleet')->first();
        $user = User::where('id',auth()->id())->select('id','first_name','last_name','email','phone')->with('fleet',function($q){
            $q->select('id','vehicle_id','driver_id')->with('vehicle',function($q1){
                $q1->select('id','type','number');
            });
        })->first();
        return $this->success($user); 
    }

    //logout
    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response([
            'message' => 'Logged out successfully!',
            'status'  => 0
        ]);
    }
}
