<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LessonPlanAccess;
use App\User;

class LessonPlanAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_lesson_plan_access', 1);
        $this->route = 'admin.lesson-plan-access';
        $this->view = 'admin.lesson-plan-access';
        $this->path = 'lesson-plan-access';
        $this->access = 'lesson-plan-access';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        try{   
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $lesson_plan_accesses = LessonPlanAccess::query();
            if(request()->has('user_id') && request()->get('user_id') && request()->has('lesson_id') && request()->get('lesson_id')){
                $lesson_plan_accesses->where('user_id', request()->get('user_id'))->where('lesson_id', request()->get('lesson_id'));
            }
            if(request()->has('user_id') && request()->get('user_id') && !request()->get('user_id')){
                $lesson_plan_accesses->where('user_id', request()->get('user_id'));
            }
            if(!request()->get('user_id') && request()->has('lesson_id') && request()->get('lesson_id')){
                $lesson_plan_accesses->where('lesson_id', request()->get('lesson_id'));
            }
            $data['rows'] = $lesson_plan_accesses->get();
            $data['users'] = User::select('id','name')->get();
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
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = LessonPlanAccess::STATUSES;
            return view($this->view.'.create', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_created_successfully'), __('msg_error'));

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
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);

            // Insert Data
            $lesson_plan_access = new lesson_plan_access;
            $lesson_plan_access->type = App\Models\Lesson::class;
            $lesson_plan_access->type_id = $request->lesson_id;
            $lesson_plan_access->user_id = $request->user_id;
            $lesson_plan_access->save();
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(lesson_plan_access $lesson_plan_access)
    {
        try{
            if($lesson_plan_access){
                $lesson_plan_access->delete();
            }
            
            // Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
