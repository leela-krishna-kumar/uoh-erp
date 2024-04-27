<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentIntake;
use Toastr;
use App\Models\Faculty;
use App\Models\Session;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class StudentIntakeController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = 'Student Intake Details';
        $this->route = 'admin.student-intake';
        $this->view = 'admin.student-intake';
        $this->path = 'student-intake';
        $this->access = 'student-intake';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $student_intake = StudentIntake::query();
            $data['rows'] = $student_intake->orderBy('id', 'desc')->get();
            return view($this->view.'.index', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));
            return redirect()->back();
        }
    }

    public function create(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $faculties = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

        // Pass both variables to the view using compact
        return view('admin.student-intake.create', $data);

    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty' => 'required',
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            'intake_count' => 'required'
        ]);

        $intake = new StudentIntake();
        $intake->faculty = $request->faculty;
        $intake->batch = $request->batch;
        $intake->program = $request->program;
        $intake->session = $request->session;
        $intake->intake_count = $request->intake_count;

        $session = Session::where('id', $request->session)->first();

        $dateRange = $session->title;
        list($fromYear, $toYear) = explode('-', $dateRange);
        $fromDate = Carbon::createFromFormat('Y-m-d', $fromYear . '-06-01')->startOfDay();
        $toDate = Carbon::createFromFormat('Y-m-d', $toYear . '-06-31')->endOfDay();

        $student_count = Student::where('faculty_id', $request->faculty)->where('batch_id', $request->batch)->where('program_id', $request->program)->where('session_id', $request->session)
        ->where('admission_date', '>=', $fromDate)->where('admission_date', '<=', $toDate)->count();

        $intake->admitted_count = $student_count;
        $intake->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $intake = StudentIntake::where('id', $id)->first();
        $intake->faculty = $request->faculty;
        $intake->batch = $request->batch;
        $intake->program = $request->program;
        $intake->session = $request->session;
        $intake->intake_count = $request->intake_count;

        $session = Session::where('id', $request->session)->first();

        $dateRange = $session->title;
        list($fromYear, $toYear) = explode('-', $dateRange);
        $fromDate = Carbon::createFromFormat('Y-m-d', $fromYear . '-06-01')->startOfDay();
        $toDate = Carbon::createFromFormat('Y-m-d', $toYear . '-06-31')->endOfDay();

        $student_count = Student::where('faculty_id', $request->faculty)->where('batch_id', $request->batch)->where('program_id', $request->program)->where('session_id', $request->session)
        ->where('admission_date', '>=', $fromDate)->where('admission_date', '<=', $toDate)->count();

        $intake->admitted_count = $student_count;
        $intake->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $intake = StudentIntake::where('id', $id)->first();
        $intake->delete();

        Toastr::success(__('msg_success'), __('Deleted Successfully'));

        return redirect()->back();
    }
}
