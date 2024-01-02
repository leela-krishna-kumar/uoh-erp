<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\HostelAttendance;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use Toastr;

class HostelAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_hostel_attendance', 2);
        $this->route = 'admin.hostel-attendance';
        $this->view = 'admin.hostel-attendance';
        $this->path = 'hostel-attendance';
        $this->access = 'hostel-attendance';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-show', ['only' => ['show']]);

    }
    public function index(Request $request)
    {
    
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
       
        $hostelAttendances = HostelAttendance::query();

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

        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();


        if(!empty($request->faculty) && $request->faculty != '0'){
            $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        }

        if(!empty($request->program) && $request->program != '0'){
            $sessions = Session::where('status', 1);
            $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
                $query->where('program_id', $program);
            });
            $data['sessions'] = $sessions->orderBy('id', 'desc')->get();
        }

        if(!empty($request->program) && $request->program != '0'){
            $semesters = Semester::where('status', 1);
            $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
                $query->where('program_id', $program);
            });
            $data['semesters'] = $semesters->orderBy('id', 'asc')->get();
        }

        if(!empty($request->program) && $request->program != '0' && !empty($request->semester) && $request->semester != '0'){
            $sections = Section::where('status', 1);
            $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
                $query->where('program_id', $program);
                $query->where('semester_id', $semester);
            });

            $data['sections'] = $sections->orderBy('title', 'asc')->get();
        }
        
        $data['rows'] = $hostelAttendances->orderBy('id', 'desc')->get();

        return view($this->view.'.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //  try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            if(!empty($request->faculty) || $request->faculty != null){
                $data['selected_faculty'] = $faculty = $request->faculty;
            }
            else{
                $data['selected_faculty'] = '0';
            }
    
            if(!empty($request->session) || $request->session != null){
                $data['selected_session'] = $session = $request->session;
            }
            else{
                $data['selected_session'] = '0';
            }
    
            if(!empty($request->program) || $request->program != null){
                $data['selected_program'] = $program = $request->program;
            }
            else{
                $data['selected_program'] = '0';
            }
    
            if(!empty($request->semester) || $request->semester != null){
                $data['selected_semester'] = $semester = $request->semester;
            }
            else{
                $data['selected_semester'] = '0';
            }
    
            if(!empty($request->section) || $request->section != null){
                $data['selected_section'] = $section = $request->section;
            }
            else{
                $data['selected_section'] = '0';
            }
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
    
    
            // Filter Student
            if(isset($request->faculty) || isset($request->program)){
                $enrolls = StudentEnroll::where('status', '1');
    
                if(!empty($request->faculty) && $request->faculty != '0'){
                    $enrolls->with('program')->whereHas('program', function ($query) use ($faculty){
                        $query->where('faculty_id', $faculty);
                    });
                }
                if(!empty($request->program) && $request->program != '0'){
                    $enrolls->where('program_id', $program);
                }
                if(!empty($request->session) && $request->session != '0'){
                    $enrolls->where('session_id', $session);
                }
                if(!empty($request->semester) && $request->semester != '0'){
                    $enrolls->where('semester_id', $semester);
                }
                if(!empty($request->section) && $request->section != '0'){
                    $enrolls->where('section_id', $section);
                }
                
                $enrolls->with('student')->whereHas('student', function ($query){
                    $query->where('status', '1');
                    $query->orderBy('student_id', 'asc');
                });
                
                $enrolls = StudentEnroll::where('status', '1');
                $data['rows'] = $enrolls->get();
            }
            return view($this->view.'.create', $data);
        // } catch(\Exception $e){

        //     Toastr::error(__('msg_error'));

        //     return redirect()->back();
        // } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        if(isset($request->roll_no)){
            $student = Student::where('roll_no',$request->roll_no)->first();
            if(!$student){
                Toastr::error(__('Student Not Found'), __('msg_error'));
                return redirect()->route($this->route.'.index');
            }else{
                $task = new HostelAttendance;
                $task->student_id  = $student->id;
                $task->direction = 1;
                $task->note = $request->note;
                $task->date = now()->format('Y-m-d');
                $task->save();
            }
        }else{
            $request->validate([
                'student_ids' => 'required',
                'date' => 'required|date|before_or_equal:today',
                'note' => 'required',
                'direction' => 'required',
            ]);
            // Insert Data
            if($request->direction == null || $request->direction != 1){
                $direction = 0;
            }
            else {
                $direction = 1;
            }
            $student_ids = array_map(function($arr) {
                return intval($arr);
                },explode(',',$request->student_ids));
        
            foreach ($student_ids as $key => $student_id) {
                $task = new HostelAttendance;
                $task->student_id  = $student_id;
                $task->direction = $request->direction;
                $task->note = $request->note;
                $task->date = $request->date;
                $task->save();
            }
        }
        
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HostelAttendance  $hostelAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(HostelAttendance $hostelAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HostelAttendance  $hostelAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(HostelAttendance $hostelAttendance)
    {
        try {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['row'] = $hostelAttendance;
        return view($this->view.'.edit', $data);
    } catch(\Exception $e){

        Toastr::error(__('msg_error'));

        return redirect()->back();
    } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HostelAttendance  $hostelAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HostelAttendance $hostelAttendance)
    {
        //
        try {
            if(!$request->has('direction')){
                $hostelAttendance->direction = 0;
            }else{
                $hostelAttendance->direction = $request->direction;
            }
            $hostelAttendance->date = $request->date;
            $hostelAttendance->note = $request->note;
            $hostelAttendance->save();
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/hostel-attendance')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HostelAttendance  $hostelAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(HostelAttendance $hostelAttendance)
    {

        try{
            if ($hostelAttendance) {
                $hostelAttendance->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
