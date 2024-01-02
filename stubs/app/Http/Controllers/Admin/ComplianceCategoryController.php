<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplianceCategory;
use Illuminate\Http\Request;
use Toastr;

class ComplianceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_compliance_category', 1);
        $this->route = 'admin.compliance-category';
        $this->view = 'admin.compliance-category';
        $this->path = 'compliance-category';
        $this->access = 'compliance-category';


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
            $complianceCategories = ComplianceCategory::query();
            $data['rows'] = $complianceCategories->orderBy('id', 'desc')->get();
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
            $complianceCategory = new ComplianceCategory;
            $complianceCategory->name = $request->name;
            $complianceCategory->save();
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
     * @param  \App\Models\ComplianceCategory  $complianceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ComplianceCategory $complianceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComplianceCategory  $complianceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ComplianceCategory $complianceCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComplianceCategory  $complianceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComplianceCategory $complianceCategory)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $complianceCategory->name = $request->name;
            $complianceCategory->save();
            
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
     * @param  \App\Models\ComplianceCategory  $complianceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplianceCategory $complianceCategory)
    {
        try{
            if($complianceCategory){
                $complianceCategory->delete();
            }
            
            // Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
