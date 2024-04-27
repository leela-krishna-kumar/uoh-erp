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

class LibraryAttendenceController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = 'Library Attendence';
        $this->route = 'admin.library-attendence';
        $this->view = 'admin.library-attendence';
        $this->path = 'library-attendence';
        $this->access = 'library-attendence';

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

          //  dd($data['row']);

            $student_enroll_data = StudentEnroll::where('student_id', $request->student)->first();

            // Filter Enroll Data
            $data['sessions'] = Session::with('programs')->whereHas('programs', function ($query) use ($student){
                $query->where('program_id', $student->program_id);
            })->where('status', '1')->orderBy('id', 'desc')->get();
            
            $data['semesters'] = Semester::with('programs')->whereHas('programs', function ($query) use ($student){
                $query->where('program_id', $student->program_id);
            })->where('status', '1')->orderBy('id', 'asc')->get();

            $data['sections'] = Section::with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($student){
                $query->where('program_id', $student->program_id);
            })->where('status', '1')->orderBy('title', 'asc')->get();

            $data['library_attendence_roll_latest'] = LibraryAttendence::where('roll_no', $request->search_roll)->orderBy('id', 'desc')->first();

            // dd($data['library_attendence_roll_latest']);           
        }
        else {
            $data['selected_student'] = Null;
        }


        $data['library_attendence'] = LibraryAttendence::orderBy('id', 'desc')->limit(100)->get();


        return view($this->view .'.index', $data);
    }


    public function store(Request $request)
    {
                // dd($request->all());

        $library_attendence = new LibraryAttendence();

        $student_enroll_id = StudentEnroll::where('student_id', $request->student_id)->first();

        // dd($student_enroll_id);

        $library_attendence->student_id = $request->student_id;
        $library_attendence->student_enroll_id = $student_enroll_id->id;
        $library_attendence->roll_no = $request->roll_no;
        $library_attendence->name = $request->name;
        $library_attendence->in_time = $request->in_time;

        $library_attendence->save();

        Toastr::success(__('Checkin Successful'), __('msg_success'));


        return redirect()->back();
    }

    public function update(Request $request, $id){

        // dd($request->all());

        $library_attendence = LibraryAttendence::find($id);

        $library_attendence->out_time = $request->out_time;

        $library_attendence->update();

        Toastr::success(__('Checkout Successful'), __('msg_success'));

        return redirect()->back();

    }

    public function destroy($id)
    {
        //
        $library_attendence = LibraryAttendence::findOrFail($id);

        if($library_attendence->status == 0){
        // Delete Attach
        // $this->deleteMedia($this->path, $library_attendence);

        // Delete data
        $library_attendence->delete();


            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        }
        else{
            Toastr::error(__('msg_deleted_fail'), __('msg_error'));
        }

        return redirect()->back();
    }
    
}
