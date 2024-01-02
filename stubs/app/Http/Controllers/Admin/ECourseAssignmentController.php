<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ECourseAssignment;
use App\Models\ECourse;
use Illuminate\Http\Request;
use Toastr;

class ECourseAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_ecourse-assignment', 1);
         $this->route = 'admin.ecourse-assignment';
         $this->view = 'admin.ecourse-assignment';
         $this->path = 'ecourse-assignment';
         $this->access = 'ecourse-assignment';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
     }
 
    public function index()
    {
        //

        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['ecourses'] = ECourse::get();
        $ecourseAssignment = ECourseAssignment::query();
        $data['rows'] = $ecourseAssignment->orderBy('id', 'desc')->get();
        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['ecourses'] = ECourse::get();

        return view($this->view.'.create', $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            
        ]);
        // return $request->all();
        // Insert Data
        $ecourseAssignment = new ECourseAssignment;
        $ecourseAssignment->e_course_id = $request->e_course_id;
        $ecourseAssignment->type = $request->type;
        $ecourseAssignment->title = $request->title;
        $ecourseAssignment->due_date = $request->due_date;
        $ecourseAssignment->description = $request->description;
        $ecourseAssignment->type_id = auth()->id();
        $ecourseAssignment->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ECourseAssignment  $ecourseAssignment
     * @return \Illuminate\Http\Response
     */
    public function show(ECourseAssignment $ecourseAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ECourseAssignment  $ecourseAssignment
     * @return \Illuminate\Http\Response
     */
    public function edit(ECourseAssignment $ecourseAssignment)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['ecourses'] = ECourse::get();
        $data['row'] = $ecourseAssignment;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ECourseAssignment  $ecourseAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ECourseAssignment $ecourseAssignment)
    {
        //
        // return $request->all();
        try{
        $ecourseAssignment->e_course_id = $request->e_course_id;
        $ecourseAssignment->type = $request->type;
        $ecourseAssignment->title = $request->title;
        $ecourseAssignment->due_date = $request->due_date;
        $ecourseAssignment->description = $request->description;
        $ecourseAssignment->type_id = auth()->id();
        $ecourseAssignment->save();
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect('admin/ecourse-assignment')->with( __('msg_success'), __('msg_updated_successfully'));
    }
    catch(\Exception $e){

        Toastr::error(__('msg_updated_error'), __('msg_error'));

        return redirect()->back();
    }  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ECourseAssignment  $ecourseAssignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ECourseAssignment $ecourseAssignment)
    {
        //
        try{
            if($ecourseAssignment){
                $ecourseAssignment->delete();
            }
            
            // Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
