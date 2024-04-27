<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PlacedStudent;
use App\Models\Placement;
use App\Models\Student;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\StudentEnroll;
use App\Models\Faculty;
use App\Models\StatusType;
use App\Models\Batch;
use App\Models\Semester;
use App\User;
use Illuminate\Http\Request;
use Toastr;

class PlacedStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_placed-student', 1);
        $this->route = 'admin.placed-student';
        $this->view = 'admin.placed-student';
        $this->path = 'placed-student';
        $this->access = 'placed-student';

        $this->middleware('permission:' . $this->access . '-view|' . $this->access . '-create|' . $this->access . '-edit|' . $this->access . '-delete|' . $this->access . '-card', ['only' => ['index', 'show', 'status', 'sendPassword']]);
        $this->middleware('permission:' . $this->access . '-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:' . $this->access . '-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:' . $this->access . '-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $placedStudent = PlacedStudent::query();
            $data['placement'] = Placement::where('id', request()->get('placement_id'))
                ->select('company_id')
                ->first();
            $data['rows'] = $placedStudent
                ->where('placement_id', request()->get('placement_id'))
                ->orderBy('id', 'desc')
                ->get();

            // return $data['rows'];
            return view($this->view . '.index', $data);
        } catch (\Exception $e) {
            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
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
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['students'] = Student::get();
        $data['statuses'] = PlacedStudent::STATUSES;
        if (!empty($request->faculty) || $request->faculty != null) {
            $data['selected_faculty'] = $faculty = $request->faculty;
        } else {
            $data['selected_faculty'] = '0';
        }

        if (!empty($request->session) || $request->session != null) {
            $data['selected_session'] = $session = $request->session;
        } else {
            $data['selected_session'] = '0';
        }

        if (!empty($request->program) || $request->program != null) {
            $data['selected_program'] = $program = $request->program;
        } else {
            $data['selected_program'] = '0';
        }

        if (!empty($request->semester) || $request->semester != null) {
            $data['selected_semester'] = $semester = $request->semester;
        } else {
            $data['selected_semester'] = '0';
        }

        if (!empty($request->section) || $request->section != null) {
            $data['selected_section'] = $section = $request->section;
        } else {
            $data['selected_section'] = '0';
        }
        // Filter Search
        $data['faculties'] = Faculty::where('status', '1')
            ->orderBy('title', 'asc')
            ->get();

        if (!empty($request->faculty) && $request->faculty != '0') {
            $data['programs'] = Program::where('faculty_id', $faculty)
                ->where('status', '1')
                ->orderBy('title', 'asc')
                ->get();
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

        // Filter Student
        if (isset($request->faculty) || isset($request->program)) {
            $enrolls = StudentEnroll::where('status', '1');

            if (!empty($request->faculty) && $request->faculty != '0') {
                $enrolls->with('program')->whereHas('program', function ($query) use ($faculty) {
                    $query->where('faculty_id', $faculty);
                });
            }
            if (!empty($request->program) && $request->program != '0') {
                $enrolls->where('program_id', $program);
            }
            if (!empty($request->session) && $request->session != '0') {
                $enrolls->where('session_id', $session);
            }
            if (!empty($request->semester) && $request->semester != '0') {
                $enrolls->where('semester_id', $semester);
            }
            if (!empty($request->section) && $request->section != '0') {
                $enrolls->where('section_id', $section);
            }

            $enrolls->with('student')->whereHas('student', function ($query) {
                $query->where('status', '1');
                $query->orderBy('student_id', 'asc');
            });

            $data['rows'] = $enrolls->get();
        }
        return view('admin.placed-student.create', $data);
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
        try {
            if (is_array($request->student_id) && count($request->student_id) > 0 ){
                foreach($request->student_id as $student){
                    $placedStudent = new PlacedStudent();
                    $placedStudent->placement_id = $request->placement_id;
                    $placedStudent->student_id = $student;
                    $placedStudent->status = $request->status;
                    $placedStudent->note = $request->note;
                    $placedStudent->package = $request->package;
                    $placedStudent->save();
                }
            }
            // Insert Data
            // $placedStudent = new PlacedStudent();
            // $placedStudent->placement_id = $request->placement_id;
            // $placedStudent->student_id = $request->student_id;
            // $placedStudent->status = $request->status;
            // $placedStudent->note = $request->note;
            // $placedStudent->package = $request->package;
            // $placedStudent->save();
            // return  $placedStudent;
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->route . '.index', ['placement_id' => $request->placement_id]);
        } catch (\Exception $e) {
            return $e;
            Toastr::error(__('msg_updated_error'), __('msg_error'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlacedStudent  $placedStudent
     * @return \Illuminate\Http\Response
     */
    public function show(PlacedStudent $placedStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlacedStudent  $placedStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(PlacedStudent $placedStudent)
    {
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['students'] = Student::get();
            $data['statuses'] = PlacedStudent::STATUSES;
            $data['row'] = $placedStudent;
            return view($this->view . '.edit', $data);
        } catch (\Exception $e) {
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlacedStudent  $placedStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlacedStudent $placedStudent)
    {
        try {
            // Field Validation
            // return $request->all();
            $placedStudent->placement_id = $placedStudent->placement_id;
            $placedStudent->status = $request->status;
            $placedStudent->note = $request->note;
            $placedStudent->package = $request->package;
            $placedStudent->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->route($this->route . '.index', ['placement_id' => $placedStudent->placement_id]);
        } catch (\Exception $e) {
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlacedStudent  $placedStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlacedStudent $placedStudent)
    {
        try {
            if ($placedStudent) {
                $placedStudent->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
    public function studentsList(Request $request)
    {
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;

            if(!empty($request->from_date) || $request->from_date != null){
                $data['selected_from_date'] = $from_date = $request->from_date;
            }
            else{
                $data['selected_from_date'] = $from_date = '';
            }
            
            if(!empty($request->to_date) || $request->to_date != null){
                $data['selected_to_date'] = $to_date = $request->to_date;
            }
            else{
                $data['selected_to_date'] = $to_date = '';
            }
            // return $request->all();
            $placedStudent = PlacedStudent::query();
            if (!empty($request->from_date) && !empty($request->to_date)){
                $placedStudent = $placedStudent->whereBetween('created_at', [$from_date . ' 00:00:00', $to_date . ' 23:59:59']);
            }
          
            $data['rows'] = $placedStudent
                // ->where('placement_id', request()->get('placement_id'))
                ->orderBy('id', 'desc')
                ->get();

            // return $data['rows'];
            return view($this->view . '.student-list', $data);
        } catch (\Exception $e) {
            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
        
    }
}
