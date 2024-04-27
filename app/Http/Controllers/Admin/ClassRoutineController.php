<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoutine;
use Illuminate\Http\Request;
use App\Models\PrintSetting;
use App\Models\ClassRoom;
use App\Models\Semester;
use App\Models\Faculty;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Subject;
use App\User;
use Toastr;
use DB;

class ClassRoutineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_time_table', 1);
        $this->route = 'admin.class-routine';
        $this->view = 'admin.class-routine';
        $this->path = 'class-routine';
        $this->access = 'class-routine';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-print', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store','destroy']]);
        $this->middleware('permission:'.$this->access.'-teacher', ['only' => ['teacher']]);
        $this->middleware('permission:'.$this->access.'-print', ['only' => ['print']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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

        if(!empty($request->program) || $request->program != null){
            $data['selected_program'] = $program = $request->program;
        }
        else{
            $data['selected_program'] = '0';
        }

        if(!empty($request->session) || $request->session != null){
            $data['selected_session'] = $session = $request->session;

            // dd($data['selected_session']);
        }
        else{
            $data['selected_session'] = '0';
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


        $data['print'] = PrintSetting::where('slug', 'class-routine')->first();

        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

        if(!empty($request->faculty) && !empty($request->program) && !empty($request->session) && !empty($request->semester) && !empty($request->section)){
        $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();

        $sessions = Session::where('status', 1);
        $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['sessions'] = $sessions->orderBy('id', 'desc')->get();

        $semesters = Semester::where('status', 1);
        $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['semesters'] = $semesters->orderBy('id', 'asc')->get();
        $sections = Section::where('status', 1);
        $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
            $query->where('program_id', $program);
            $query->where('semester_id', $semester);
        });
        $data['sections'] = $sections->orderBy('title', 'asc')->get();}


        // Routine Filter
        if(!empty($request->program) && !empty($request->session) && !empty($request->semester) && !empty($request->section)){

            if (auth()->user()->roles[0]->name != 'admin' && auth()->user()->roles[0]->name != 'Super Admin') {
                $routines = ClassRoutine::where('status', '1')->where('teacher_id', auth()->id());
            } else {
                $routines = ClassRoutine::where('status', '1');
            }
            

            if(!empty($request->program)){
                $routines->where('program_id', $request->program);
            }
            if(!empty($request->session)){
                $routines->where('session_id', $request->session);
            }
            if(!empty($request->semester)){
                $routines->where('semester_id', $request->semester);
            }
            if(!empty($request->section)){
                $routines->where('section_id', $request->section);
            }
            if(!empty($request->class_type)){
                $subject_ids = Subject::where('class_type', $request->class_type)->pluck('id');
                $routines->whereIn('subject_id', $subject_ids);
            }
            $data['rows'] = $routines->orderBy('start_time', 'asc')->get();   
        }

        // return $data;

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
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

        if(!empty($request->session) || $request->session != null){
            $data['selected_session'] = $session = $request->session;
        }
        else{
            $data['selected_session'] = '0';
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


        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

        if(!empty($request->faculty) && !empty($request->program) && !empty($request->session) && !empty($request->semester) && !empty($request->section))
        {
        $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();

        $sessions = Session::where('status', 1);
        $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['sessions'] = $sessions->orderBy('id', 'desc')->get();

        $semesters = Semester::where('status', 1);
        $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
            $query->where('program_id', $program);
        });
        $data['semesters'] = $semesters->orderBy('id', 'asc')->get();

        $sections = Section::where('status', 1);
        $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
            $query->where('program_id', $program);
            $query->where('semester_id', $semester);
        });
        $data['sections'] = $sections->orderBy('title', 'asc')->get();

        $subjects = Subject::whereIn('status', [0,1]);
        $subjects->with('subjectEnrolls')->whereHas('subjectEnrolls', function ($query) use ($program, $semester, $section){
            $query->where('program_id', $program);
            $query->where('semester_id', $semester);
            $query->where('section_id', $section);
        });
        $data['subjects'] = $subjects->orderBy('code', 'asc')->get();
        }


        $data['rooms'] = ClassRoom::whereIn('status', [1, 0])->orderBy('title', 'asc')->get();

        $teachers = User::where('status', '1');
        $teachers->with('roles')->whereHas('roles', function ($query){
            // $query->where('slug', 'faculty');
        });
        $data['teachers'] = $teachers->orderBy('staff_id', 'asc')->get();


        // Routine Filter
        if(!empty($request->program) && !empty($request->session) && !empty($request->semester) && !empty($request->section)){

            $routines = ClassRoutine::where('status', '1');

            if(!empty($request->program)){
                $routines->where('program_id', $request->program);
            }
            if(!empty($request->session)){
                $routines->where('session_id', $request->session);
            }
            if(!empty($request->semester)){
                $routines->where('semester_id', $request->semester);
            }
            if(!empty($request->section)){
                $routines->where('section_id', $request->section);
            }
            $data['rows'] = $routines->orderBy('start_time', 'asc')->get();   
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
            'session' => 'required',
            'program' => 'required',
            'semester' => 'required',
            'section' => 'required',
            'subject' => 'required',
            'teacher' => 'required',
            'room' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        DB::beginTransaction();

        if($request->subject){
            $data = $request->except('_token');
            $subject_count = count($data['subject']);
            $day = $request->day;
            $program = $request->program;
            $session = $request->session;
            $section = $request->section;
            $semester = $request->semester;

           
            for($j = 0; $j < $subject_count; $j++){
                $start = $data['start_time'][$j];
                $end = $data['end_time'][$j];

                //Teacher Check
                $teacher_check = ClassRoutine::where('teacher_id', $data['teacher'][$j])
                ->where('session_id', $session)
                ->where('start_time', $start)
                ->where('day', $day)
                ->first();

                //Subject Check
                $subject_check = ClassRoutine::where('subject_id', $data['subject'][$j])
                ->where('session_id', $session)
                ->where('start_time', $start)
                ->where('day', $day)
                ->first();

                //Room Check
                $room_check = ClassRoutine::where('room_id', $data['room'][$j])
                ->where('session_id', $session)
                ->where('start_time', $start)
                ->where('day', $day)
                ->first();

                //Period Check
                $period_check = ClassRoutine::where('session_id', $session)->where('program_id', $program)->where('semester_id', $semester)->where('section_id', $section)
                ->where('start_time', $start)
                ->where('day', $day)
                ->first();

                
                if(!empty($data['routine_id'][$j]))
                {
                    $classRoutine = ClassRoutine::find($data['routine_id'][$j]);
                    $classRoutine->subject_id = $data['subject'][$j];
                    $classRoutine->teacher_id = $data['teacher'][$j];
                    $classRoutine->room_id= $data['room'][$j];
                    $classRoutine->session_id = $session;
                    $classRoutine->program_id = $program;
                    $classRoutine->semester_id = $semester;
                    $classRoutine->section_id = $section;
                    $classRoutine->start_time= $data['start_time'][$j];
                    $classRoutine->end_time= $data['end_time'][$j];
                    $classRoutine->day= $day;
                    $classRoutine->save();

                    Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                }
                else{
                    if(!empty($period_check) && !empty($room_check) && !empty($subject_check))
                    {
                        Toastr::error(__('msg_data_already_exists'), __('msg_error'));
                    }
                    else{
                        $classRoutine = new ClassRoutine;
                        $classRoutine->subject_id = $data['subject'][$j];
                        $classRoutine->teacher_id = $data['teacher'][$j];
                        $classRoutine->room_id= $data['room'][$j];
                        $classRoutine->session_id = $session;
                        $classRoutine->program_id = $program;
                        $classRoutine->semester_id = $semester;
                        $classRoutine->section_id = $section;
                        $classRoutine->start_time= $data['start_time'][$j];
                        $classRoutine->end_time= $data['end_time'][$j];
                        $classRoutine->day= $day;
                        $classRoutine->save();

                        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                    }
                   
                }
            }

            // Delete Routine
            if(!empty($request->delete_routine) && isset($request->delete_routine)){
            $delete_routine_count = count($data['delete_routine']);
            for($i = 0; $i < $delete_routine_count; $i++)
            {
                $classRoutine = ClassRoutine::find($data['delete_routine'][$i]);
                $classRoutine->delete();

                Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            }}
        }

        DB::commit();


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassRoutine $classRoutine)
    {
        // Delete Data
        $classRoutine->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teacher(Request $request)
    {
        //
        $data['title'] = trans_choice('module_teacher_routine', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        if (auth()->user()->roles[0]->name != 'Super Admin' && auth()->id() != request()->get('teacher') && !auth()->user()->hasPermissionTo('teacher-routine-filter')) {
            return redirect()->route('admin.class-routine.teacher',['teacher' => auth()->id()]);
        }
        // Teacher Filter
        $teachers = User::where('status', '1');
        $teachers->with('roles')->whereHas('roles', function ($query){
            $query->where('slug', 'teacher');
        });
        $data['teachers'] = $teachers->orderBy('staff_id', 'asc')->get();


        if(!empty($request->teacher) && $request->teacher != Null){

            $data['selected_staff'] = $request->teacher;

            $session = Session::where('status', '1')->where('current', '1')->first();

            if(isset($session)){
            $data['rows'] = ClassRoutine::where('status', '1')
                        // ->where('session_id', $session->id)
                        ->where('teacher_id', $request->teacher)
                        ->orderBy('start_time', 'asc')
                        ->get();
            }
        } else if(auth()->user()->roles[0]->name == 'admin' || auth()->user()->roles[0]->name == 'Super Admin') {
            
        } else {
            $data['selected_staff'] = Null;
        }

        return view($this->view.'.teacher', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = 'print-setting';

        // View
        $data['print'] = PrintSetting::where('slug', 'class-routine')->firstOrFail();
        
        // Filter Routine
        if(!empty($request->program) && !empty($request->session) && !empty($request->semester) && !empty($request->section)){

            $routines = ClassRoutine::where('status', '1');

            if(!empty($request->program)){
                $routines->where('program_id', $request->program);
            }
            if(!empty($request->session)){
                $routines->where('session_id', $request->session);
            }
            if(!empty($request->semester)){
                $routines->where('semester_id', $request->semester);
            }
            if(!empty($request->section)){
                $routines->where('section_id', $request->section);
            }
            $data['rows'] = $routines->orderBy('start_time', 'asc')->get();   
        }
        $program = Program::where('id', $request->program)->first();
        $session = Session::where('id', $request->session)->first();
        $semester = Semester::where('id', $request->semester)->first();
        $section = Section::where('id', $request->section)->first();
        $data['program'] = $program;
        $data['session'] = $session;
        $data['semester'] = $semester;
        $data['section'] = $section;
        return view($this->view.'.print1', $data);
    }


    public function getTeachers(Request $request)
    {
        $subject = Subject::where('id', $request->subject_id)->first();
        if($subject->title == 'Sports' || $subject->title == 'Placement cell' || $subject->title == 'Lunch Break' || $subject->title == 'library')
        {
            $array = [];
            $teachers = User::where('id', auth()->id())->first();
            array_push($array, $teachers);
            return $array;
        }
        // $teacherIds = $subject->managed_by;
        // $teacherIdsArray = explode(',', str_replace(['[', ']', '"'], '', $teacherIds));
        // $teachers = User::whereIn('id', $teacherIdsArray)->get();
        // return response()->json($teachers);
        $teacherIds = $subject->managed_by;

        // Ensure that $teacherIds is an array
        if (is_array($teacherIds)) {
            // If $teacherIds is already an array, no need to explode
            $teachers = User::whereIn('id', $teacherIds)->get();
            return response()->json($teachers);
        } else {
            // If $teacherIds is a string, then proceed with your original logic
            $teacherIdsArray = explode(',', str_replace(['[', ']', '"'], '', $teacherIds));
            $teachers = User::whereIn('id', $teacherIdsArray)->get();
            return response()->json($teachers);
        }
    }
}
