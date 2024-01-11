<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestPaperQuestion;
use App\Models\TestPaper;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Semester;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Toastr;

class TestPaperQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_test_paper_questions', 1);
        $this->route = 'admin.test-paper-question';
        $this->view = 'admin.test-paper-questions';
        $this->path = 'test-paper-question';
        $this->access = 'test-paper-question';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request, $id)
    {
        try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $testPaperQuestions = TestPaperQuestion::query();

            if(request()->has('subject_id') && request()->get('subject_id') != null) {
                $testPaperQuestions->where('subject_id',request()->get('subject_id'));
            }
            
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
            if(!empty($request->subject) || $request->subject != null){
                $data['selected_subject'] = $subject = $request->subject;
            }
            else{
                $data['selected_subject'] = $subject = '0';
            }

            $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

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
            $data['sections'] = $sections->orderBy('title', 'asc')->get();
            }

            $data['subjects'] = Subject::select('id','title')->get();
            $data['testPaper'] = TestPaper::where('id',$id)->first();
            
            $data['rows'] = $testPaperQuestions->where('testpaper_id',$id)->latest()->get();

            $question_bank_ids = $testPaperQuestions->where('testpaper_id',$id)->pluck('question_bank_id')->toArray();

            $data['questions'] = QuestionBank::where('status',1)->whereNotIn('id',$question_bank_ids)->get();

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
       // dd($request->all());


        if($request->type == 'manual'){
            $request->validate([
                'question_bank_id' => 'required',
            ]);
            $question = QuestionBank::where('id',$request->question_bank_id)->first();
            //Insert Data
            $testPaperQuestion = new TestPaperQuestion;
            $testPaperQuestion->question_bank_id = $request->question_bank_id;
            $testPaperQuestion->testpaper_id = $request->testpaper_id;
            $testPaperQuestion->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
        }else{
            $request->validate([
                'subject_id' => 'required',
            ]);
            if($request->has('no_of_questions') && $request->get('no_of_questions') != null){
                $count  = $request->no_of_questions;
            }
            $arr_questions = [];

        
            foreach($request->no_of_questions as $key => $no_of_questions){

              //  dd($key);
            

                $arr_questions []= QuestionBank::where('subject_id',$request->subject_id)->where('level',$key)->limit($no_of_questions)->get();
           
            }
          //  dd( $arr_questions);

            foreach($arr_questions as $questions){
                foreach($questions as $question){
                    if(!empty($question)){
                        $testPaperQuestion = new TestPaperQuestion;
                        $testPaperQuestion->question_bank_id = $question->id;
                        $testPaperQuestion->testpaper_id = $request->testpaper_id;
                        $testPaperQuestion->save();
                    }
                }
            }

        
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
        }
        
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestPaperQuestion  $testPaperQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(TestPaperQuestion $testPaperQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestPaperQuestion  $testPaperQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(TestPaperQuestion $testPaperQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestPaperQuestion  $testPaperQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestPaperQuestion $testPaperQuestion,$id)
    {
        try{
            // Field Validation
            $request->validate([
                'question_bank_id' => 'required',
            ]);
            $testPaperQuestion = TestPaperQuestion::where('id',$id)->first();
            // Update Data
            $testPaperQuestion->testpaper_id = $request->testpaper_id;
            $testPaperQuestion->question_bank_id = $request->question_bank_id;
            $testPaperQuestion->save();
            
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
     * @param  \App\Models\TestPaperQuestion  $testPaperQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestPaperQuestion $testPaperQuestion,$id)
    {
        try{
            $testPaperQuestion = TestPaperQuestion::where('id',$id)->first();
            if($testPaperQuestion){
                $testPaperQuestion->delete();
            }
            
            // Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
