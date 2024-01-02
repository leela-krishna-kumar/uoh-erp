<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\User;
use App\Models\Education;
use App\Models\EnrollSubject;
use App\Models\StudentEnroll;
use Toastr;
use Auth;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'student_id' => 'required|numeric',
        // ]);
        try {
            
            $education = new Education();
            if(isset($request->user_id)){
                $education->model_id = $request->user_id;
                $education->model_type = User::class;
            }else{
                $education->model_id = $request->student_id;
                $education->model_type = Student::class;
                $education->education_type = $request->education_type;
            }
            $education->payload = $request->payload;
            $education->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        } catch (\Throwable $th) {
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }
    public function updateAcademicInfo(Request $request)
    {
        // return $request->all();
        $request->validate([
            'student_id' => 'required|numeric',
            'batch' => 'required',
            'program' => 'required',
            'semester' => 'required',
            'section' => 'required',
            'session' => 'required',
            'faculty' => 'required',
        ]);
        try {
                if ($request->managed_by !== null) {
                    $managed_by = array_map(function ($arr) {
                        return intval($arr);
                    }, $request->managed_by);
                } else {
                    $managed_by = []; 
                }
                $student = Student::where('id',$request->student_id)->first();
            
            // Enroll Subject
                // Duplicate Enroll Check
                $duplicate_check = StudentEnroll::where('student_id', $student->id)->where('session_id', $request->session)->where('semester_id', $request->semester)->where('section_id', $request->section)->first();
                $session_check = StudentEnroll::where('student_id', $student->id)->where('session_id', $request->session)->first();
                // $semester_check = StudentEnroll::where('student_id', $student->id)->where('semester_id', $request->semester)->first();

                if(!isset($duplicate_check) && !isset($session_check)){
                    // Pre Enroll Update
                    $pre_enroll = StudentEnroll::where('student_id', $student->id)->where('status', '1')->first();
                    if(isset($pre_enroll)){
                        $pre_enroll->status = '0';
                        $pre_enroll->save();
                    }

                    // Student New Enroll
                    $enroll = new StudentEnroll;
                    $enroll->student_id = $student->id;
                    $enroll->program_id = $request->program;
                    $enroll->session_id = $request->session;
                    $enroll->semester_id = $request->semester;
                    $enroll->section_id = $request->section;
                    $enroll->created_by = Auth::guard('web')->user()->id;
                    $enroll->save();
                    $enroll;

                    // Attach Subject
                    $enroll->subjects()->attach($request->subject);
                }    
                    // Update Student Academic Data
                $student->update([
                    'batch_id' => $request->batch,
                    'program_id' => $request->program,
                    'group_id' => $request->group_id,
                    'faculty_id' => $request->faculty,
                    'session_id' => $request->session,
                    'semester_id' => $request->semester,
                    'section_id' => $request->section,
                    'managed_by' => $managed_by,
                    'status' => $request->status,
                ]);
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        } catch (\Throwable $th) {
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Education $education)
    {

       try {
            if(!$education){
                return redirect()->back('error','Data Not Found!');
            }
            $education->payload = $request->payload;
            $education->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        } catch (\Throwable $th) {
            Toastr::error(__('msg_updated_error'), __('msg_error'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Education $education)
    {
        if(!$education){
            return redirect()->back('error','Data Not Found!');
        }
        $education->delete();
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
