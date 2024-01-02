<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\StudentEnroll;
use App\Models\Session;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\StatusType;
use App\Models\Province;
use App\Models\Batch;
use App\Models\Semester;
use App\Models\Sports;
use App\Models\FitnessStudent;
use Illuminate\Http\Request;
use App\Models\AchievementCategory;
use App\Models\StudentAchievement;
use Toastr;

class FitnessStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_fitness_student', 1);
         $this->route = 'admin.fitness-student';
         $this->view = 'admin.fitness-student';
         $this->path = 'fitness-student';
         $this->access = 'fitness-student';
 
 
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
             $fitnessStudent = FitnessStudent::query();
 
 
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
             $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
             }
 
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
             
             $data['rows'] = $fitnessStudent->latest()->get();
             $data['achievement_categories'] = AchievementCategory::orderBy('name', 'asc')->get();
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
 
         $data['achievement_categories'] = AchievementCategory::select('id','name')->orderBy('name', 'asc')->get();
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
         $data['achievement_categories'] = AchievementCategory::select('id','name')->orderBy('name', 'asc')->get();
 
 
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
             $data['sports'] = Sports::get();
             $enrolls = StudentEnroll::where('status', '1');
 
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
         // return $request->all();
         $request->validate([
            'student_id' => 'required',
         ]);
        //  dd($request->student_id);
        // Insert Data
        foreach($request->student_id as $student){
            $recordExist = FitnessStudent::where('student_id',$student)->first();
            if(!$recordExist){
                $fitnessStudent = new FitnessStudent;
                $fitnessStudent->student_id = $student;
                $fitnessStudent->payload = $request->payload;
                $fitnessStudent->sports_ids = $request->sports_ids;
                $fitnessStudent->save();
            }
        }
 
         Toastr::success(__('msg_created_successfully'), __('msg_success'));
 
         return redirect()->route($this->route.'.index');
     }
    
 
     /**
      * Display the specified resource.
      *
      * @param  \App\Models\FitnessStudent  $FitnessStudent
      * @return \Illuminate\Http\Response
      */
     public function show(FitnessStudent $FitnessStudent)
     {
         //
     }
 
     /**
      * Show the form for editing the specified resource.
      *
      * @param  \App\Models\FitnessStudent  $FitnessStudent
      * @return \Illuminate\Http\Response
      */
     public function edit(FitnessStudent $fitnessStudent)
     {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['sports'] = Sports::get();
        $data['row'] = $fitnessStudent;
                        
        return view($this->view.'.edit', $data);
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\Models\FitnessStudent  $FitnessStudent
      * @return \Illuminate\Http\Response
      */
 
     public function update(Request $request, FitnessStudent $fitnessStudent)
     {
         try{
                 // Field Validation
             $request->validate([
             ]);
 
             // Update Data
             $fitnessStudent->payload = $request->payload;
             $fitnessStudent->sports_ids = $request->sports_ids;
             $fitnessStudent->save(); 
             Toastr::success(__('msg_updated_successfully'), __('msg_success'));
             return redirect()->route($this->route.'.index');
         }
         catch(\Exception $e){
 
             Toastr::error(__('msg_updated_error'), __('msg_error'));
 
             return redirect()->back();
         }  
 
     }
 
     /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Models\FitnessStudent  $FitnessStudent
      * @return \Illuminate\Http\Response
      */
     public function destroy(FitnessStudent $fitnessStudent)
     {
         try{
             if($fitnessStudent){
                 $fitnessStudent->delete();
             }
             
             Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
             return redirect()->back();
         }catch(\Exception $e){
 
             Toastr::error(__('msg_deleted_fail'), __('msg_error'));
 
             return redirect()->back();
         }
     }
}
