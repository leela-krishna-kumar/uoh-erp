<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Subject;
use Toastr;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_lesson', 1);
        $this->route = 'admin.lesson';
        $this->view = 'admin.lesson';
        $this->path = 'lesson';
        $this->access = 'lesson';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        // try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = Lesson::STATUSES;
            $data['subjects'] = Subject::get();
            $lessons = Lesson::query();
            if(request()->has('status') && request()->get('status') != null) {
                $lessons->where('status',request()->get('status'));
            }
            if(request()->has('subject_id') && request()->get('subject_id') != null) {
                $lessons->where('subject_id',request()->get('subject_id'));
            }
            $data['rows'] = $lessons->latest()->get();
            return view($this->view.'.index', $data);
        // } catch(\Exception $e){

        //     Toastr::error(__('msg_error'), __('msg_error'));

        //     return redirect()->back();
        // } 
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
            $data['statuses'] = Lesson::STATUSES;
            $data['subjects'] = Subject::where('status',1)->get();
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
        // try{
            // Field Validation
            $request->validate([
                'name' => 'required',
                'subject_id' => 'required',
            ]);

            // Insert Data
            $lesson = new Lesson;
            $lesson->name = $request->name;
            $lesson->note = $request->note;
            $lesson->subject_id = $request->subject_id;
            $lesson->start_date = $request->start_date;
            $lesson->end_date = $request->end_date;
            $lesson->status = $request->status;
            $lesson->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        // } catch(\Exception $e){

        //     Toastr::error(__('msg_updated_error'), __('msg_error'));

        //     return redirect()->back();
        // } 
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
    public function edit(lesson $lesson)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = Lesson::STATUSES;
            $data['subjects'] = Subject::where('status',1)->get();
            $data['row'] = $lesson;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, lesson $lesson)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $lesson->name = $request->name;
            $lesson->subject_id = $request->subject_id;
            $lesson->note = $request->note;
            $lesson->start_date = $request->start_date;
            $lesson->end_date = $request->end_date;
            $lesson->status = $request->status;
            $lesson->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(lesson $lesson)
    {
        try{
            if($lesson){
                $lesson->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
