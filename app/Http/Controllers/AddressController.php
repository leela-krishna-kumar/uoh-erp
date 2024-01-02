<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Session;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Student;
use App\Models\Province;
use App\Models\QuestionBank;
use Carbon\Carbon;
use App\Models\Address;
use App\Models\District;
use Auth;
use DB;

class AddressController extends Controller
{

  public function filterProvince(Request $request){
   
    $states = Province::select('id','title')->whereCountryId($request->country)->get();
    return response()->json($states);
  }
  public function filterDistrict(Request $request){
    $states = District::select('id','title')->whereProvinceId($request->province)->get();
    return response()->json($states);
  }
}

