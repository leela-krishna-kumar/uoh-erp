<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\IdCardSetting;
use App\Models\LibraryAttendence;
use App\Models\LibraryMember;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Section;
use App\Models\Session;
use App\Models\Faculty;
use App\Models\Fee;
use App\Models\FeesCategory;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\Subject;
use Carbon\Carbon;
use Toastr;
use Auth;

class LibraryAutoCheckInOutController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = 'Library Auto Checkin Checkout';
        $this->route = 'admin.library-autocheckinout';
        $this->view = 'admin.library-autocheckinout';
        $this->path = 'library-autocheckinout';
        $this->access = 'library-autocheckinout';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

       
        
        if(!empty($request->search_roll) && $request->search_roll != Null){

            $data['selected_student'] = $request->search_roll;

            $data['row'] = $student = Student::where('roll_no', $request->search_roll)->first();

            $student_enroll_data = StudentEnroll::where('student_id', $request->student)->first();

            $data['library_attendence_roll_latest'] = $library_attendence_roll_latest = LibraryAttendence::where('roll_no', $request->search_roll)->orderBy('id', 'desc')->first();

            if($library_attendence_roll_latest != null && $library_attendence_roll_latest->out_time == null){
                $this->auto_checkout($data['library_attendence_roll_latest']->id);
            }else{
                $this->auto_checkin($student->student_id, $student->roll_no, $student->first_name);                
            }

            // dd($data['library_attendence_roll_latest']);           
        }
        else {
            $data['selected_student'] = Null;
        }


        $data['library_attendence'] = LibraryAttendence::orderBy('id', 'desc')->limit(100)->get();


        return view($this->view .'.index', $data);
    }

    public function auto_checkin($student_id, $roll_no, $name )
    {
                // dd($request->all());

        $library_attendence = new LibraryAttendence();

        $student_enroll_id = StudentEnroll::where('student_id', $student_id)->first();

        // dd($student_enroll_id);

        $library_attendence->student_id = $student_id;
        $library_attendence->student_enroll_id = $student_enroll_id->id;
        $library_attendence->roll_no = $roll_no;
        $library_attendence->name = $name;
        $library_attendence->in_time = Carbon::now();

        $library_attendence->save();

        // dd( $library_attendence);

        Toastr::success('Checkin Successful', __('msg_success'));

        return redirect()->back()->with('success', 'Checkin Successful' );
    }

    public function auto_checkout($id){

        // dd($request->all());

        $library_attendence = LibraryAttendence::find($id);

        $library_attendence->out_time = Carbon::now();

        $library_attendence->update();

        // dd( $library_attendence);

        Toastr::success('Checkout Successful', __('msg_success'));

        return redirect()->back()->with('success', 'Checkout Successful' );
    }

}
