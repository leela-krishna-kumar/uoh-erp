<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrievanceCategory;
use Illuminate\Http\Request;
use Toastr;

class GrievanceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_grievance_category',1);
        $this->route = 'admin.grievance-category';
        $this->view = 'admin.grievance-category';
        $this->path = 'grievance-category';
        $this->access = 'grievance-category';


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
            $projectCategories = GrievanceCategory::query();
            $data['rows'] = $projectCategories->orderBy('id', 'desc')->select('id','name')->get();
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
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            // Insert Data
            $grievanceCategory = new GrievanceCategory;
            $grievanceCategory->name = $request->name;
            $grievanceCategory->save();
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
     * @param  \App\Models\GrievanceCategory  $grievanceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(GrievanceCategory $grievanceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GrievanceCategory  $grievanceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(GrievanceCategory $grievanceCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GrievanceCategory  $grievanceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrievanceCategory $grievanceCategory)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $grievanceCategory->name = $request->name;
            $grievanceCategory->save();
            
            // Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GrievanceCategory  $grievanceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrievanceCategory $grievanceCategory)
    {
        try{
            if($grievanceCategory){
                $grievanceCategory->delete();
            }
            
            // Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
