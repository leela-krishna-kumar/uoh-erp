<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\StudentReport;
use App\Models\StudentReportCategory;
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

class StudentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_student_report', 1);
        $this->route = 'admin.student-report';
        $this->view = 'admin.student-report';
        $this->path = 'student-report';
        $this->access = 'student-report';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $studentReport = StudentReport::query();


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
            $data['student_report_categories'] = StudentReportCategory::get();
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
                $enrolls = $studentReport;

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




            if(!empty($request->category) || $request->category != null){
                $data['selected_category'] = $category = $request->category;
            }
            else{
                $data['selected_category'] = $category_id = '0';
            }

           $data['student_report_categories'] = StudentReportCategory::orderBy('name', 'asc')->get();

                    if(!empty($request->category) || $request->category != null){
                        $rows->where('category_id', $category);
                    }
        //    $data['rows'] = $studentReport->orderBy('id', 'desc')->get();

           $data['rows'] = $studentReport->select('id','student_id','program_id','session_id','semester_id','section_id','category_id','reason','date','created_by')->orderBy('id', 'desc')->get();

           return view($this->view.'.index', $data);
        // } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        // }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
            $data['student_report_categories'] = StudentReportCategory::get();
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

                $data['rows'] = $enrolls->get();
            }

            return view($this->view.'.create', $data);

        } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        }
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

         // Insert Data
         $studentReport = new StudentReport;
         $studentReport->student_id = $request->student_id;
         $studentReport->note = $request->note;
         $studentReport->reason = $request->reason;
         $studentReport->date = $request->date;
         $studentReport->category_id = $request->category_id;
         $studentReport->faculty_id = $request->faculty;
         $studentReport->program_id = $request->program;
         $studentReport->session_id = $request->session;
         $studentReport->semester_id = $request->semester;
         $studentReport->section_id = $request->section;

         $studentReport->created_by = auth()->id();
         $studentReport->save();
         Toastr::success(__('msg_created_successfully'), __('msg_success'));

         return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentReport  $studentReport
     * @return \Illuminate\Http\Response
     */
    public function show(StudentReport $studentReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentReport  $studentReport
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentReport $studentReport)
    {
        $data['title'] = $this->title;
       $data['route'] = $this->route;
       $data['view'] = $this->view;
       $data['path'] = $this->path;
       $data['students'] = Student::get();
       $data['row'] = $studentReport;
       $data['student_report_categories'] = StudentReportCategory::get();
       return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentReport  $studentReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentReport $studentReport)
    {
            // try{

                // return $request->all();
                // Field Validation
                $request->validate([

            ]);
            $studentReport->note = $request->note;
            $studentReport->reason = $request->reason;
            $studentReport->category_id = $request->category_id;
            $studentReport->date = $request->date;
            $studentReport->created_by = auth()->id();
            $studentReport->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect('admin/student-report')->with( __('msg_success'), __('msg_updated_successfully'));
        // }
        // catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentReport  $studentReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentReport $studentReport)
    {
        try{
            if($studentReport){
                $studentReport->delete();
            }

            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
