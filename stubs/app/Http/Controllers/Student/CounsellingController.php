<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Counselling;
use App\Models\CounsellingCategory;
use App\Models\Student;
use App\Models\Program;
use Illuminate\Http\Request;
use Toastr;

class CounsellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_counselling', 1);
        $this->route = 'student.counselling';
        $this->view = 'student.counselling';
        $this->path = 'student-counselling';
        $this->access = 'student-counselling';

    }

    public function index(Request $request)
    {
        try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;

            $counselings = Counselling::query();

            $data['rows'] = $counselings->where('type',Student::class)->where('type_id',auth()->id())->get();
            $data['categories'] = CounsellingCategory::orderBy('name', 'asc')->select('name','id')->get();
            return view($this->view.'.index', $data);
        } catch(\Exception $e){

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'counselling_category_id' => 'required',
        ]);
        // Insert Data
        $student = Student::where('id',auth()->id())->select('id','program_id')->first();
        $program = Program::where('id',$student->program_id)->first();
        
        $counselling = new Counselling;
        $counselling->program_id = $student->program_id;
        $counselling->faculty_id = $program->faculty_id;
        $counselling->session_id = $request->session;
        $counselling->semester_id = $request->semester;
        $counselling->section_id = $request->section;
        $counselling->date = $request->date;
        $counselling->time = $request->time;
        $counselling->note = $request->note;
        $counselling->status = Counselling::STATUS_REQUESTED;
        $counselling->counselling_category_id = $request->counselling_category_id;
        $counselling->type = Student::class;
        $counselling->type_id = $student->id;
        $counselling->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Counselling  $counselling
     * @return \Illuminate\Http\Response
     */
    public function show(Counselling $counselling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Counselling  $counselling
     * @return \Illuminate\Http\Response
     */
    public function edit(Counselling $counselling)
    {
   
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Counselling  $counselling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Counselling $counselling)
    {
        try{
                // Field Validation
            $request->validate([
                'date' => 'required',
                'time' => 'required',
            ]);
            // Update Data
            $counselling->date = $request->date;
            $counselling->time = $request->time;
            $counselling->note = $request->note;
            $counselling->counselling_category_id = $request->counselling_category_id;
            $counselling->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Counselling  $counselling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counselling $counselling)
    {
        try{
            if($counselling){
                $counselling->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
