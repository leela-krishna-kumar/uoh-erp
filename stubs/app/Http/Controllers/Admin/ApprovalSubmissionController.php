<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApprovalSubmission;
use App\Models\ApprovalSubmissionCategory;
use App\Models\Student;
use App\User;
use Illuminate\Http\Request;
use Toastr;


class ApprovalSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('approval-submissions', 1);
         $this->route = 'admin.approval-submissions';
         $this->view = 'admin.approval-submissions';
         $this->path = 'approval-submissions';
         $this->access = 'approval-submissions';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
         $this->middleware('permission:'.$this->access.'-show', ['only' => ['show']]);

     }
 
    public function index()
    {

       try{  
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['statuses'] = ApprovalSubmission::STATUSES;

        if(request()->has('approval_category_id') && request()->get('approval_category_id') != null) {
            $approvalSubmission->where('approval_category_id',request()->get('approval_category_id'));
        }
        $data['approvalSubmissionCategory'] = ApprovalSubmissionCategory::get();
        $approvalSubmission = ApprovalSubmission::query();
        
        if(request()->has('status') && request()->has('status')){
            $approvalSubmission->where('status', $request->get('status'));

        }
        $data['rows'] = $approvalSubmission->orderBy('id', 'desc')->get();
       
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
        try{
            
           
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = ApprovalSubmission::STATUSES;
            
           $users = Student::get()->name;
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
            // Field Validation
            $request->validate([
               
            ]);

            // Insert Data
            $approvalSubmission = new ApprovalSubmission;
            $approvalSubmission->note = $request->note;
            $approvalSubmission->comment = $request->comment;
            $approvalSubmission->status = $request->status;
            $approvalSubmission->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect('admin/approval-submissions');
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        } 
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApprovalSubmission  $approvalSubmission
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalSubmission $approvalSubmission)
    {
        // return $approvalSubmission;
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['statuses'] = ApprovalSubmission::STATUSES;
        $data['teachers'] = User::role('Teacher')->select('id','first_name','last_name')->get();
        $data['row'] = $approvalSubmission;
        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApprovalSubmission  $approvalSubmission
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovalSubmission $approvalSubmission , Request $request)
    {
        // return $request->all();
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = ApprovalSubmission::STATUSES;
            $data['teachers'] = User::role('Teacher')->select('id','first_name','last_name')->get();

            $data['row'] = $approvalSubmission;
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
     * @param  \App\Models\ApprovalSubmission  $approvalSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApprovalSubmission $approvalSubmission)
    {
        try{
            // Field Validation
            $request->validate([
                'note' => 'required',
            ]);
            $approvalSubmission->note = $request->note;
            $approvalSubmission->user_id = auth()->id();
            $approvalSubmission->approver_id = $request->approver_id;
            $approvalSubmission->status = ApprovalSubmission::STATUS_INREVIEW;
            $approvalSubmission->link = $request->link;
            $approvalSubmission->comment = $request->comment;
            $approvalSubmission->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect('admin/approval-submissions')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApprovalSubmission  $approvalSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalSubmission $approvalSubmission)
    {
  
        try{
            $approvalSubmission;
            if ($approvalSubmission) {
                 $approvalSubmission->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
    public function updateApproval(Request $request, $id)
    {
        try{
            $request->validate([
                'status' => 'required',  
            ]);
            
        $approvalSubmission = ApprovalSubmission::where('id', $id)->first();
        $approvalSubmission->comment = $request->comment;
        $approvalSubmission->status = $request->status;
        $approvalSubmission->save(); 
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/approval-submissions')->with( __('msg_success'), __('msg_updated_successfully'));
    }
    catch(\Exception $e){

        Toastr::error(__('msg_updated_error'), __('msg_error'));

        return redirect()->back();
    } 
 }       
    
}
