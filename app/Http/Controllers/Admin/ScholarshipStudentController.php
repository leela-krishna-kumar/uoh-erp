<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ScholarshipStudent;
use App\Models\Scholarship;
use App\Models\Student;
use Illuminate\Http\Request;
use Toastr;
class ScholarshipStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
         // Module Data
         $this->title = trans_choice('module_scholarship-student', 1);
         $this->route = 'admin.scholarship-student';
         $this->view = 'admin.scholarship-student';
         $this->path = 'scholarship-student';
         $this->access = 'scholarship-student';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {   

        // Checking Scholarship
        if(!Scholarship::whereId($request->scholarship_id)->first()){
            Toastr::error(__('error_404_title'));
            return redirect()->back();
        }

        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['statuses'] = ScholarshipStudent::STATUSES;
        $data['scholarship'] = Scholarship::select('id','title')->where('id',request()->get('scholarship_id'))->first();
        $scholarshipStudent = ScholarshipStudent::query();
        $data['rows'] = $scholarshipStudent->where('scholarship_id',$request->scholarship_id)->orderBy('id', 'desc')->get();
        return view($this->view.'.index', $data); 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = ScholarshipStudent::STATUSES;
            $data['students'] = Student::get();

            return view($this->view.'.create', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        try{
            // return $request->all();
            $request->validate([
                  'scholarship_id'=>'required',
                  'student_id'=>'required',
                  'amount'=>'required',
                  'note'=>'required',
                  'status'=>'required',
            ]);

            // Insert Data
            $scholarshipStudent = new ScholarshipStudent;
            $scholarshipStudent->scholarship_id = $request->scholarship_id;
            $scholarshipStudent->student_id = $request->student_id;
            $scholarshipStudent->amount = $request->amount;
            $scholarshipStudent->note = $request->note;
            $scholarshipStudent->date = $request->date;
            $scholarshipStudent->status = $request->status;
            $scholarshipStudent->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScholarshipStudent  $scholarshipStudent
     * @return \Illuminate\Http\Response
     */
    public function show(ScholarshipStudent $scholarshipStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScholarshipStudent  $scholarshipStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(ScholarshipStudent $scholarshipStudent)
    {
        //
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = ScholarshipStudent::STATUSES;
            $data['students'] = Student::get();
            $data['row'] = $scholarshipStudent;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_successfully'), __('msg_error'));

            return redirect()->back();
        } 

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScholarshipStudent  $scholarshipStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScholarshipStudent $scholarshipStudent)
    {
        
        try{
            $scholarshipStudent->student_id = $request->student_id;
            $scholarshipStudent->amount = $request->amount;
            $scholarshipStudent->note = $request->note;
            $scholarshipStudent->date = $request->date;
            $scholarshipStudent->status = $request->status;
            $scholarshipStudent->save();
          
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect('admin/scholarship-student'."?scholarship_id=$scholarshipStudent->scholarship_id")->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScholarshipStudent  $scholarshipStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScholarshipStudent $scholarshipStudent)
    {
        //
        try{
            $scholarshipStudent;
            if ($scholarshipStudent) {
                 $scholarshipStudent->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
