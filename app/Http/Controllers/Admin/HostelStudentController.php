<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\HostelMember;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Section;
use App\Models\Session;
use App\Models\Faculty;
use App\Models\Fee;
use App\Models\FeesCategory;
use App\Models\Student;
use App\Models\Hostel;
use App\Models\HostelRoom;
use App\Models\StudentEnroll;
use Carbon\Carbon;
use Toastr;
use Auth;

class HostelStudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_student', 1).' '.trans_choice('module_member', 1);
        $this->route = 'admin.hostel-student';
        $this->view = 'admin.hostel-student';
        $this->path = 'student';
        $this->access = 'hostel-member';


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;


        if(!empty($request->faculty) || $request->faculty != null){
            $data['selected_faculty'] = $faculty = $request->faculty;
        }
        else{
            $data['selected_faculty'] = $faculty = '0';
        }

        if(!empty($request->program) || $request->program != null){
            $data['selected_program'] = $program = $request->program;
        }
        else{
            $data['selected_program'] = $program = '0';
        }

        if(!empty($request->session) || $request->session != null){
            $data['selected_session'] = $session = $request->session;
        }
        else{
            $data['selected_session'] = $session = '0';
        }

        if(!empty($request->semester) || $request->semester != null){
            $data['selected_semester'] = $semester = $request->semester;
        }
        else{
            $data['selected_semester'] = $semester = '0';
        }

        if(!empty($request->section) || $request->section != null){
            $data['selected_section'] = $section = $request->section;
        }
        else{
            $data['selected_section'] = $section = '0';
        }

        if(!empty($request->hostel) || $request->hostel != null){
            $data['selected_hostel'] = $hostel = $request->hostel;
        }
        else{
            $data['selected_hostel'] = $hostel = '0';
        }

        if(!empty($request->rooms) || $request->rooms != null){
            $data['rooms'] = HostelRoom::where('status', '1')->orderBy('name', 'asc')->get();
            $data['selected_rooms'] = $rooms = $request->rooms;
        }
        else{
            $data['selected_rooms'] = $rooms = [];
        }


        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['hostels'] = Hostel::where('type', '!=', '3')->where('status', '1')->orderBy('name', 'asc')->get();


        // Filter Search
        if(!empty($request->faculty) && $request->faculty != '0'){
        $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();}

        if(!empty($request->program) && $request->program != '0'){
        $sessions = Session::where('status', 1);
        $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['sessions'] = $sessions->orderBy('id', 'desc')->get();}

        if(!empty($request->program) && $request->program != '0'){
        $semesters = Semester::where('status', 1);
        $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['semesters'] = $semesters->orderBy('id', 'asc')->get();}

        if(!empty($request->program) && $request->program != '0' && !empty($request->semester) && $request->semester != '0'){
        $sections = Section::where('status', 1);
        $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
            $query->where('program_id', $program);
            $query->where('semester_id', $semester);
        });
        $data['sections'] = $sections->orderBy('title', 'asc')->get();
    }


        // Student Filter

        $students = Student::where('id', '!=', '0');
        if ($hostel != 0){
            $hostel_rooms = HostelRoom::where('hostel_id',$hostel);
            if (!empty($rooms)){
                $hostel_rooms =$hostel_rooms->whereIn('id',$rooms);
            }
            $hostel_rooms = $hostel_rooms->pluck('id');
            // return $hostel_rooms;
            $students = $students->whereHas('hostelRoom', function ($query)  use ($hostel_rooms){
                $query->whereIn('hostel_room_id', $hostel_rooms);
            })
            ->with(['hostelRoom' => function ($query) {
            }, 'hostelRoom.room']);

            // $students = $students->where('id', '!=', '0')
            // ->has('hostelRoom')
            // ->with(['hostelRoom' => function ($query) {
            //     // Apply any conditions on hostelRoom if needed
            // }, 'hostelRoom.room' => function ($query) {
            //     // Apply where condition for room relation
            //     $query->where('hostel_id', 8); // Example condition: capacity greater than 2
            // }]);
        } else {
            $students = $students->has('hostelRoom')->with('hostelRoom.room');
        }

        if($faculty != 0){
            $students->with('program')->whereHas('program', function ($query) use ($faculty){
                $query->where('faculty_id', $faculty);
            });
        }
        if($program != 0){
            $students->where('program_id', $program);
        }
        if($session != 0 || $semester != 0 || $section != 0){
        $students->with('currentEnroll')->whereHas('currentEnroll', function ($query) use ($session, $semester, $section){
            if($session != 0){
            $query->where('session_id', $session);
            }
            if($semester != 0){
            $query->where('semester_id', $semester);
            }
            if($section != 0){
            $query->where('section_id', $section);
            }
            $query->where('status', '1');
        });
        }

        if (!empty($request->all())){
            $data['rows'] = $students->orderBy('student_id', 'desc')->get();

        } else {
            $data['rows'] =[];
        }

        // return  $data;
        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        if(!empty($request->search_roll) || $request->search_roll != null){
            $data['selected_search_roll'] = $search_roll = $request->search_roll;
        }
        else{
            $data['selected_search_roll'] = $semester = '';
        }

        $data['hostels'] = Hostel::where('type', '!=', '3')->where('status', '1')->orderBy('name', 'asc')->get();

        if (!empty($request->all())){
            $data['row'] = Student::where('roll_no',$request->search_roll)->with('currentEnroll')->with('program')->first();
            // return $data['row'];
        }


        return view($this->view.'.student-allocation', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'hostel_room' => 'required',
            'student_id' => 'required',
            'member_id' => 'required',
        ]);

    //    dd($request->all());

        $student = Student::findOrFail($request->student_id);

        $studentEnrollId = StudentEnroll::where('student_id', $request->student_id)->first();

        $department = Department::where('title','Hostel')->first();
        $feecategory = FeesCategory::where('department_id',@$department->id)->first();

       // dd($feecategory);

        // Insert Data
        $member = HostelMember::firstOrNew(['id' => $request->member_id]);

        // $member->faculty_id = $studentEnrollId->faculty_id;
        // $member->program_id = $studentEnrollId->program_id;
        // $member->session_id = $studentEnrollId->session_id;
        // $member->semester_id = $studentEnrollId->semester_id;
        // $member->section_id = $studentEnrollId->section_id;
        // $member->fee_category_id = $feecategory->id;

        $member->hostel_room_id = $request->hostel_room;
        $member->hostel_id = $request->hostel;
        $member->start_date = Carbon::today();
        $member->status = '1';
        $member->created_by = Auth::guard('web')->user()->id;

        $student->hostelRoom()->save($member);

     //   $feeCategories = FeesCategory::where('id', $feecategory->id)->first();

        $fees = new Fee;
        $fees->fee_master_id = null;
        // $fees->transport_members_id = $member->id;
        $fees->student_enroll_id = $studentEnrollId->id;
        $fees->category_id = $feecategory->id;
        $fees->fee_amount = $feecategory->amount;
        $fees->assign_date = carbon::now();
        $fees->due_date = Carbon::now()->addDays(30);
        $fees->created_by = Auth::guard('web')->user()->id;
        $fees->save();


        Toastr::success(__('msg_added_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Field Validation
        $request->validate([
            'member_id' => 'required',
            'status' => 'required'
        ]);


        // Update Data
        $member = HostelMember::findOrFail($request->member_id);
        $member->end_date = Carbon::today();
        $member->status = $request->status;
        $member->updated_by = Auth::guard('web')->user()->id;
        $member->save();

        if($request->status == 0){
            Toastr::success(__('msg_canceled_successfully'), __('msg_success'));
        }
        elseif($request->status == 1){
            Toastr::success(__('msg_approve_successfully'), __('msg_success'));
        }

        return redirect()->back();
    }

    public function cresteGatepass()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        return view($this->view.'.create-gate-pass', $data);
    }
}
