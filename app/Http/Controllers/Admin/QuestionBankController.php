<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionBank;
use App\Models\Subject;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\StatusType;
use App\Models\Province;
use App\Models\Batch;
use App\Models\Semester;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Toastr;

class QuestionBankController extends Controller
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
        $this->title = trans_choice('module_question_bank', 1);
        $this->route = 'admin.question-bank';
        $this->view = 'admin.question-bank';
        $this->path = 'question-bank';
        $this->access = 'question-bank';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index( Request $request)
    {     
        // try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $questionBanks = QuestionBank::query();
            if(request()->has('status') && request()->get('status') != null) {
                $questionBanks->where('status',request()->get('status'));
            }
            
            if(request()->has('subject') && request()->get('subject') != null) {
                $questionBanks->where('subject_id',request()->get('subject'));
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

            if(!empty($request->subject) || $request->subject != null){
                $data['selected_subject'] = $subject = $request->subject;
            }
            else{
                $data['selected_subject'] = $subject = '0';
            }
    
            
            // Search Filter
            $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
            $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();


            if(!empty($request->faculty) && $request->faculty != '0'){
            $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
            }

            if(!empty($request->program) && $request->program != '0' && !empty($request->faculty) && $request->faculty != '0'){
                
            $subjects = Subject::where('status', 1);
            $data['subjects'] = $subjects->orderBy('title', 'asc')->select('id','title','code')->get();}

            if(!empty($request->subject) && $request->subject != '0' && !empty($request->program) && $request->program != '0' && !empty($request->faculty) && $request->faculty != '0'){
               $data['rows'] = $questionBanks->latest()->get();
            }else{
                $data['rows'] = [];
            }

          //  dd($data['rows']);

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
            $data['statuses'] = QuestionBank::STATUSES;
            $data['subjects'] = Subject::select('id','title')->where('status',1)->get();
            $data['questionTypes'] = QuestionBank::QUESTION_TYPES;
            $data['subject'] = Subject::where('id',$request->subject)->first();
            return view($this->view.'.create', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_created_successfully'), __('msg_error'));

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
        //  dd($request->all());

        if($request->correct_options == null || (is_array($request->correct_options) && count($request->correct_options) == 0)){
            Toastr::error('Please select correct option(s)', __('msg_error'));

            return redirect()->back();
        }

            $request->validate([
                'subject_id' => 'required',
                'info' => 'required',
             //   'options' => 'required',
            ]);

            // Insert Data
            $questionBank = new QuestionBank;
            $questionBank->subject_id = $request->subject_id;
            $questionBank->level = $request->level;
            $questionBank->question = $request->info;
            $questionBank->options = $request->options;
            if($request->type == 'multi' || $request->type == 'single' || $request->type == 'blank'){
                $questionBank->correct_options = $request->correct_options;
            }else{
                $questionBank->options = ["true", "false"];
                $questionBank->correct_options = $request->correct_options;
            }
            $questionBank->type = $request->type;
            $questionBank->created_by = auth()->id();
            $questionBank->status = $request->status;
            $questionBank->save();

          //  dd();
            
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionBank  $questionBank
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionBank $questionBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionBank  $questionBank
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionBank $questionBank)
    {
        // try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = QuestionBank::STATUSES;
            $data['subject'] = Subject::select('id','title')->where('id',$questionBank->subject_id)->first();
            $data['questionTypes'] = QuestionBank::QUESTION_TYPES;
            $data['row'] = $questionBank;
            $data['options'] = $data['row']->options;

          //  dd( $data['row']);

            return view($this->view.'.edit', $data);

           

        // } catch(\Exception $e){

        //     Toastr::error(__('msg_updated_successfully'), __('msg_error'));

        //     return redirect()->back();
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionBank  $questionBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionBank $questionBank)
    {
        try{
            // Field Validation
            $request->validate([
                'question' => 'required',
            ]);

            if($request->correct_options == null || count($request->correct_options) == 0){
                Toastr::error('Please select correct option(s)', __('msg_error'));
    
                return redirect()->back();
            }
            
            $questionBank->subject_id = $questionBank->subject_id;
            $questionBank->question = $request->question;

            if($request->type == 'multi' || $request->type == 'single' || $request->type == 'blank'){
                $questionBank->correct_options = $request->correct_options;
            }else{
                $questionBank->options = ["true", "false"];
                $questionBank->correct_options = $request->correct_options;
                // $questionBank->correct_options = $request->options;
            }
            $questionBank->options = $request->options;
            $questionBank->correct_options = $request->correct_options;
            $questionBank->level = $request->level;
            $questionBank->created_by = auth()->id();
            $questionBank->status = $request->status;
            $questionBank->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect('admin/question-bank')->with( __('msg_success'), __('msg_updated_successfully'));

        }catch(\Exception $e){
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionBank  $questionBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionBank $questionBank)
    {
        try{
            if($questionBank){
                $questionBank->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){
            Toastr::error(__('msg_deleted_fail'), __('msg_error'));
            return redirect()->back();
        }
    }
    public function getQOption(Request $request)
    {
        $count = $request->total_option;
        $html = null;
        for ($i=1; $i <= $count; $i++){
            if($request->question_type == 'multi'){
                $html .= '<div class="form-group col-md-12"><label for="checkbox-'.$i.'">Option '.$i.'<span>*</span></label><div class="d-flex"><input type="text" class="form-control" name="options[]" id="checkbox-'.$i.'" value=""><span class="input-group-addon"><input id="ans_1-'.$i.'" type="checkbox" name="correct_options[]" value="'.$i.'"></span></div></div>';
            }elseif($request->question_type == 'single'){
                $html .= '<div class="form-group col-md-12"><label for="radio-'.$i.'">Option '.$i.'<span>*</span></label><div class="d-flex correct-option"><input type="text" class="form-control" name="options[]" id="radio-'.$i.'" value=""><span class="input-group-addon"><input id="ans_1-'.$i.'" type="radio" name="correct_options" class=""value="'.$i.'" required></span></div></div>';
            }elseif($request->question_type == 'blank'){
                $html .= '<div class="form-group col-md-12"><label for="radio-'.$i.'">Option '.$i.'<span>*</span></label><div class="d-flex correct-option"><input type="text" class="form-control" name="options[]" id="radio-'.$i.'" value=""><span class="input-group-addon"><input id="ans_1-'.$i.'" type="radio" name="correct_options" class=""value="'.$i.'" required></span></div></div>';
            }else{
                $html == null;
            }
        }
        return response($html);
    }

    public function ckeditorUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $this->uploadImage($request, 'upload', $this->path, 300, 300);
      
            $request->file('upload')->move(public_path('media'), $fileName);
      
            $url = asset('media/' . $fileName);
  
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }
    
}
