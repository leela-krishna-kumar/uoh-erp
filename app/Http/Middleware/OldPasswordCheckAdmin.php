<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class OldPasswordCheckAdmin
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
        if (isset(Auth::user()->id) && Auth::user()->is_admin != 1) {

            // if(Auth::user()->staff_id == Crypt::decryptString(Auth::user()->password_text)) {
            if(Crypt::decryptString(Auth::user()->password_text) == 'password') {
    
                return redirect(route('admin.set-password'));
            }
        }

        return $next($request);
    }
}
