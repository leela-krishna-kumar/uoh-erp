<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Session;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use App\User;
use Toastr;
use Auth;

class StudentAttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_student_subject_attendance', 1);
        $this->route = 'admin.student-attendance';
        $this->view = 'admin.student-attendance';
        $this->path = 'student-attendance';
        $this->access = 'student-attendance';


        $this->middleware('permission:'.$this->access.'-action', ['only' => ['index','store']]);

        $this->middleware('permission:'.$this->access.'-report', ['only' => ['report']]);
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
        $data['rows'] = [];


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

        if(!empty($request->subject) || $request->subject != null){
            $data['selected_subject'] = $subject = $request->subject;
        }
        else{
            $data['selected_subject'] = '0';
        }

        if(!empty($request->date) || $request->date != null){
            $data['selected_date'] = $date = $request->date;
        }
        else{
            $data['selected_date'] = date("Y-m-d", strtotime(Carbon::today()));
        }

        // Search Filter
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

        if(!empty($request->program) && $request->program != '0' && !empty($request->session) && $request->session != '0'){
            // Access Data
            $teacher_id = Auth::guard('web')->user()->id;
            $user = User::where('id', $teacher_id)->where('status', '1');
            $user->with('roles')->whereHas('roles', function ($query){
                $query->where('slug', 'super-admin');
            });
            $superAdmin = $user->first();

            // Filter Subject
            $subjects = Subject::where('status', '1');
            $subjects->with('classes')->whereHas('classes', function ($query) use ($teacher_id, $session, $superAdmin){
                if(isset($session)){
                    $query->where('session_id', $session);
                }
                if(!isset($superAdmin)){
                    $query->where('teacher_id', $teacher_id);
                }
            });
            $subjects->with('programs')->whereHas('programs', function ($query) use ($program){
                $query->where('program_id', $program);
            });
            $data['subjects'] = $subjects->orderBy('code', 'asc')->get();
        }


        // Student List

        if(!empty($request->program) && !empty($request->session) && !empty($request->subject)){
            // Check Subject Access

            $subject_check = Subject::where('id', $subject);
            $subject_check->with('classes')->whereHas('classes', function ($query) use ($teacher_id, $session, $superAdmin){
                if(isset($session)){
                    $query->where('session_id', $session);
                }
                if(!isset($superAdmin)){
                    $query->where('teacher_id', $teacher_id);
                }
            })->first();

            // Enrolls
            $enrolls = StudentEnroll::where('status', '1');
            if(!empty($request->program) && $request->program != 'all'){
                $enrolls->where('program_id', $program);
            }
            if(!empty($request->session) && $request->session != 'all'){
                $enrolls->where('session_id', $session);
            }
            if(!empty($request->semester) && $request->semester != 'all'){
                $enrolls->where('semester_id', $semester);
            }
            if(!empty($request->section) && $request->section != 'all'){
                $enrolls->where('section_id', $section);
            }
            // $enrolls->with('subjects')->whereHas('subjects', function ($query) use ($subject){
            //     $query->where('subject_id', $subject);
            // });
            $enrolls->with('student')->whereHas('student', function ($query){
                $query->where('status', '1');
                $query->orderBy('student_id', 'asc');
            });

            $data['rows'] = $enrolls->get();
        }


        // return $request->all();
        // Attendances
        if(!empty($request->program) || !empty($request->semester) &&  !empty($request->faculty)  && !empty($request->session)  && !empty($request->section) &&  !empty($request->subject)){
            $attendances = StudentAttendance::query();
            if(!empty($request->date) && !empty($request->subject) && $request->subject !='all'){
                $attendances->where('subject_id', $request->subject)->where('date', $date);
                    // return $request->all();
                if(!empty($request->program) && !empty($request->session)){
                    $attendances->with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($program, $session, $semester, $section){
                        if($program != '0' && $program != 'all'){
                            $query->where('program_id', $program);
                        }
                        if($session != '0' && $session != 'all'){
                            $query->where('session_id', $session);
                        }
                        if($semester != '0' && $semester != 'all'){
                            $query->where('semester_id', $semester);
                        }
                        if($section != '0' && $section != 'all'){
                            $query->where('section_id', $section);
                        }
                    });
                }
            }

            $data['attendances'] = $attendances->orderBy('id', 'asc')->get();
        }
        // return $data;
        return view($this->view.'.index', $data);
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
            'students' => 'required',
            'subject' => 'required',
            'date' => 'required|date|before_or_equal:today',
            'attendances' => 'required',
        ]);

        $attendances = explode(",",$request->attendances);

        // Insert Data
        foreach($request->students as $key => $student){

            // Insert Or Update Data
            $studentAttendance = StudentAttendance::updateOrCreate(
            [
                'student_enroll_id' => $student,
                'subject_id' => $request->subject,
                'date' => $request->date
            ],[
                'student_enroll_id' => $student,
                'subject_id' => $request->subject,
                'date' => $request->date,
                'attendance' => $attendances[$key],
                'note' => $request->notes[$key],
                'created_by' => Auth::guard('web')->user()->id
            ]);
        }


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        //

        $data['title'] = trans_choice('module_student_subject_report', 1);
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

        if(!empty($request->subject) || $request->subject != null){
            $data['selected_subject'] = $subject = $request->subject;
        }
        else{
            $data['selected_subject'] = '0';
        }

        if(!empty($request->month) || $request->month != null){
            $data['selected_month'] = $month = $request->month;
        }
        else{
            $data['selected_month'] = date("m", strtotime(Carbon::today()));
        }

        if(!empty($request->year) || $request->year != null){
            $data['selected_year'] = $year = $request->year;
        }
        else{
            $data['selected_year'] = date("Y", strtotime(Carbon::today()));
        }


        // Search Filter
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

        if(!empty($request->program) && $request->program != '0' && !empty($request->session) && $request->session != '0'){
            // Access Data
            $teacher_id = Auth::guard('web')->user()->id;
            $user = User::where('id', $teacher_id)->where('status', '1');
            $user->with('roles')->whereHas('roles', function ($query){
                $query->where('slug', 'super-admin');
            });
            $superAdmin = $user->first();
            
            // Filter Subject
            $subjects = Subject::where('status', '1');
            // $subjects->with('classes')->whereHas('classes', function ($query) use ($teacher_id, $session, $superAdmin){
            //     if(isset($session)){
            //         $query->where('session_id', $session);
            //     }
            //     if(!isset($superAdmin)){
            //         $query->where('teacher_id', $teacher_id);
            //     }
            // });
            // $subjects->with('programs')->whereHas('programs', function ($query) use ($program){
            //     $query->where('program_id', $program);
            // });
            $subjects->with('subjectEnrolls')->whereHas('subjectEnrolls', function ($query) use ($data){
                $query->where('program_id', request('program'));
                $query->where('semester_id',request('semester'));
                $query->where('section_id', request('section'));
            });
            $data['subjects'] = $subjects->orderBy('code', 'asc')->get();
            
        }

//problem

        // Student List
        if(!empty($request->program) && !empty($request->session) && !empty($request->subject)){

            if($subject != 'all'){
                // Check Subject Access
                $subject_check = Subject::where('id', $subject);
                $subject_check->with('classes')->whereHas('classes', function ($query) use ($teacher_id, $session, $superAdmin){
                    if(isset($session)){
                        $query->where('session_id', $session);
                    }
                    if(!isset($superAdmin)){
                        $query->where('teacher_id', $teacher_id);
                    }
                })->first();
            }

            // Enrolls
            $enrolls = StudentEnroll::where('id', '!=', '0');
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
            $enrolls->with('subjects')->whereHas('subjects', function ($query) use ($subject){
                $query->where('subject_id', $subject);
            });
            $enrolls->with('student')->whereHas('student', function ($query){
                $query->orderBy('student_id', 'asc');
            });

            $data['rows'] = $enrolls->paginate(10);
        }


        // Attendances
        if(!empty($request->month) && !empty($request->year) && !empty($request->subject)){
            $attendances = StudentAttendance::where('subject_id', $request->subject)->whereYear('date', $year)->whereMonth('date', $month);

            if(!empty($request->program) && !empty($request->session)){
                $attendances->with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($program, $session, $semester, $section){
                    if($program != '0'){
                        $query->where('program_id', $program);
                    }
                    if($session != '0'){
                        $query->where('session_id', $session);
                    }
                    if($semester != '0'){
                        $query->where('semester_id', $semester);
                    }
                    if($section != '0'){
                        $query->where('section_id', $section);
                    }
                });
            }

            $data['attendances'] = $attendances->orderBy('id', 'asc')->get();
        }

        return view($this->view.'.report', $data);
    }

    public function summaryReport(Request $request)
    {
        //
        $data['title'] = trans_choice('module_student_attendance_summary', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

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


        // Student Filter

        if(!empty($request->program) || !empty($request->semester) &&  !empty($request->faculty)  && !empty($request->session)  && !empty($request->section) || !empty($request->status)){
            $students = Student::where('status', '1');
            if($faculty != 0 && $faculty != 'all'){
                $students->with('program')->whereHas('program', function ($query) use ($faculty){
                    $query->where('faculty_id', $faculty);
                });
            }
            if(($session != 0 && $session != 'all') || ($semester != 0 && $semester != 'all') || ($section != 0 && $section != 'all')){
                 $students->with('currentEnroll')->whereHas('currentEnroll', function ($query) use ($program, $session, $semester, $section){
                    if($program != 0 && $program != 'all'){
                    $query->where('program_id', $program);
                    }
                    if($session != 0 && $session != 'all'){
                    $query->where('session_id', $session);
                    }
                    if($semester != 0 && $semester != 'all'){
                    $query->where('semester_id', $semester);
                    }
                    if($section != 0 && $section != 'all'){
                    $query->where('section_id', $section);
                    }
                });
            }

            if(!empty($request->status) && $request->status != 'all'){
                $students->with('statuses')->whereHas('statuses', function ($query) use ($status){
                    $query->where('status_type_id', $status);
                });
            }
            $data['rows'] = $students->orderBy('student_id', 'desc')->get();
        }
        if(!empty($request->student) && $request->student != Null){
            $data['rows'] = $student = Student::where('id', $request->student)->get();
        }

        $data['students'] = Student::where('program_id',$request->program)->get();
        $data['selected_student'] = $request->student;
        return view($this->view.'.summary', $data);
    }
}
