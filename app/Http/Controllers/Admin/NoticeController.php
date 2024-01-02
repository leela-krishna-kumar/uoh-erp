<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NoticeNotification;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\NoticeCategory;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Program;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use App\Models\StatusType;
use App\Models\Notice;
use Carbon\Carbon;
use Toastr;
use Auth;
use DB;

class NoticeController extends Controller
{
    use FileUploader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_notice', 1);
        $this->route = 'admin.notice';
        $this->view = 'admin.notice';
        $this->path = 'notice';
        $this->access = 'notice';


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
    public function index( Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $notices = Notice::query();
        if(request()->has('category_id') && request()->get('category_id') != null) {
            $notices->where('category_id',request()->get('category_id'));
      
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
        $data['rows'] = $notices->orderBy('id', 'desc')->get();
        $data['categories'] = NoticeCategory::orderBy('title', 'asc')->get();
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

        $data['faculties'] = Faculty::where('status', '1')
                            ->orderBy('title', 'asc')->get();
        $data['categories'] = NoticeCategory::where('status', '1')
                            ->orderBy('title', 'asc')->get();
        $data['roles'] = Role::select('id','name')->get();

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
            'faculty' => 'required',
            'program' => 'required',
            'session' => 'required',
            'semester' => 'required',
            'section' => 'required',
            'category' => 'required|integer',
            'notice_no' => 'required|numeric|unique:notices,notice_no',
            'title' => 'required|max:191',
            'date' => 'required|date|after_or_equal:today',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);


        try{
            DB::beginTransaction();
            // Insert Data
            $notice = new Notice;
            $notice->faculty_id = $request->faculty;
            $notice->program_id = $request->program;
            $notice->session_id = $request->session;
            $notice->semester_id = $request->semester;
            $notice->section_id = $request->section;
            $notice->category_id = $request->category;
            $notice->notice_no = $request->notice_no;
            $notice->title = $request->title;
            $notice->description = $request->description;
            $notice->date = $request->date;
            $notice->attach = $this->uploadMedia($request, 'attach', $this->path);
            $notice->created_by = Auth::guard('web')->user()->id;
            $notice->save();


            // Set Value
            $faculty = $request->faculty;
            $program = $request->program;
            $session = $request->session;
            $semester = $request->semester;
            $section = $request->section;

            // Student Filter
            $students = Student::where('status', '1');
            if($faculty != 0){
                $students->with('program')->whereHas('program', function ($query) use ($faculty){
                    $query->where('faculty_id', $faculty);
                });
            }
            $students->with('currentEnroll')->whereHas('currentEnroll', function ($query) use ($program, $session, $semester, $section){
                if($program != 0){
                $query->where('program_id', $program);
                }
                if($session != 0){
                $query->where('session_id', $session);
                }
                if($semester != 0){
                $query->where('semester_id', $semester);
                }
                if($section != 0){
                $query->where('section_id', $section);
                }
                $query->where('status', '1');
            });
            $all_students = $students->orderBy('student_id', 'desc')->get();

            // Attach Data
            $notice->students()->attach($all_students);


            // Notification Data
            $data = [
                'id' => $notice->id,
                'title' => $notice->title,
                'type' => 'notice'
            ];

            $today_date = Carbon::parse(Carbon::today())->format('Y-m-d');

            if($request->date == $today_date){

                Notification::send($all_students, new NoticeNotification($data));
            }
            DB::commit();
            

            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.index');
        }
        catch(\Exception $e){

            Toastr::error(__('msg_created_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $notice;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $notice;

        $data['categories'] = NoticeCategory::where('status', '1')
                            ->orderBy('title', 'asc')->get();
        $data['roles'] = Role::select('id','name')->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        // Field Validation
        $request->validate([
            'category' => 'required|integer',
            'notice_no' => 'required|numeric|unique:notices,notice_no,'.$notice->id,
            'date' => 'required|date',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);


        // Update Data
        $notice->category_id = $request->category;
        $notice->notice_no = $request->notice_no;
        // $notice->title = $request->title;
        $notice->description = $request->description;
        $notice->date = $request->date;
        $notice->attach = $this->updateMedia($request, 'attach', $this->path, $notice);
        $notice->status = $request->status;
        $notice->updated_by = Auth::guard('web')->user()->id;
        $notice->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        DB::beginTransaction();
        // Delete Attach File
        $this->deleteMedia($this->path, $notice);

        // Delete Attach
        $notice->students()->detach();
        $notice->users()->detach();

        // Delete Notification
        DB::table('notifications')->where('type', 'App\Notifications\NoticeNotification')->where('data->id', $notice->id)->delete();

        //Delete Data
        $notice->delete();
        DB::commit();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
