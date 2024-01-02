<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestPaper;
use App\Models\Subject;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Batch;
use App\Models\Semester;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Toastr;

class TestPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_test_paper', 1);
        $this->route = 'admin.test-paper';
        $this->view = 'admin.test-paper';
        $this->path = 'test-paper';
        $this->access = 'test-paper';


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
            $testPapers = TestPaper::query();

            if(request()->has('subject_id') && request()->get('subject_id') != null) {
                $testPapers->where('subject_id',request()->get('subject_id'));
            }
            $data['subjects'] = Subject::select('id','title')->where('status',1)->get();
            $data['rows'] = $testPapers->latest()->get();

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
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;

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
            $data['subjects'] = Subject::select('id','title')->where('status',1)->get();
            return view($this->view.'.create', $data);
        } catch(\Exception $e){

        //     Toastr::error(__('msg_created_successfully'), __('msg_error'));

        //     return redirect()->back();
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
        // try{
            // dd($request->all());
            // Field Validation
            $request->validate([
                'title' => 'required',
                'started_from' => 'required',
                'disclaimer' => 'required',
                'duration' => 'required',
            ]);

            $existRecord = TestPaper::where('title',$request->title)->first();
            if($existRecord){
                Toastr::error(__('msg_title_already_exists'), __('msg_error'));
                return redirect()->back();
            }
            // Insert Data
            $testPaper = new TestPaper;
            $testPaper->title = $request->title;
            $testPaper->started_from = $request->started_from;
            $testPaper->end_date = $request->end_date;
            $testPaper->duration = $request->duration;
            $testPaper->disclaimer = $request->disclaimer;
            $testPaper->type = $request->type;
            $testPaper->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->back();
        // } catch(\Exception $e){

        //     Toastr::error(__('msg_updated_error'), __('msg_error'));

        //     return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestPaper  $testPaper
     * @return \Illuminate\Http\Response
     */
    public function show(TestPaper $testPaper)
    {
        $data['title'] = $this->title;
        $data['testPaper'] = $testPaper;
        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestPaper  $testPaper
     * @return \Illuminate\Http\Response
     */
    public function edit(TestPaper $testPaper)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = QuestionBank::STATUSES;
            $data['subjects'] = Subject::select('id','title')->where('status',1)->get();
            $data['questionTypes'] = QuestionBank::QUESTION_TYPES;
            $data['row'] = $testPaper;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_successfully'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestPaper  $testPaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestPaper $testPaper)
    {
        try{
            // Field Validation
              $request->validate([
                'name' => 'required|max:191|unique:test_papers,title,'.$testPaper->id,
                'started_from' => 'required',
                'duration' => 'required',
            ]);
            $testPaper->title = $request->name;
            $testPaper->end_date = $request->end_date;
            $testPaper->started_from = $request->started_from;
            $testPaper->type = $request->type;
            $testPaper->duration = $request->duration;
            $testPaper->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));

        }catch(\Exception $e){
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestPaper  $testPaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestPaper $testPaper)
    {
        try{
            if($testPaper){
                $testPaper->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
