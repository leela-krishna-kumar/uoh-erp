<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use App\Models\FeesCategory;
use App\Models\FeesMaster;
use App\Models\SeatType;
use App\Models\FeesTypeMaster;
use App\Models\Semester;
use App\Models\Program;
use App\Models\Section;
use App\Models\Session;
use App\Models\Faculty;
use App\Models\Fee;
use Toastr;
use Auth;
use DB;

class FeesTypeMasterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_fees_type_master', 1);
        $this->route = 'admin.fees-type-master';
        $this->view = 'admin.fees-type-master';
        $this->path = 'fees-type-master';
        $this->access = 'fees-type-master';


        $this->middleware('permission:'.$this->access.'-view', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
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


        if(!empty($request->year) || $request->year != null){
            $data['selected_year'] = $year = $request->year;
        }
        else{
            $data['selected_year'] = '0';
        }
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

        if(!empty($request->seat_type_id) || $request->seat_type_id != null){
            $data['selected_seat_type'] = $seat_type_id = $request->seat_type_id;
        }
        else{
            $data['selected_seat_type'] = '0';
        }
        
        $data['seat_types'] = SeatType::orderBy('name', 'asc')->get();

        if(!empty($request->program) && !empty($request->faculty) && !empty($request->session) && !empty($request->seat_type_id)){
            $data['rows'] = FeesCategory::where('status',1)
                                        // ->where('department_id', '<>', '24' )
                                        // ->where('department_id', '<>', '39' )
                                        ->orderBy('title', 'asc')->get();
        }

        // Filter Search
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['categories'] = FeesCategory::where('status', '1')
                                        ->where('department_id', '<>', '24' )
                                        ->where('department_id', '<>', '39' )
                                        ->orderBy('title', 'asc')
                                        ->get();

      //  dd($data['categories']);


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


        // Filter Fees
        $masters = FeesTypeMaster::where('id', '!=', 0);
        if(!empty($request->faculty) && $request->faculty != '0'){
            $masters->where('faculty_id', $faculty);
        }
        if(!empty($request->program) && $request->program != '0'){
            $masters->where('program_id', $program);
        }
        if(!empty($request->session) && $request->session != '0'){
            $masters->where('session_id', $session);
        }
        if(!empty($request->semester) && $request->semester != '0'){
            $masters->where('semester_id', $semester);
        }
        if(!empty($request->section) && $request->section != '0'){
            $masters->where('section_id', $section);
        }
        if(!empty($request->category) && $request->category != '0'){
            $masters->where('category_id', $category);
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
        // $data['categories'] = FeesCategory::where('status', '1')->orderBy('title', 'asc')->get();
        $data['seat_types'] = SeatType::orderBy('name', 'asc')->get();


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

       // dd($request->all());

        //Validation
        $request->validate([
            'fees_types' => 'required',
            'faculty' => 'required',
            'program' => 'required',
            'session' => 'required',
            'year' => 'required|numeric',
            'seat_type_id' => 'required|numeric',
        ]);
        
        try{
            DB::beginTransaction();
            $feesTypes = $request->fees_types;

            $feesTypeMaster = FeesTypeMaster::where('faculty_id', $request->faculty)
            ->where('program_id', $request->program)
            ->where('session_id', $request->session)
            ->where('seat_type_id', $request->seat_type_id)
            ->get();

            foreach($feesTypeMaster as $feesType){
                $feesType->delete();
            }


            foreach($feesTypes as $feeType){
                $feesTypeMaster = new FeesTypeMaster;
                $feesTypeMaster->fees_type_id = $feeType['fees_type_id'];
                $feesTypeMaster->faculty_id = $request->faculty;
                $feesTypeMaster->program_id = $request->program;
                $feesTypeMaster->session_id = $request->session;
                // $feesTypeMaster->semester_id = $request->semester;
                $feesTypeMaster->seat_type_id = $request->seat_type_id;
                $feesTypeMaster->amount = $feeType['amount'];
                $feesTypeMaster->year = $request->year;
                $feesTypeMaster->save();
            }


            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->view.'.index');
        }
        catch(\Exception $e){

            dd($e);

            Toastr::error(__('msg_created_error'), __('msg_error'));

            return redirect()->back();
        }
    }
}
