<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Image;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

trait SetPassword {

    /**
     * @param Request $request
     */

     public function setPasswordLogic(){
        if (isset(Auth::user()->id)) {


            if(Auth::user()->roll_no == Crypt::decryptString(Auth::user()->password_text)) {

             //   dd('123');

                return redirect('123');
            }
        }
     }
   
}