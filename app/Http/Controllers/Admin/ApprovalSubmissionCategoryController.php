<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\ApprovalSubmissionCategory;
use Illuminate\Http\Request;
use Toastr;

class ApprovalSubmissionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
        {
            // Module Data
            $this->title = 'Approval Submission Category';
            $this->route = 'admin.approval-submissions-category';
            $this->view = 'admin.approval-submissions-category';
            $this->path = 'approval-submissions-category';
            $this->access = 'approval-submissions-category';
    
    
            $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
            $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
            $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
            $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        }
    public function index()
    {
        //  try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $approvalSubmissionCategory = ApprovalSubmissionCategory::query();
            $data['rows'] = $approvalSubmissionCategory->orderBy('id', 'desc')->get();
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
            $existRecord = ApprovalSubmissionCategory::where('name',$request->name)->first();
            if($existRecord){
                Toastr::error(__('msg_name_already_exists'), __('msg_error'));
                return redirect()->back();
            }
            // Insert Data
            $approvalSubmissionCategory = new ApprovalSubmissionCategory;
            $approvalSubmissionCategory->name = $request->name;
            $approvalSubmissionCategory->type = $request->type;
            $approvalSubmissionCategory->description = $request->description;
            $approvalSubmissionCategory->save();
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
     * @param  \App\Models\ApprovalSubmissionCategory  $approvalSubmissionCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalSubmissionCategory $approvalSubmissionCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApprovalSubmissionCategory  $approvalSubmissionCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovalSubmissionCategory $approvalSubmissionCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApprovalSubmissionCategory  $approvalSubmissionCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        
        // try{
            // Field Validation
            // return $request->all();
            $request->validate([
                'name' => 'required|unique:approval_submission_categories,name,'.$id,
            ]);
            $approvalSubmissionCategory = ApprovalSubmissionCategory::find($id);

            $approvalSubmissionCategory->name = $request->name;
            $approvalSubmissionCategory->type = $request->type;
            $approvalSubmissionCategory->description = $request->description;
            $approvalSubmissionCategory->save();
            
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
     * @param  \App\Models\ApprovalSubmissionCategory  $approvalSubmissionCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        
        try{
            $approvalSubmissionCategory = ApprovalSubmissionCategory::find($id);
            if($approvalSubmissionCategory){
                $approvalSubmissionCategory->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
    public function submissionVariable(ApprovalSubmissionCategory $approvalSubmissionCategory)
    {
       return $request->all();
    }
}
