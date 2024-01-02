<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\StudentReportCategory;
use Illuminate\Http\Request;
use Toastr;

class StudentReportCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_student_report_category', 1);
         $this->route = 'admin.student-report-category';
         $this->view = 'admin.student-report-category';
         $this->path = 'student-report-category';
         $this->access = 'student-report-category';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
     }
    public function index()
    {
        
        // try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $studentReportCategories = StudentReportCategory::query();
            $data['rows'] = $studentReportCategories->orderBy('id', 'desc')->get();
            return view($this->view.'.index', $data);
        // } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        // }
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
        // try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            // Insert Data
            $studentReprotCategory = new StudentReportCategory;
            $studentReprotCategory->name = $request->name;
            $studentReprotCategory->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->back();
        // } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentReportCategory  $studentReportCategory
     * @return \Illuminate\Http\Response
     */
    public function show(StudentReportCategory $studentReportCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentReportCategory  $studentReportCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentReportCategory $studentReportCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentReportCategory  $studentReportCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentReportCategory $studentReportCategory)
    {
        // try{
            // Field Validation
            // return $request->all();
            $request->validate([
                'name' => 'required',
            ]);
            $studentReportCategory->name = $request->name;
            $studentReportCategory->save();
            
            // Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        // }
        // catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        // }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentReportCategory  $studentReportCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentReportCategory $studentReportCategory)
    {
        try{
            if($studentReportCategory){
                $studentReportCategory->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}