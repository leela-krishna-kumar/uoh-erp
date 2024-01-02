<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\Task;
use App\User;
use App\Models\Designation;
use App\Models\Department;
use App\Models\WorkShiftType;
use App\Models\Shift;

use Illuminate\Http\Request;
use Toastr;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_task', 1);
        $this->route = 'admin.task';
        $this->view = 'admin.task';
        $this->path = 'task';
        $this->access = 'task';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-show', ['only' => ['show']]);

    }
    public function index(Request $request)
    {
      
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = Task::STATUSES;
            $task = Task::query();
            $data['rows'] = $task->orderBy('id', 'desc')->get();
            
            if(request()->has('status') && request()->has('status')){
                $task->where('status', $request->get('status'));
               }
            return view($this->view.'.index', $data);
    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {

            if(!empty($request->role) || $request->role != null){
                $data['selected_role'] = $role = $request->role;
            }
            else{
                $data['selected_role'] = '0';
            }
    
            if(!empty($request->department) || $request->department != null){
                $data['selected_department'] = $department = $request->department;
            }
            else{
                $data['selected_department'] = '0';
            }
    
            if(!empty($request->designation) || $request->designation != null){
                $data['selected_designation'] = $designation = $request->designation;
            }
            else{
                $data['selected_designation'] = '0';
            }
    
            if(!empty($request->shift) || $request->shift != null){
                $data['selected_shift'] = $shift = $request->shift;
            }
            else{
                $data['selected_shift'] = '0';
            }
    
            if(!empty($request->contract_type) || $request->contract_type != null){
                $data['selected_contract'] = $contract_type = $request->contract_type;
            }
            else{
                $data['selected_contract'] = '0';
            }
    
    
            // Filter Users
            $users = User::where('id', '!=', null);
    
            if(!empty($request->role)){
                $users->with('roles')->whereHas('roles', function ($query) use ($role){
                    $query->where('role_id', $role);
                });
            }
            if(!empty($request->department)){
                $users->where('department_id', $department);
            }
            if(!empty($request->designation)){
                $users->where('designation_id', $designation);
            }
            if(!empty($request->shift)){
                $users->where('work_shift', $shift);
            }
            if(!empty($request->contract_type)){
                $users->where('contract_type', $contract_type);
            }
            if ($request->has('role') && $request->has('department') && $request->has('designation')) {
                $data['rows'] = $users->orderBy('staff_id', 'asc')->get();
            } else {
                $data['rows'] = [];
            }
            
    
            $data['departments'] = Department::where('status', '1')
                            ->orderBy('title', 'asc')->get();
            $data['designations'] = Designation::where('status', '1')
                            ->orderBy('title', 'asc')->get();
            $data['roles'] = Role::orderBy('name', 'asc')->get();
            $data['work_shifts'] = WorkShiftType::where('status', '1')
                            ->orderBy('title', 'asc')->get();

            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = Task::STATUSES;
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
        $staff_ids = array_map(function($arr) {
        return intval($arr);
        },explode(',',$request->staff_ids));
        
    foreach ($staff_ids as $key => $staff_id) {
        $task = new Task;
        $task->user_id  = $staff_id;
        $task->status = $request->status;
        $task->task = $request->task;
        $task->assigned_by = auth()->id();
        $task->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //

        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = Task::STATUSES;

            $data['row'] = $task;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        } 
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    try{  
        // $task->user_id  = $request->user_id;
        if ($request->status == 1) {
            $request['completed_at'] = now();
        }
        $task->task = $request->task;
        $task->status = $request->status;
        $task->task = $request->task;
        $task->assigned_by = auth()->id();
        $task->completed_at = $request->completed_at;
        $task->save();
                Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                return redirect('admin/task')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
        try{
            $task;
            if ($task) {
                 $task->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
    public function updateStatus(Task $task)
    {
        //
        try{
            if ($task) {
                 $task->update([
                    'status' => 1,
                    'completed_at' => now(),
                 ]);
            }
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
