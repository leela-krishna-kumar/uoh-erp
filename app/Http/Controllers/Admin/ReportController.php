<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventCategory;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Session;
use App\Models\StatusType;
use App\Models\Student;
use App\Models\StudentAttendance;

use Spatie\Permission\Models\Role;

use App\Models\StaffAttendance;
use App\Models\WorkShiftType;
use App\Models\Designation;
use App\Models\Department;
use App\Models\ExamType;
use Carbon\Carbon;
use App\User;
use Toastr;
use Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = 'Student Attendence Report';
        $this->route = 'admin.report.student-attendence';
        $this->view = 'admin.reports.student_attendence';
        $this->path = 'student-attendence';
        $this->access = 'student-management-view';


        $this->middleware('permission:' . $this->access . '-view|' . $this->access . '-create|' . $this->access . '-edit|' . $this->access . '-delete|' . $this->access . '-card', ['only' => ['index', 'show', 'status', 'sendPassword']]);
        $this->middleware('permission:' . $this->access . '-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:' . $this->access . '-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:' . $this->access . '-delete', ['only' => ['destroy']]);
        $this->middleware('permission:' . $this->access . '-password-print', ['only' => ['printPassword']]);
        $this->middleware('permission:' . $this->access . '-password-change', ['only' => ['passwordChange']]);
        $this->middleware('permission:' . $this->access . '-card', ['only' => ['index', 'card']]);
    }
    public function studentAttendence(Request $request){

        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['rows'] = [];

        if (!empty($request->faculty) || $request->faculty != null) {
            $data['selected_faculty'] = $faculty = $request->faculty;
        } else {
            $data['selected_faculty'] = $faculty = '0';
        }

        if (!empty($request->program) || $request->program != null) {
            $data['selected_program'] = $program = $request->program;
        } else {
            $data['selected_program'] = $program = '0';
        }

        if (!empty($request->session) || $request->session != null) {
            $data['selected_session'] = $session = $request->session;
        } else {
            $data['selected_session'] = $session = '0';
        }

        // if (!empty($request->semester) || $request->semester != null) {
        //     $data['selected_semester'] = $semester = $request->semester;
        // } else {
        //     $data['selected_semester'] = $semester = '0';
        // }

        // if (!empty($request->section) || $request->section != null) {
        //     $data['selected_section'] = $section = $request->section;
        // } else {
        //     $data['selected_section'] = $section = '0';
        // }

        if (!empty($request->date) || $request->date != null) {
            $data['selected_date'] = $date = $request->date;
        } else {
            $data['selected_date'] = '2024-03-08';
        }


        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();


        if (!empty($request->faculty) && $request->faculty != '0') {
            $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        }

        if (!empty($request->program) && $request->program != '0') {
            $sessions = Session::where('status', 1);
            $sessions->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['sessions'] = $sessions->orderBy('id', 'desc')->get();
        }

        
        $data['student_data'] = [];
        $data['graph_count'] = 0;
        $data['program_title'] = null;
        $data['std_attendence_data_p_c'] = 0;
        $data['std_attendence_data_a_c'] = 0;
        

        if(!empty($request->faculty) && $request->faculty != '0' && !empty($request->program) && $request->program != '0'){

            $data['program'] = $program = Program::find($request->program);

            $data['program_title'] = $program->title;

            $data['student_data'] = $student_data = Student::select('semester_id')->where('faculty_id', $request->faculty)->where('program_id', $request->program)->where('session_id', $request->session);

            $data['student_data'] = $student_data->get();

            $data['student_ids'] = $student_ids = $student_data->get()->pluck('id')->toArray();

            $semester_ids =  $student_data->distinct('semester_id')->pluck('semester_id');

            $data['graph_count'] = count($semester_ids);


            // $data['std_attendence_data_p_c'] = StudentAttendance::where('attendance', '1')->whereIn('student_enroll_id', $student_ids)->count();
            // $data['std_attendence_data_p_c'] = 145;
            // $data['std_attendence_data_a_c'] = StudentAttendance::select('attendance')->where('attendance', '2')->count();

            $data['std_attendence_data_p_c'] = rand(1,200);
            $data['std_attendence_data_a_c'] = rand(1,30);

        //    dd($data['student_data']);
        }


        return view('admin.reports.student_attendence', $data);
    }

    public function examResults(Request $request){

        $data['title'] = $this->title;
        $data['route'] = 'admin.report.exam-results';
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['rows'] = [];

        if (!empty($request->faculty) || $request->faculty != null) {
            $data['selected_faculty'] = $faculty = $request->faculty;
        } else {
            $data['selected_faculty'] = $faculty = '0';
        }

        if (!empty($request->program) || $request->program != null) {
            $data['selected_program'] = $program = $request->program;
        } else {
            $data['selected_program'] = $program = '0';
        }

        if (!empty($request->session) || $request->session != null) {
            $data['selected_session'] = $session = $request->session;
        } else {
            $data['selected_session'] = $session = '0';
        }

        if(!empty($request->semester) || $request->semester != null){
            $data['selected_semester'] = $semester = $request->semester;
        }
        else{
            $data['selected_semester'] = null;
        }

        if(!empty($request->section) || $request->section != null){
            $data['selected_section'] = $section = $request->section;
        }
        else{
            $data['selected_section'] = null;
        }


        if(!empty($request->type) || $request->type != null){
            $data['selected_type'] = $type = $request->type;
        }
        else{
            $data['selected_type'] = '0';
        }

        if (!empty($request->semester) || $request->semester != null) {
            $data['selected_semester'] = $semester = $request->semester;
        } else {
            $data['selected_semester'] = $semester = '0';
        }

        if (!empty($request->section) || $request->section != null) {
            $data['selected_section'] = $section = $request->section;
        } else {
            $data['selected_section'] = $section = '0';
        }

        if (!empty($request->date) || $request->date != null) {
            $data['selected_date'] = $date = $request->date;
        } else {
            $data['selected_date'] = '2024-03-08';
        }


        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();


        if (!empty($request->faculty) && $request->faculty != '0') {
            $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        }

        if (!empty($request->program) && $request->program != '0') {
            $sessions = Session::where('status', 1);
            $sessions->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['sessions'] = $sessions->orderBy('id', 'desc')->get();
        }

        if (!empty($request->program) && $request->program != '0') {
            $semesters = Semester::where('status', 1);
            $semesters->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['semesters'] = $semesters->orderBy('id', 'asc')->get();
        }

        if (!empty($request->program) && $request->program != '0' && !empty($request->semester) && $request->semester != '0') {
            $sections = Section::where('status', 1);
            $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester) {
                $query->where('program_id', $program);
                $query->where('semester_id', $semester);
            });
            $data['sections'] = $sections->orderBy('title', 'asc')->get();
        }

        
        $data['student_data'] = [];
        $data['graph_count'] = 0;
        $data['program_title'] = null;
        $data['std_attendence_data_p_c'] = 0;
        $data['std_attendence_data_a_c'] = 0;
        $data['graph_count'] = 0;
        

        if(!empty($request->faculty) && $request->faculty != '0' && !empty($request->program) && $request->program != '0'){

            $data['program'] = $program = Program::find($request->program);

            $data['program_title'] = $program->title;

            $data['student_data'] = $student_data = Student::select('semester_id')->where('faculty_id', $request->faculty)->where('program_id', $request->program)->where('session_id', $request->session);

            $data['student_data'] = $student_data->get();

            $data['student_ids'] = $student_ids = $student_data->get()->pluck('id')->toArray();

            $semester_ids =  $student_data->distinct('semester_id')->pluck('semester_id');

            $data['graph_count'] = count($semester_ids);


            // $data['std_attendence_data_p_c'] = StudentAttendance::where('attendance', '1')->whereIn('student_enroll_id', $student_ids)->count();
            // $data['std_attendence_data_p_c'] = 145;
            // $data['std_attendence_data_a_c'] = StudentAttendance::select('attendance')->where('attendance', '2')->count();

            $data['std_attendence_data_p_c'] = rand(1,200);
            $data['std_attendence_data_a_c'] = rand(1,30);

        //    dd($data['student_data']);

        $data['graph_count'] = 5;

        }


        $data['types'] = ExamType::all();


        return view('admin.reports.exam_results', $data);
    }


    public function staffAttendence(Request $request){

        $data['title'] = $this->title;
        $data['route'] = 'admin.report.staff-attendence';
        $data['view'] = 'admin.report.staff_attendence';
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['rows'] = [];

        
        $data['student_data'] = [];
        $data['graph_count'] = 0;
        $data['program_title'] = null;

        $data['std_attendence_data_p_c'] = 0;
        $data['std_attendence_data_a_c'] = 0;

        $data['staff_attendence_data_p_c'] = 0;
        $data['staff_attendence_data_a_c'] = 0;

        if(!empty($request->role) || $request->role != null){
            $data['selected_role'] = $role = $request->role;
        }
        else{
            $data['selected_role'] = '0';
        }

        if(!empty($request->department) || $request->department != null){
            $data['selected_department'] = $department = $request->department;
        }
        else{
            $data['selected_department'] = '0';
        }

        if(!empty($request->designation) || $request->designation != null){
            $data['selected_designation'] = $designation = $request->designation;
        }
        else{
            $data['selected_designation'] = '0';
        }

        if(!empty($request->shift) || $request->shift != null){
            $data['selected_shift'] = $shift = $request->shift;
        }
        else{
            $data['selected_shift'] = '0';
        }

        if(!empty($request->date) || $request->date != null){
            $data['selected_date'] = $date = $request->date;
        }
        else{
            $data['selected_date'] = date("Y-m-d", strtotime(Carbon::today()));
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


        $data['roles'] = Role::orderBy('name', 'asc')->get();

        if(Auth::user()->hasRole('HoD')){
            $data['departments'] = Department::where('status', '1')->where('id', Auth::user()->department_id)->orderBy('title', 'asc')->get();
        }else{
            $data['departments'] = Department::where('status', '1')->orderBy('title', 'asc')->get();
        }



        $data['designations'] = Designation::where('status', '1')->orderBy('title', 'asc')->get();
        $data['work_shifts'] = WorkShiftType::where('status', '1')->orderBy('title', 'asc')->get();


        // Filter Users
        if(!empty($request->role) || !empty($request->department) || !empty($request->designation) || !empty($request->shift) || !empty($request->date)){

            $users = User::where('salary_type', '1');

            if(!empty($request->role)){
                $users->with('roles')->whereHas('roles', function ($query) use ($role){
                    $query->where('role_id', $role);
                });
            }
            if(!empty($request->department)){
                $users->where('department_id', $department);
            }
            if(!empty($request->designation)){
                $users->where('designation_id', $designation);
            }
            if(!empty($request->shift)){
                $users->where('work_shift', $shift);
            }

            $data['rows'] = $users->where('status', '1')->orderBy('staff_id', 'asc')->get();
        }

        $data['dept_title'] = 'Computer Science & Engineering';


        // Attendances
        if(!empty($request->role) || !empty($request->department) || !empty($request->designation) || !empty($request->shift) || !empty($request->date)){

            if(!empty($request->month) && !empty($request->year)){

                $attendances = StaffAttendance::whereYear('date', $year)->whereMonth('date', $month);
            }

            if(!empty($request->role)){
                $attendances->with('user.roles')->whereHas('user.roles', function ($query) use ($role){
                    $query->where('role_id', $role);
                });
            }
            if(!empty($request->department)){
                $attendances->with('user')->whereHas('user', function ($query) use ($department){
                    $query->where('department_id', $department);
                });

                 // $data['attendances'] = $attendances->orderBy('id', 'desc')->get();
            $department = Department::find($request->department);

            $data['dept_title'] = $department->title;

            }
            if(!empty($request->designation)){
                $attendances->with('user')->whereHas('user', function ($query) use ($designation){
                    $query->where('designation_id', $designation);
                });
            }
            if(!empty($request->shift)){
                $attendances->with('user')->whereHas('user', function ($query) use ($shift){
                    $query->where('work_shift', $shift);
                });
            } 

            // $data['staff_attendence_data_p_c'] = StaffAttendance::where('attendance', '1')->count();
            // $data['staff_attendence_data_a_c'] = StaffAttendance::where('attendance', '2')->count();

            $data['staff_attendence_data_p_c'] = rand(1,200);
            $data['staff_attendence_data_a_c'] = rand(1,30);

        }


        return view('admin.reports.staff_attendence', $data);
    }

    public function studentManagement(){
        return view('admin.reports.student-management');
    }
    public function employeeStaffManagement(){
        return view('admin.reports.employee-staff-management');
    }
    public function feePaymenTracking(){
        return view('admin.reports.fee-payment-tracking');
    }
    public function hostelManagement(){
        return view('admin.reports.hostel-management');
    }
    public function payroll(){
        return view('admin.reports.payroll');
    }
    public function idCardsIssue(){
        return view('admin.reports.id-cards-issue');
    }
    public function vendorManagement(){
        return view('admin.reports.vendor-management');
    }
    public function inventoryManagement(){
        return view('admin.reports.inventory-management');
    }
    public function transportationManagement(){
        return view('admin.reports.transportation-management');
    }
    public function assetManagement(){
        return view('admin.reports.asset-management');
    }
    public function receiptsAndInvoices(){
        return view('admin.reports.receipts-and-invoices');
    }
    public function accounting(){
        return view('admin.reports.accounting');
    }
    public function dailyReports(){
        return view('admin.reports.daily-reports');
    }
    public function awardReports(){

        $data['title'] = 'Award Reports';
            // return view($this->view.'.index');
        $category = EventCategory::where('name','Award')->first();  
        $data['rows'] = Event::where('category_id',$category->id)->where('status',1)->get();  
        
        return view('admin.reports.award-reports',$data);
    }
}
