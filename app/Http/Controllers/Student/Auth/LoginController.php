<?php

namespace App\Http\Controllers\Student\Auth;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
	/**
     * This trait has all the login throttling functionality.
     */
    use ThrottlesLogins;
    
    //Your other code here...
    /**
	 * Max login attempts allowed.
	 */
	public $maxAttempts = 5;

	/**
	 * Number of minutes to lock the login.
	 */
	public $decayMinutes = 3;
    
    /**
     * Username used in ThrottlesLogins trait
     * 
     * @return string
     */
    public function username(){
        return 'roll_no';
    }

	/**
	 * Only guests for "student" guard are allowed except
	 * for logout.
	 * 
	 * @return void
	 */
	public function __construct()
	{
	    $this->middleware('guest:student')->except('logout');
	}

    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('web.student.login',[
            'title' => 'Student Login',
            'loginRoute' => 'student.login',
            'forgotPasswordRoute' => 'student.password.request',
        ]);
    }

	

    /**
     * Login the student.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
	{	
	    $this->validator($request);

	//	dd($request->all());

	    //check if the user has too many login attempts.
	    if ($this->hasTooManyLoginAttempts($request)){
	        //Fire the lockout event.
	        $this->fireLockoutEvent($request);

	        //redirect the user back after lockout.
	        return $this->sendLockoutResponse($request);
	    }

		
	    //attempt login.
	    if(Auth::guard('student')->attempt($request->only('roll_no','password'),$request->filled('remember'))){
	        //Authenticated
			
	        return redirect()
	            ->intended(route('student.student-dashboard.index'))
	            ->with('success', __('auth_logged_in'));
	    }
		

		

	    //keep track of login attempts from the user.
	    $this->incrementLoginAttempts($request);

	    //Authentication failed
	    return $this->loginFailed();
	}

    /**
     * Logout the student.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
	{
	    Auth::guard('student')->logout();

	    return redirect()
	        ->route('student.login')
	        ->with('success', __('auth_logged_out'));
	}

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request)
	{
	    //validation rules.
	    $rules = [
	        'roll_no'    => 'required|exists:students|min:5|max:191',
	        'password' => 'required|string|min:6|max:255',
	    ];

	    //custom validation error messages.
	    $messages = [
	        'roll_no.exists' => __('auth_credentials_not_match'),
	    ];

	    //validate the request.
	    $request->validate($rules,$messages);
	}

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed(){

	    return redirect()
	        ->back()
	        ->withInput()
	        ->with('error', __('auth_login_failed'));
	}
}
