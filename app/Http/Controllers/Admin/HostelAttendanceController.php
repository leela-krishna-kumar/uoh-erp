<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\HostelAttendance;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\HostelRoom;
use App\Models\Program;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use App\Models\StudentEnroll;
use Carbon\Carbon;
use App\Models\Hostel;
use App\Models\HostelMember;
use Illuminate\Http\Request;
use Toastr;

class HostelAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_hostel_attendance', 2);
        $this->route = 'admin.hostel-attendance';
        $this->view = 'admin.hostel-attendance';
        $this->path = 'hostel-attendance';
        $this->access = 'hostel-attendance';

    }
    public function index(Request $request)
    {
        // return $request->all();
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;


        // if(!empty($request->faculty) || $request->faculty != null){
        //     $data['selected_faculty'] = $faculty = $request->faculty;
        // }
        // else{
        //     $data['selected_faculty'] = $faculty = '0';
        // }

        // if(!empty($request->program) || $request->program != null){
        //     $data['selected_program'] = $program = $request->program;
        // }
        // else{
        //     $data['selected_program'] = $program = '0';
        // }

        // if(!empty($request->session) || $request->session != null){
        //     $data['selected_session'] = $session = $request->session;
        // }
        // else{
        //     $data['selected_session'] = $session = '0';
        // }

        // if(!empty($request->semester) || $request->semester != null){
        //     $data['selected_semester'] = $semester = $request->semester;
        // }
        // else{
        //     $data['selected_semester'] = $semester = '0';
        // }

        // if(!empty($request->section) || $request->section != null){
        //     $data['selected_section'] = $section = $request->section;
        // }
        // else{
        //     $data['selected_section'] = $section = '0';
        // }

        // if(!empty($request->status) || $request->status != null){
        //     $data['selected_status'] = $status = $request->status;
        // }
        // else{
        //     $data['selected_status'] = '0';
        // }
        if(!empty($request->hostel) || $request->hostel != null){
            $data['selected_hostel'] = $hostel = $request->hostel;
        }
        else{
            $data['selected_hostel'] = $hostel = '0';
        }

        if(!empty($request->from_date) || $request->from_date != null){
            $data['selected_from_date'] = $from_date = $request->from_date;
        }
        else{
            $data['selected_from_date'] = $from_date = "";
        }
        if(!empty($request->to_date) || $request->to_date != null){
            $data['selected_to_date'] = $to_date = $request->to_date;
        }
        else{
            $data['selected_to_date'] = $to_date = "";
        }

        if(!empty($request->rooms) || $request->rooms != null){
            $data['rooms'] = HostelRoom::where('status', '1')->orderBy('name', 'asc')->get();
            $data['selected_rooms'] = $rooms = $request->rooms;
        }
        else{
            $data['selected_rooms'] = $rooms = [];
        }

        // Search Filter
        // $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['hostels'] = Hostel::where('type', '!=', '3')->where('status', '1')->orderBy('name', 'asc')->get();


        // if(!empty($request->faculty) && $request->faculty != '0'){
        //     $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        // }

        // if(!empty($request->program) && $request->program != '0'){
        //     $sessions = Session::where('status', 1);
        //     $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
        //         $query->where('program_id', $program);
        //     });
        //     $data['sessions'] = $sessions->orderBy('id', 'desc')->get();
        // }

        // if(!empty($request->program) && $request->program != '0'){
        //     $semesters = Semester::where('status', 1);
        //     $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
        //         $query->where('program_id', $program);
        //     });
        //     $data['semesters'] = $semesters->orderBy('id', 'asc')->get();
        // }

        // if(!empty($request->program) && $request->program != '0' && !empty($request->semester) && $request->semester != '0'){
        //     $sections = Section::where('status', 1);
        //     $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
        //         $query->where('program_id', $program);
        //         $query->where('semester_id', $semester);
        //     });

        //     $data['sections'] = $sections->orderBy('title', 'asc')->get();
        // }

        if (!empty($request->hostel) && $request->hostel != '0') {
            $hostelAttendances = HostelAttendance::query();
            $hostelAttendances = $hostelAttendances->join('hostel_members as hm' , 'hostel_attendances.student_id', '=', 'hm.hostelable_id')
                                                    ->join('hostel_rooms as hr','hm.hostel_room_id', '=', 'hr.id' )
                                                    ->where('hr.hostel_id',$hostel);
            if (!empty($request->rooms) && $request->rooms != '0'){
                $hostelAttendances = $hostelAttendances->whereIn('hr.id',$rooms);
            }
        }
        if (!empty($request->from_date) && !empty($request->to_date)){
            $hostelAttendances = $hostelAttendances->whereBetween('date',[$from_date,$to_date]);

        }
        if (!empty($request->all()) && !empty($request->hostel)){
            $data['rows'] = $hostelAttendances->select('hostel_attendances.id','hostel_attendances.student_id','hostel_attendances.status','hostel_attendances.direction','hostel_attendances.date','hr.name as hostel_name')->orderBy('hostel_attendances.id', 'desc')->get();
            // return ( $data['rows']);
        } else {
            $data['rows'] = [];
        }

        return view($this->view.'.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //  try {
            // return $request->all();
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            // if(!empty($request->faculty) || $request->faculty != null){
            //     $data['selected_faculty'] = $faculty = $request->faculty;
            // }
            // else{
            //     $data['selected_faculty'] = '0';
            // }

            // if(!empty($request->session) || $request->session != null){
            //     $data['selected_session'] = $session = $request->session;
            // }
            // else{
            //     $data['selected_session'] = '0';
            // }

            // if(!empty($request->program) || $request->program != null){
            //     $data['selected_program'] = $program = $request->program;
            // }
            // else{
            //     $data['selected_program'] = '0';
            // }

            // if(!empty($request->semester) || $request->semester != null){
            //     $data['selected_semester'] = $semester = $request->semester;
            // }
            // else{
            //     $data['selected_semester'] = '0';
            // }

            // if(!empty($request->section) || $request->section != null){
            //     $data['selected_section'] = $section = $request->section;
            // }
            // else{
            //     $data['selected_section'] = '0';
            // }
            if(!empty($request->hostel) || $request->hostel != null){
                $data['selected_hostel'] = $hostel = $request->hostel;
            }
            else{
                $data['selected_hostel'] = $hostel = '0';
            }

            if(!empty($request->rooms) || $request->rooms != null){
                $data['rooms'] = HostelRoom::where('status', '1')->orderBy('name', 'asc')->get();
                $data['selected_rooms'] = $rooms = $request->rooms;
            }
            else{
                $data['selected_rooms'] = $rooms = [];
            }

            if(!empty($request->date) || $request->date != null){
                $data['selected_date'] = $date = $request->date;
            }
            else{
                $data['selected_date'] = date("Y-m-d", strtotime(Carbon::today()));
            }

            $data['hostels'] = Hostel::where('type', '!=', '3')->where('status', '1')->orderBy('name', 'asc')->get();
            $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
            // if(!empty($request->faculty) && $request->faculty != '0'){
            // $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();}

            // if(!empty($request->program) && $request->program != '0'){
            // $sessions = Session::where('status', 1);
            // $sessions->with('programs')->whereHas('programs', function ($query) use ($program){
            //     $query->where('program_id', $program);
            // });
            // $data['sessions'] = $sessions->orderBy('id', 'desc')->get();}

            // if(!empty($request->program) && $request->program != '0'){
            // $semesters = Semester::where('status', 1);
            // $semesters->with('programs')->whereHas('programs', function ($query) use ($program){
            //     $query->where('program_id', $program);
            // });
            // $data['semesters'] = $semesters->orderBy('id', 'asc')->get();}

            // if(!empty($request->program) && $request->program != '0' && !empty($request->semester) && $request->semester != '0'){
            // $sections = Section::where('status', 1);
            // $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester){
            //     $query->where('program_id', $program);
            //     $query->where('semester_id', $semester);
            // });
            // $data['sections'] = $sections->orderBy('title', 'asc')->get();}


            // Filter Student
            $students = Student::where('id', '!=', '0');
            if (!empty($hostel) && $hostel != 0){
                $hostel_rooms = HostelRoom::where('hostel_id',$hostel);
                if (!empty($rooms)){
                    $hostel_rooms =$hostel_rooms->whereIn('id',$rooms);
                }
                $hostel_rooms = $hostel_rooms->pluck('id');
                // return $hostel_rooms;
                // return  $students = $students->whereHas('hostelRoom')->get();
                $students = $students->whereHas('hostelRoom', function ($query)  use ($hostel_rooms){
                    $query->whereIn('hostel_room_id', $hostel_rooms);
                });
                // return $students = $students->get();
            } else {
                $students = $students->has('hostelRoom')->with('hostelRoom.room');
            }

            // if(isset($request->faculty) || isset($request->program)){
            //     $enrolls = StudentEnroll::where('status', '1');

            //     if(!empty($request->faculty) && $request->faculty != '0'){
            //         $enrolls->with('program')->whereHas('program', function ($query) use ($faculty){
            //             $query->where('faculty_id', $faculty);
            //         });
            //     }
            //     if(!empty($request->program) && $request->program != '0'){
            //         $enrolls->where('program_id', $program);
            //     }
            //     if(!empty($request->session) && $request->session != '0'){
            //         $enrolls->where('session_id', $session);
            //     }
            //     if(!empty($request->semester) && $request->semester != '0'){
            //         $enrolls->where('semester_id', $semester);
            //     }
            //     if(!empty($request->section) && $request->section != '0'){
            //         $enrolls->where('section_id', $section);
            //     }

            //     $enrolls->with('student')->whereHas('student', function ($query){
            //         $query->where('status', '1');
            //         $query->orderBy('student_id', 'asc');
            //     });
            //     $enrolls = $enrolls->whereHas('student.hostelRoom');//ravi
            //     // $enrolls = StudentEnroll::where('status', '1');
            //     $data['rows'] = $enrolls->get();
            // }
            if (!empty($request->all())){
                $students = $students->with([
                    'hostelRoom' => function ($query) {
                        $query->select('id', 'hostel_room_id','hostelable_id');
                        $query->with('room:id,name');
                    },
                    'hostelAttendances' => function ($query) use ($date) {
                        $query->select('id', 'student_id', 'date', 'direction', 'status')
                              ->where('date', $date);
                    }

                ]) ;
                $data['rows'] = $students
                ->select('id','student_id','first_name','last_name')
                ->get();
                // return $data['rows'];
            }else {
                $data['rows'] = [];
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
        //
        // return $request->all();
        if(isset($request->roll_no)){
            $student = Student::where('roll_no',$request->roll_no)->first();
            if(!$student){
                Toastr::error(__('Student Not Found'), __('msg_error'));
                return redirect()->route($this->route.'.index');
            }else{
                $task = new HostelAttendance;
                $task->student_id  = $student->id;
                $task->direction = 1;
                $task->status = "P";
                $task->in_time = Carbon::now()->format('Y-m-d H:i:s');
                // $task->note = $request->note;
                $task->date = now()->format('Y-m-d');
                $task->save();
            }
        }else{
            $request->validate([
                'student_ids' => 'required',
                'all_student_ids' => 'required',
                'date' => 'required|date|before_or_equal:today',
                // 'note' => 'required',
                'direction' => 'required',
            ]);
            // Insert Data
            $checked_student_ids = array_map(function($arr) {
                return intval($arr);
                },explode(',',$request->student_ids));
            // return ($checked_student_ids);
            $all_student_ids = array_map(function($arr) {
                return intval($arr);
                },explode(',',$request->all_student_ids));
            // return $all_student_ids;
            foreach ($all_student_ids as $key => $student_id) {
                $status = "A";
                if (in_array($student_id, $checked_student_ids)){
                    $status = "P";
                }
                HostelAttendance::updateOrCreate(
                    ['student_id' => $student_id, 'date' => $request->date],
                    [
                        'direction' => $request->direction,
                        'note' => $request->note,
                        'date' => $request->date,
                        'status' =>$status,
                        'in_time' => ($request->direction == 1) ? Carbon::now()->format('Y-m-d H:i:s') : null,
                        'out_time' => ($request->direction == 2) ? Carbon::now()->format('Y-m-d H:i:s') : null,
                    ]
                );
            }
        }

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HostelAttendance  $hostelAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(HostelAttendance $hostelAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HostelAttendance  $hostelAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(HostelAttendance $hostelAttendance)
    {
        try {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['row'] = $hostelAttendance;
        return view($this->view.'.edit', $data);
    } catch(\Exception $e){

        Toastr::error(__('msg_error'));

        return redirect()->back();
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HostelAttendance  $hostelAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HostelAttendance $hostelAttendance)
    {
        //
        // return $request->all();
        try {
            if(!$request->has('direction')){
                $hostelAttendance->direction = 0;
            }else{
                $hostelAttendance->direction = $request->direction;
            }
            $hostelAttendance->date = $request->date;
            $hostelAttendance->note = $request->note;
            $hostelAttendance->status = $request->status;
            $hostelAttendance->in_time = ($request->direction == 1) ? Carbon::now()->format('Y-m-d H:i:s') : null;
            $hostelAttendance->out_time = ($request->direction == 2) ? Carbon::now()->format('Y-m-d H:i:s') : null;
            $hostelAttendance->save();
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/hostel-attendance')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HostelAttendance  $hostelAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(HostelAttendance $hostelAttendance)
    {

        try{
            if ($hostelAttendance) {
                $hostelAttendance->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
