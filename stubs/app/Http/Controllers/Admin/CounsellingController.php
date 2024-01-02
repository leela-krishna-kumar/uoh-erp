<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counselling;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\Faculty;
use App\Models\StatusType;
use App\Models\Batch;
use App\Models\Semester;
use App\User;
use App\Models\CounsellingCategory;
use Illuminate\Http\Request;
use Toastr;

class CounsellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_counselling', 1);
        $this->route = 'admin.counselling';
        $this->view = 'admin.counselling';
        $this->path = 'counselling';
        $this->access = 'counselling';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        try{  
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
    
            if(!empty($request->status) || $request->status != null){
                $data['selected_status'] = $status = $request->status;
            }
            else{
                $data['selected_status'] = '0';
            }


            // Search Filter
            $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
            $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();


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

            $counsellings = Counselling::query();

            if(request()->has('counselling_category_id') && request()->get('counselling_category_id') != null) {
                $counsellings->where('counselling_category_id',request()->get('counselling_category_id'));
            }

            $data['categories'] = CounsellingCategory::select('id','name')->orderBy('name', 'asc')->get();
            $data['rows'] = $counsellings->get();
            return view($this->view.'.index', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
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

        $data['statuses'] = Counselling::STATUSES;
        $role = 6;
        $users = User::where('id', '!=', null);
        $managers =  $users->with('roles')->whereHas('roles', function ($query) use ($role){
            $query->where('role_id', $role);
        });
        $data['managers'] = $managers->get();
        $data['counselling_categories'] = CounsellingCategory::select('id','name')->orderBy('name', 'asc')->get();
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


        // Filter Search
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['counselling_categories'] = CounsellingCategory::select('id','name')->orderBy('name', 'asc')->get();


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

            $data['rows'] = $enrolls->get();
        }

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'manager_ids' => 'required',
            'faculty' => 'required',
            'program' => 'required',
            'session' => 'required',
            'semester' => 'required',
            'section' => 'required',
            'counselling_category_id' => 'required',
            'student_id' => 'required',
        ]);
        // Insert Data
        $counselling = new Counselling;
        $counselling->manager_ids = $request->manager_ids;
        $counselling->faculty_id = $request->faculty;
        $counselling->program_id = $request->program;
        $counselling->session_id = $request->session;
        $counselling->semester_id = $request->semester;
        $counselling->section_id = $request->section;
        $counselling->date = $request->date;
        $counselling->time = $request->time;
        $counselling->counselling_category_id = $request->counselling_category_id;
        $counselling->type = Student::class;
        $counselling->type_id = $request->student_id;
        $counselling->status = $request->status;
        $counselling->note = $request->note;
        $counselling->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Counselling $counselling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Counselling $counselling)
    {
       //
       $data['title'] = $this->title;
       $data['route'] = $this->route;
       $data['view'] = $this->view;
       $data['path'] = $this->path;
       $data['row'] = $counselling;
       $data['statuses'] = Counselling::STATUSES;
       $role = 6;
        $users = User::where('id', '!=', null);
        $managers =  $users->with('roles')->whereHas('roles', function ($query) use ($role){
            $query->where('role_id', $role);
        });
        $data['managers'] = $users->get();
        $data['counselling_categories'] = CounsellingCategory::select('id','name')->orderBy('name', 'asc')->get();

       return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Counselling $counselling)
    {
        try{
                // Field Validation
            $request->validate([
                'manager_ids' => 'required',
            ]);
            
            // Update Data
            $counselling->manager_ids = $request->manager_ids;
            $counselling->date = $request->date;
            $counselling->time = $request->time;
            $counselling->counselling_category_id = $request->counselling_category_id;
            $counselling->type = App\Models\Student::class;
            $counselling->type_id = auth()->id();
            $counselling->status = $request->status;
            $counselling->note = $request->note;
            $counselling->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counselling $counselling)
    {
        try{
            if($counselling){
                $counselling->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
