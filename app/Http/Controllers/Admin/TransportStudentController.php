<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportMember;
use App\Models\TransportRoute;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Section;
use App\Models\Session;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\FeesCategory;
use App\Models\Student;
use Carbon\Carbon;
use Toastr;
use Auth;

class TransportStudentController extends Controller
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
        $this->route = 'admin.transport-student';
        $this->view = 'admin.transport-student';
        $this->path = 'student';
        $this->access = 'transport-member';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['store','update']]);
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
            $data['selected_faculty'] = $faculty = 0;
        }

        if(!empty($request->program) || $request->program != null){
            $data['selected_program'] = $program = $request->program;
        }
        else{
            $data['selected_program'] = $program = 0;
        }

        if(!empty($request->session) || $request->session != null){
            $data['selected_session'] = $session = $request->session;
        }
        else{
            $data['selected_session'] = $session = 0;
        }

        if(!empty($request->semester) || $request->semester != null){
            $data['selected_semester'] = $semester = $request->semester;
        }
        else{
            $data['selected_semester'] = $semester = 0;
        }

        if(!empty($request->section) || $request->section != null){
            $data['selected_section'] = $section = $request->section;
        }
        else{
            $data['selected_section'] = $section = '0';
        }


        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['transportRoutes'] = TransportRoute::where('status', '1')->orderBy('title', 'asc')->get();


        // Filter Search
        if(!empty($request->faculty) && $request->faculty != 0 && $request->faculty != 'all'){
        $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        }

        if(!empty($request->program) && $request->program != 0 && $request->program != 'all'){
        $sessions = Session::where('status', 1);
        $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['sessions'] = $sessions->orderBy('id', 'desc')->get();}

        if(!empty($request->program) && $request->program != 0 && $request->program != 'all'){
        $semesters = Semester::where('status', 1);
        $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['semesters'] = $semesters->orderBy('id', 'asc')->get();}

        if(!empty($request->program) && !empty($request->semester)){
            $sections = Section::where('status', 1);
            $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
                $query->where('program_id', $program);
                $query->where('semester_id', $semester);
            });
            $data['sections'] = $sections->orderBy('title', 'asc')->get();}

            // Student Filter
            if(!empty($request->program) || !empty($request->semester) &&  !empty($request->faculty)  && !empty($request->session)  && !empty($request->section) ){

                $students = Student::where('id', '!=', '0');
                if($faculty != 0 && $faculty != 'all'){
                    $students->with('program')->whereHas('program', function ($query) use ($faculty){
                        $query->where('faculty_id', $faculty);
                    });
                }
                if($program != 0 && $program != 'all'){
                    $students->where('program_id', $program);
                }
                if(($session != 0 && $session != 'all') || ($semester != 0 && $semester != 'all') || ($section != 0 && $section != 'all')){
                  $students->with('currentEnroll')->whereHas('currentEnroll', function ($query) use ($session, $semester, $section){
                    if($session != 0 && $session != 'all'){
                        $query->where('session_id', $session);
                    }
                    if($semester != 0 && $semester != 'all'){
                        $query->where('semester_id', $semester);
                    }
                    if($section != 0 && $section != 'all'){
                        $query->where('section_id', $section);
                    }
                        $query->where('status', '1');
                });
                }
                $data['rows'] = $students->orderBy('student_id', 'desc')->get();
            }
    
        $department = Department::where('title','Transportation')->first();
        $data['feeCategories'] = FeesCategory::where('department_id',$department->id)->select('id','title')->get();

        return view($this->view.'.index', $data);
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
            'route' => 'required',
            'vehicle' => 'required',
            'student_id' => 'required',
            'member_id' => 'required',
            'halts' => 'required',
            'fee_category_id' => 'required',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Insert Data
        $member = TransportMember::firstOrNew(['id' => $request->member_id]);
        $member->transport_route_id = $request->route;
        $member->transport_vehicle_id = $request->vehicle;
        $member->fee_category_id = $request->fee_category_id;
        $member->start_date = Carbon::today();
        $member->halt_id = $request->halts;
        $member->status = '1';
        $member->created_by = Auth::guard('web')->user()->id;

        $student->transport()->save($member);


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
        $member = TransportMember::findOrFail($request->member_id);
        $member->end_date = Carbon::today();
        $member->status = $request->status;
        $member->updated_by = Auth::guard('web')->user()->id;
        $member->fee_category_id = $request->fee_category_id;
        $member->save();

        if($request->status == 0){
            Toastr::success(__('msg_canceled_successfully'), __('msg_success'));
        }
        elseif($request->status == 1){
            Toastr::success(__('msg_approve_successfully'), __('msg_success'));
        }

        return redirect()->back();
    }

}
