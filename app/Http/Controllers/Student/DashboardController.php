<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAssignment;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Student;
use App\Models\Event;
use App\Models\Fee;
use App\Models\ELesson;
use Carbon\Carbon;
use Auth;
use App\Models\ECourse;
use App\Models\ECourseUser;
use App\Models\ESection;
use App\Models\Semester;
use App\Models\ProgramSemesterSection;
use Carbon\CarbonInterval;
use App\Models\TestPaper;
use App\Models\TestPaperUser;
use App\Models\TestPaperProgress;
use App\Models\EventUser;
use Closure;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_dashboard', 1);
        $this->route = 'student.dashboard';
        $this->view = 'student';
    }



    public function studentIndex(Request $request)
    {
        $data['title'] = trans_choice('module_profile', 1);
        $data['route'] = 'student.profile';
        $data['view'] = 'student.profile';
        $data['row'] = Student::where('id', Auth::guard('student')->user()->id)->firstOrFail();
        
        return view('student.profile.student-account-details', $data);
    }
    
    public function studentCourseIndex(Request $request)
    {
        $semester = Semester::orderBy('id', 'asc')->first();
        if(!$request->input('semester'))
        {
            $semester = $semester->id;
        }
        else{
            $semester =  $request->input('semester');
        }
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $student = auth()->user();
        // return $student->program->semesters;
        $data['semesters'] = $student->program->semesters;
        $eCourseUser = $student->eCourseUser()->where('semester_id',$semester)->pluck('course_id')->toArray();
        // $eCourseUser = $student->eCourseUser->pluck('course_id')->toArray();
        // $data['e_courses'] = ECourse::where('is_published', 1)->whereIn('id',$eCourseUser)->where('Semester_id',$semester)->gset();
        $data['e_courses'] = ECourse::where('is_published', 1)->whereIn('id',$eCourseUser)->get();

        return view($this->view.'.student-index', $data);
    }

    public function studentCourses()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['e_courses'] = Ecourse::where('is_published', 1)->get();
        return view($this->view.'.course.student-course', $data);
    }

    public function studentCoursesInfo($id)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['e_course'] = Ecourse::where('id', $id)->where('is_published', 1)->first();
        $data['releted_e_courses'] = Ecourse::whereNot('id', $id)->where('is_published', 1)->take(8)->get();
        $data['e_sections'] = ESection::where('e_course_id', $id)->get();
        $interval = CarbonInterval::minutes($data['e_course']->duration);
        $data['course_duration'] = $interval->cascade()->forHumans(['short' => true]);
        return view($this->view.'.course.student-course-info', $data);
    }

    public function studentCoursesWatch($id)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['e_course'] = Ecourse::where('id', $id)->where('is_published', 1)->first();
        $data['e_sections'] = ESection::where('e_course_id', $id)->get();
        $section_ids = ESection::where('e_course_id', $id)->pluck('id');
        $e_lesson_id = ELesson::whereIn('e_section_id', $section_ids)->first();
        if($e_lesson_id) {
            $data['e_lesson_id'] = $e_lesson_id->id;
        } else {
            $data['e_lesson_id'] = 0;
        }
        return view($this->view.'.course.student-course-watch', $data);
    }

    public function getLesson(Request $request)
    {
        $lesson_id = $request->input('lesson_id');

        // Fetch the lesson from the database
        $lesson = Elesson::where('id', $lesson_id)->first();

        return response()->json(['data' => $lesson->link]);
    }

    public function studentBooks()
    {
        return view($this->view.'.books.student-books');
    }
    public function studentChats()
    {
        return view($this->view.'.chat.student-chats');
    }

    public function studentExams()
    {
        $student = auth()->user();
        $testPaperUserPending = $student->testPaperUser->where('status',TestPaperUser::STATUS_PENDING)->pluck('test_paper_id')->toArray();
        $data['testPapersPending'] = TestPaper::whereIn('id',$testPaperUserPending)->get();
        $testPaperUserStarted = $student->testPaperUser->where('status',TestPaperUser::STATUS_STARTED)->pluck('test_paper_id')->toArray();
        $data['testPapersStarted'] = TestPaper::whereIn('id',$testPaperUserStarted)->get();
        $testPaperUserCompleted = $student->testPaperUser->where('status',TestPaperUser::STATUS_COMPLETED)->pluck('test_paper_id')->toArray();
        $data['testPapersCompleted'] = TestPaper::whereIn('id',$testPaperUserCompleted)->get();

        return view($this->view.'.exams.student-exam-info',$data);
    }

    public function studentExamWatch($id)
    {
        $data['testPaper'] = TestPaper::find($id);
        $interval = CarbonInterval::minutes($data['testPaper']->duration);
        $data['formatted_duration'] = $interval->cascade()->forHumans(['short' => true]);
        return view($this->view.'.exams.student-exam-disclaimer',$data);
    }

    public function studentExamStarted($id)
    {
      //  dd('11');

        $data['testPaper'] = TestPaper::find($id);

      //  dd($data['testPaper']);

        $TestPaperUser = TestPaperUser::where('test_paper_id',$data['testPaper']->id)->where('student_id',auth()->id())->first();
        $TestPaperUser->status = TestPaperUser::STATUS_STARTED;
        if($TestPaperUser->started_at == null){
            $TestPaperUser->started_at = now();
        }
        $TestPaperUser->save();
        $data['student'] = TestPaperUser::where('test_paper_id',$data['testPaper']->id)->first();
        return view($this->view.'.exams.student-exam-started',$data);
    }

    public function studentExamSubmitted($id)
    {
        $data['testPaper'] = TestPaper::find($id);
        $data['student'] = TestPaperUser::where('test_paper_id',$data['testPaper']->id)->first();
        return view($this->view.'.exams.student-thank-you',$data);
    }

    public function studentExamReport($id)
    {
        $data['testPaper'] = TestPaper::find($id);
        $data['student'] = TestPaperUser::where('test_paper_id',$data['testPaper']->id)->first();
        $data['progress'] = TestPaperProgress::where('test_paper_id',$data['testPaper']->id)->where('student_id',$data['student']->id)->get();
        $data['correctAnswer'] =$data['progress']->where('score',1)->count();
        $data['inCorrectAnswer'] =$data['progress']->where('answers','!=',[])->where('score',0)->count();
        $data['notAttempted'] =$data['progress']->where('answers',[])->count();

        return view($this->view.'.exams.student-exam-report',$data);
    }

    public function studentCalender()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $student_id = Auth::guard('student')->user()->id;
        $current_session = Session::where('status', '1')->where('current', '1')->first();

        if(isset($current_session)){
            $enroll = StudentEnroll::where('student_id', $student_id)
                            ->where('session_id', $current_session->id)
                            ->where('status', '1')
                            ->first();

            if(isset($enroll)){
                $session = $enroll->session_id;
                $semester = $enroll->semester_id;
            }
        }

        // Assignments
        if(isset($enroll) && isset($session) && isset($semester)){
            $assignments = StudentAssignment::with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($student_id, $session, $semester){
                $query->where('student_id', $student_id);
                $query->where('session_id', $session);
                $query->where('semester_id', $semester);
            });
            $assignments->with('assignment')->whereHas('assignment', function ($query){
                $query->where('start_date', '<=', Carbon::today());
            });

            $data['assignments'] = $assignments->orderBy('id', 'desc')->limit(10)->get();
            }


            // Fees
            if(isset($enroll) && isset($session) && isset($semester)){
            $fees = Fee::with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($student_id, $session, $semester){
                $query->where('student_id', $student_id);
                $query->where('session_id', $session);
                $query->where('semester_id', $semester);
            });

            $data['fees'] = $fees->orderBy('assign_date', 'desc')->limit(10)->get();
            }


            // Events
            // $data['events'] = Event::where('status', '1')->orderBy('id', 'asc')->get();
            // $data['latest_events'] = Event::where('status', '1')
            //                     ->where('end_date', '>=', Carbon::today())
            //                     ->orderBy('start_date', 'asc')
            //                     ->limit(10)
            //                     ->get();
            $eventIds = EventUser::where('user_id',Auth::guard('student')->user()->id)->pluck('event_id')->toArray();
            $data['events'] = Event::where('status','1')->where('role_id', 0)
                            ->where(function ($query) use ($eventIds) {
                                    $query->where('is_default', 1)
                                        ->orWhereIn('id', $eventIds);
                            })
                            ->orderBy('id', 'asc')->get();
            $data['latest_events'] = Event::where('status', '1')
                                ->where('role_id', 0)
                                ->where(function ($query) use ($eventIds) {
                                    $query->where('is_default', 1)
                                        ->orWhereIn('id', $eventIds);
                                })
                                ->where('end_date', '>=', Carbon::today())
                                ->orderBy('start_date', 'asc')
                                ->get();
            return view($this->view.'.calendar.student-calendar', $data);
    }

    public function studentClassRouting()
    {
        return view($this->view.'.class-routing.student-class-routing');
    }

    public function studentExamRouting()
    {
        return view($this->view.'.exam-routing.student-exam-routing');
    }

    public function studentAttendence()
    {
        return view($this->view.'.attendance.student-attendance');
    }

    public function studentApplyLeave()
    {
        return view($this->view.'.apply-leave.student-apply-leave');
    }

    public function studentLibrary()
    {
        return view($this->view.'.library.student-library');
    }

    public function studentNotices()
    {
        return view($this->view.'.notice.student-notice');
    }

    public function studentAssignments()
    {
        return view($this->view.'.assignment.student-assignment');
    }

    public function studentDownload()
    {
        return view($this->view.'.download.student-download');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;


        $student_id = Auth::guard('student')->user()->id;
        $current_session = Session::where('status', '1')->where('current', '1')->first();

        if(isset($current_session)){
            $enroll = StudentEnroll::where('student_id', $student_id)
                            ->where('session_id', $current_session->id)
                            ->where('status', '1')
                            ->first();

            if(isset($enroll)){
                $session = $enroll->session_id;
                $semester = $enroll->semester_id;
            }
        }


        // Assignments
        if(isset($enroll) && isset($session) && isset($semester)){
        $assignments = StudentAssignment::with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($student_id, $session, $semester){
            $query->where('student_id', $student_id);
            $query->where('session_id', $session);
            $query->where('semester_id', $semester);
        });
        $assignments->with('assignment')->whereHas('assignment', function ($query){
            $query->where('start_date', '<=', Carbon::today());
        });

        $data['assignments'] = $assignments->orderBy('id', 'desc')->limit(10)->get();
        }


        // Fees
        if(isset($enroll) && isset($session) && isset($semester)){
        $fees = Fee::with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($student_id, $session, $semester){
            $query->where('student_id', $student_id);
            $query->where('session_id', $session);
            $query->where('semester_id', $semester);
        });

        $data['fees'] = $fees->orderBy('assign_date', 'desc')->limit(10)->get();
        }


        // Events
        $data['events'] = Event::where('status', '1')->orderBy('id', 'asc')->get();

        $data['latest_events'] = Event::where('status', '1')
                            ->where('end_date', '>=', Carbon::today())
                            ->orderBy('start_date', 'asc')
                            ->limit(10)
                            ->get();


        return view($this->view.'.index', $data);
    }
}
