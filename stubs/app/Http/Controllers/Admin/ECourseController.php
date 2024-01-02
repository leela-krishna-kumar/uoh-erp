<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Traits\FileUploader;
use App\Models\ECourse;
use App\Models\StudentEnroll;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\StatusType;
use App\Models\Province;
use App\Models\Batch;
use App\Models\Semester;
use Illuminate\Http\Request;
use Toastr;



class ECourseController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
     
         $this->title = trans_choice('module_ecourses', 1);
         $this->route = 'admin.ecourse';
         $this->view = 'admin.ecourse';
         $this->path = 'ecourse';
         $this->access = 'ecourse';
       
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);


     }
 
    public function index()
    {
       
       try{  
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $ecourse = ECourse::query();
        $data['rows'] = $ecourse->orderBy('id', 'desc')->latest()->get();
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
        // $data['project_categories'] = ProjectCategory::get();


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
        try{
            $ecourse = new ECourse;
            $ecourse->title = $request->title;
            $ecourse->semester_id = $request->semester_id;
            if($request->image){
                $ecourse->image = $this->uploadImage($request, 'image', $this->path, 300, 300);
            }
            $ecourse->description = $request->description;
            if(!$request->has('is_published')){
                $ecourse->is_published = 0;
            }else{
                $ecourse->is_published = $request->is_published;
            }
            $ecourse->created_by = auth()->id();
            $ecourse->duration = $request->duration;
            $ecourse->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.index');
        } catch(\Exception $e){

            Toastr::error( __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ECourse  $ecourse
     * @return \Illuminate\Http\Response
     */
    public function show(ECourse $ecourse)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ECourse  $ecourse
     * @return \Illuminate\Http\Response
     */
    public function edit(ECourse $ecourse, Request $request)
    {


        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['semesters'] = Semester::get();
            $data['row'] = $ecourse;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error( __('msg_error'));

            return redirect()->back();
        }
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ECourse  $ecourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ECourse $ecourse)
    {
        $request->validate([
            // 'semester_id' => 'required',
        ]);
        if(!$request->has('is_published')){
            $request['is_published'] = 0;
        }
         // Update Data
        $ecourse->title = $request->title;
        $ecourse->semester_id = $ecourse->semester_id;
        $ecourse->image = $this->updateImage($request, 'image', $this->path, 300, 300, $ecourse, 'image');
        $ecourse->description = $request->description;
        $ecourse->is_published = $request->is_published;
        $ecourse->created_by = auth()->id();
        $ecourse->duration = $request->duration;
        $ecourse->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ECourse  $ecourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(ECourse $ecourse)
    {
        //
        try{
            $ecourse;
            if ($ecourse) {
                 $ecourse->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
