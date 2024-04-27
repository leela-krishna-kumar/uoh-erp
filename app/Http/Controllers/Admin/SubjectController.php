<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Regulation;
use App\User;
use App\Models\StudentGroup;
use App\Models\Faculty;
use Toastr;
use DB;

class SubjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_subject', 1);
        $this->route = 'admin.subject';
        $this->lesson_route = 'admin.chapter';
        $this->view = 'admin.subject';
        $this->path = 'subject';
        $this->access = 'subject';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['lesson_route'] = $this->lesson_route;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        if(!empty($request->faculty) || $request->faculty != null){
            $data['selected_faculty'] = $faculty = $request->faculty;
        }
        else{
            $data['selected_faculty'] = '0';
        }

        if(!empty($request->program) || $request->program != null){
            $data['selected_program'] = $program = $request->program;
        }
        else{
            $data['selected_program'] = '0';
        }

        if(!empty($request->subject_type) || $request->subject_type != null){
            $data['selected_subject_type'] = $subject_type = $request->subject_type;
        }
        else{
            $data['selected_subject_type'] = Null;
        }

        if(!empty($request->class_type) || $request->class_type != null){
            $data['selected_class_type'] = $class_type = $request->class_type;
        }
        else{
            $data['selected_class_type'] = Null;
        }
        if(!empty($request->regulation_ids) || $request->regulation_ids != null){
            $data['selected_regulation_ids'] = $regulation_ids = $request->regulation_ids;
        }
        else{
            $data['selected_regulation_ids'] = '0';
        }

        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['regulations'] =Regulation ::orderBy('name', 'asc')->get();

        if(auth()->user()->hasRole('HoD'))
        {           
            $program_ids = json_decode(auth()->user()->program_ids);       
            $data['programs'] = Program::where('faculty_id', $request->faculty)
                                ->whereIn('id', $program_ids)->where('status', '1')->orderBy('title', 'asc')->get();
        }
        else
        {
            $data['programs'] = Program::where('faculty_id', $request->faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        }


        // if(!empty($request->faculty) || $request->faculty != '0'){
        //     $program_ids = json_decode(auth()->user()->program_ids);
            
        // $data['programs'] = Program::where('faculty_id', $request->faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        // }



        // Subject Search
        $subject = Subject::where('id', '!=', null);

        if(!empty($request->faculty) && $request->faculty != '0'){
            $subject->with('programs.faculty')->whereHas('programs.faculty', function ($query) use ($faculty){
                $query->where('id', $faculty);
            });
        }
        if(!empty($request->program) && $request->program != '0'){
            $subject->with('programs')->whereHas('programs', function ($query) use ($program){
                $query->where('id', $program);
            });
        }
        if(!empty($request->subject_type)){
            if($subject_type == 2){
                $subject_type = 0;
            }
            $subject->where('subject_type', $subject_type);
        }
        if(!empty($request->class_type)){
            $subject->where('class_type', $class_type);
        }
        if (!empty($request->regulation_ids)) {
            $subject->where(function ($query) use ($regulation_ids) {
                foreach ($regulation_ids as $id) {
                    $query->orWhereJsonContains('regulation_ids', $id);
                }
            });
        }
        $data['rows'] = $subject->orderBy('title', 'asc')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['regulations'] =Regulation ::orderBy('name', 'asc')->get();
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['studentGroup'] = StudentGroup::select('id','name')->get();

        $teachers = User::where('status', '1');
        $teachers->with('roles')->whereHas('roles', function ($query){
            $query->where('slug', 'faculty');
        });
        $data['teachers'] = $teachers->orderBy('staff_id', 'asc')->select('id', 'staff_id', 'first_name', 'last_name')->get();

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
        // Field Validation
        $request->validate([
            'title' => 'required|max:191|unique:subjects,title',
            'code' => 'required|max:191|unique:subjects,code',
            'credit_hour' => 'required',
            'subject_type' => 'required',
            'class_type' => 'required',
        ]);

        DB::beginTransaction();
        // Insert Data
        $subject = new Subject;
        $subject->title = $request->title;
        $subject->regulation_ids = $request->regulation_ids;
        $subject->code = $request->code;
        $subject->credit_hour = $request->credit_hour;
        $subject->subject_type = $request->subject_type;
        $subject->class_type = $request->class_type;
        $subject->total_marks = $request->total_marks;
        $subject->passing_marks = $request->passing_marks;
        $subject->description = $request->description;
        $subject->managed_by = json_encode($request->managed_by);
        $subject->group_id = $request->group_id;
        $subject->save();

        // Attach
        $subject->programs()->attach($request->programs);
        DB::commit();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $subject;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $subject;
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['regulations'] =Regulation ::orderBy('name', 'asc')->get();
        $teachers = User::where('status', '1');
        $teachers->with('roles')->whereHas('roles', function ($query){
            $query->where('slug', 'faculty');
        });
        $data['teachers'] = $teachers->orderBy('staff_id', 'asc')->select('id', 'staff_id', 'first_name', 'last_name')->get();
        $data['studentGroup'] = StudentGroup::select('id','name')->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        // Field Validation
        $request->validate([
            // 'title' => 'required|max:191|unique:subjects,title,'.$subject->id,
            'code' => 'required|max:191|unique:subjects,code,'.$subject->id,
            'credit_hour' => 'required',
            'subject_type' => 'required',
            'class_type' => 'required',
        ]);

        // $managed_by = array_map(function($arr) {
        //     return intval($arr);
        // }, $request->managed_by);
        DB::beginTransaction();
        // Update Data
        $subject->title = $request->title;
        $subject->code = $request->code;
        $subject->regulation_ids = $request->regulation_ids;
        $subject->credit_hour = $request->credit_hour;
        $subject->subject_type = $request->subject_type;
        $subject->class_type = $request->class_type;
        $subject->total_marks = $request->total_marks;
        $subject->passing_marks = $request->passing_marks;
        $subject->description = $request->description;
        $subject->status = $request->status;
        $subject->managed_by = $request->managed_by;
        $subject->group_id = $request->group_id;
        $subject->save();

        // Attach Update
        $subject->programs()->sync($request->programs);
        DB::commit();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if($subject->regulations){
            Toastr::error(__('msg_cant_deleted'), __('msg_error'));
            return redirect()->back();
        }else{
            DB::beginTransaction();
            // Detach
            $subject->programs()->detach();

            // Delete Data
            $subject->delete();
            DB::commit();
        }

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
