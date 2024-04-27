<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Section;
use App\Models\Faculty;
use App\Models\Income;
use App\Models\IncomeCategory;
use Carbon\Carbon;
use Toastr;
use App\Traits\FileUploader;

class ExamFeeController extends Controller
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
         $this->title = trans_choice('module_bulk_income', 1);
         $this->route = 'admin.exam-fee';
         $this->view = 'admin.exam-fee';
         $this->path = 'exam-fee';
         $this->access = 'income';


         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
     }


    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;


        if(!empty($request->category) || $request->category != null){
            $data['selected_category'] = $category = $request->category;
        }
        else{
            $data['selected_category'] = $category = '0';
        }

        if(!empty($request->start_date) || $request->start_date != null){
            $data['selected_start_date'] = $start_date = $request->start_date;
        }
        else{
            $data['selected_start_date'] = $start_date = date('Y-m-d', strtotime(Carbon::now()->subYear()));
        }

        if(!empty($request->end_date) || $request->end_date != null){
            $data['selected_end_date'] = $end_date = $request->end_date;
        }
        else{
            $data['selected_end_date'] = $end_date = date('Y-m-d', strtotime(Carbon::today()));
        }


        // Search Filter
        $data['categories'] = IncomeCategory::where('status','1')
                            ->orderBy('title', 'asc')->get();
        $rows = Income::query();
       $data['rows'] = $rows->where('type',Student::class)->orderBy('id', 'desc')->get();

        return view($this->view.'.index', $data);
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
        $data['payment_statuses'] = Income::STATUSES;

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
            $data['categories'] = IncomeCategory::where('status',1)->get();
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
        // Field Validation
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date|before_or_equal:today',
        ]);
        $student_ids = array_map(function($arr) {
            return intval($arr);
        },explode(',',$request->students));
        // Insert Data
        // return $request->all();
        foreach ($student_ids as $key => $student_id) {
            $income = new Income;
            $income->type = Student::class;
            $income->type_id = $student_id;
            $income->title = $request->title;
            $income->category_id = $request->category_id;
            $income->amount = $request->amount;
            $income->date = $request->date;
            $income->note = $request->note;
            $income->payment_status = $request->payment_status;
            $income->payment_method = $request->payment_method;
            $income->created_by = auth()->id();
            $income->save();
        }


        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['payment_statuses'] = Income::STATUSES;
        $data['row'] = $income;
        $data['categories'] = IncomeCategory::where('status', '1')
                            ->orderBy('title', 'asc')->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Income $income)
    {
        // Field Validation
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date|before_or_equal:today',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);


        // Update Data
        $income->category_id = $request->category;
        $income->title = $request->title;
        $income->invoice_id = $request->invoice_id;
        $income->amount = $request->amount;
        $income->date = $request->date;
        $income->note = $request->note;
        $income->payment_status = $request->payment_status;
        $income->payment_method = $request->payment_method;
        $income->attach = $this->updateMedia($request, 'attach', $this->path, $income);
        $income->status = $request->status;
        $income->updated_by = Auth::guard('web')->user()->id;
        $income->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Income $income)
    {
        // Delete Data
        $this->deleteMedia($this->path, $income);

        $income->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
