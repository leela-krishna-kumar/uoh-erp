<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hostel;
use Toastr;
use App\Models\ExamType;
use App\Models\Semester;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Session;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Exam;
use App\Models\Student;
use App\Models\FeesCategory;
use App\Models\Fee;
use App\Models\Department;
use App\Models\HostelMember;
use App\Models\Designation;
use App\User;

class HostelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_hostel', 1);
        $this->route = 'admin.hostel';
        $this->view = 'admin.hostel';
        $this->path = 'hostel';
        $this->access = 'hostel';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-view', ['only' => ['report.staff-fee-defaulters']]);
        $this->middleware('permission:'.$this->access.'-view', ['only' => ['report.student-fee-defaulters']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['rows'] = Hostel::orderBy('name', 'asc')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|max:191|unique:hostels,name',
            'type' => 'required',
        ]);

        // Insert Data
        $hostel = new Hostel;
        $hostel->name = $request->name;
        $hostel->type = $request->type;
        $hostel->capacity = $request->capacity;
        $hostel->warden_name = $request->warden_name;
        $hostel->warden_contact = $request->warden_contact;
        $hostel->address = $request->address;
        $hostel->note = $request->note;
        $hostel->save();


        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Hostel $hostel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Hostel $hostel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hostel $hostel)
    {
        // Field Validation
        $request->validate([
            'name' => 'required|max:191|unique:hostels,name,'.$hostel->id,
            'type' => 'required',
        ]);

        // Update Data
        //$hostel->hostel_id = $request->hostel_id;
        $hostel->name = $request->name;
        $hostel->type = $request->type;
        $hostel->capacity = $request->capacity;
        $hostel->warden_name = $request->warden_name;
        $hostel->warden_contact = $request->warden_contact;
        $hostel->address = $request->address;
        $hostel->note = $request->note;
        $hostel->status = $request->status;
        $hostel->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hostel $hostel)
    {
        // Delete Data
        $hostel->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }


    public function studentFeeDefaulter(Request $request)
    {
        //
        $data['title'] = trans_choice('module_student_hostel_fee_defaulters', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

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

        if(!empty($request->status) || $request->status != null){
            $data['selected_status'] = $status = $request->status;
        }
        else{
            $data['selected_status'] = '0';
        }
        $department = Department::where('title','Hostel')->first();
        $data['categories'] = FeesCategory::where('department_id',@$department->id)->get();
        if(!empty($request->category) || $request->category != null){
            $data['selected_category'] = $category = $request->category;
        }
        else{
            $data['selected_category'] = $category = '0';
        }
        if(!empty($request->student_id) || $request->student_id != null){
            $data['selected_student_id'] = $student_id = $request->student_id;
        }
        else{
            $data['selected_student_id'] = $student_id = null;
        }
        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

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
        $data['sections'] = $sections->orderBy('title', 'asc')->get();}


        // Student Filter
        
        if(!empty($request->program) || !empty($request->semester) &&  !empty($request->faculty)  && !empty($request->session)  && !empty($request->section) || !empty($request->status)){
            $students = Student::where('status', '1');
            if($faculty != 0 && $faculty != 'all'){
                $students->with('program')->whereHas('program', function ($query) use ($faculty){
                    $query->where('faculty_id', $faculty);
                });
            }
            if(($session != 0 && $session != 'all') || ($semester != 0 && $semester != 'all') || ($section != 0 && $section != 'all')){ 
                 $students->with('currentEnroll')->whereHas('currentEnroll', function ($query) use ($program, $session, $semester, $section){
                    if($program != 0 && $program != 'all'){
                    $query->where('program_id', $program);
                    }
                    if($session != 0 && $session != 'all'){
                    $query->where('session_id', $session);
                    }
                    if($semester != 0 && $semester != 'all'){
                    $query->where('semester_id', $semester);
                    }
                    if($section != 0 && $section != 'all'){
                    $query->where('section_id', $section);
                    }
                });
            }

            if(!empty($request->status) && $request->status != 'all'){
                $students->with('statuses')->whereHas('statuses', function ($query) use ($status){
                    $query->where('status_type_id', $status);
                });
            }
            $data['rows'] = $students->orderBy('student_id', 'desc')->get();

        }
        $department = Department::where('title','Hostel')->first();
        $data['categories'] = FeesCategory::where('department_id',@$department->id)->get();
        
        $hostelStudentsIds = HostelMember::where('hostelable_type',Student::Class)->where('status',1)->pluck('hostelable_id')->toArray();
        
        $students = Student::whereIn('id',$hostelStudentsIds);
        $data['rows'] = $students->orderBy('student_id', 'desc')->get();

        if($request->id){
            $students = Student::where('id','LIKE', '%'.$request->id.'%')->orWhere('admission_no','LIKE', '%'.$request->id.'%');
            $data['rows'] = $students->orderBy('student_id', 'desc')->get();
        }
        // if(!empty($request->student_id)){
        //     $fees->whereHas('studentEnroll.student', function ($query) use ($student_id){
        //         if($student_id != 0){
        //         $query->where('student_id', 'LIKE', '%'.$student_id.'%');
        //         }
        //     });
        // }

        $data['category_id'] = '22';

        if(count($data['categories']) != 0){
           $data['category_id'] = $data['categories'][0]['id'];
        }

        
        return view($this->view.'.report.student-fee-defaulters', $data);
    }

    public function staffFeeDefaulter(Request $request)
    {
        $data['title'] = trans_choice('module_staff_hostel_fee_defaulters', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['departments'] = Department::where('status', 1)->orderBy('title', 'asc')->get();
        $data['designations'] = Designation::where('status', 1)->orderBy('title', 'asc')->get();
        $data['hostels'] = Hostel::where('type', '!=', '3')->where('status', '1')->orderBy('name', 'asc')->get();


        if(!empty($request->department) || $request->department != null){
            $data['selected_department'] = $department = $request->department;
        }
        else{
            $data['selected_department'] = '0';
        }

        if(!empty($request->category) || $request->category != null){
            $data['selected_category'] = $category = $request->category;
        }
        else{
            $data['selected_category'] = $category = '0';
        }
        if(!empty($request->designation) || $request->designation != null){
            $data['selected_designation'] = $designation = $request->designation;
        }
        else{
            $data['selected_designation'] = '0';
        }


        // Staff List
        $department = Department::where('title','Hostel')->first();
        $data['categories'] = FeesCategory::where('department_id',@$department->id)->get();
        
        $hostelUserIds = HostelMember::where('hostelable_type',User::Class)->where('status',1)->pluck('hostelable_id')->toArray();
        
        $users = User::where('id', '!=', '0')->whereIn('id',$hostelUserIds);
        if(!empty($request->department) && $request->department != '0'){
            $users->where('department_id', $department);
        }
        if(!empty($request->designation) && $request->designation != '0'){
            $users->where('designation_id', $designation);
        }
        $data['rows'] = $users->orderBy('staff_id', 'desc')->get();


        return view($this->view.'.report.staff-fee-defaulters', $data);
    }
}
