<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class OldPasswordCheckStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
     //   dd('123');

        if (isset(Auth::user()->id)) {

            if(Auth::user()->roll_no == Crypt::decryptString(Auth::user()->password_text)) {

                return redirect(route('student.set-password'));
            }

        }

        return $next($request);
    }
}
