<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Grievance;
use Carbon\Carbon;
use Toastr;
use Auth;
use App\Models\GrievanceCategory;
use App\Models\Department;


class GrievanceController extends Controller
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
        $this->title = trans_choice('module_grievance', 1);
        $this->route = 'student.grievance';
        $this->view = 'student.grievance';
        $this->path = 'grievance';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['rows'] = StudentLeave::where('student_id', Auth::guard('student')->user()->id)->orderBy('id', 'desc')->get();

        return view($this->view.'.index', $data);
    }
    
    public function studentGrievance()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['rows'] = Grievance::where('user_id', Auth::guard('student')->user()->id)->orderBy('id', 'desc')->get();
        $data['categories'] = GrievanceCategory::orderBy('name', 'asc')->select('name','id')->get();
        $data['departments'] = Department::orderBy('title', 'asc')->select('title','id')->get();
        return view($this->view.'.student-grievance', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

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
            'category_id' => 'required',
            'department_id' => 'required',
            'description' => 'required',
        ]);
        //Insert Data
        $grievance = new Grievance;
        $grievance->user_id = Auth::guard('student')->id();
        $grievance->category_id = $request->category_id;
        $grievance->department_id = $request->department_id;
        $grievance->description = $request->description;
        $grievance->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentLeave  $studentLeave
     * @return \Illuminate\Http\Response
     */
    public function show(StudentLeave $studentLeave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentLeave  $studentLeave
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentLeave $studentLeave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentLeave  $studentLeave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentLeave $studentLeave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentLeave  $studentLeave
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $studentLeave = StudentLeave::findOrFail($id);

        if($studentLeave->status == 0){
        // Delete Attach
        $this->deleteMedia($this->path, $studentLeave);

        // Delete data
        $studentLeave->delete();

            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        }
        else{
            Toastr::error(__('msg_deleted_fail'), __('msg_error'));
        }

        return redirect()->back();
    }
}
