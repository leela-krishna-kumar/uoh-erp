<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Toastr;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_topic', 1);
        $this->route = 'admin.topic';
        $this->view = 'admin.topic';
        $this->path = 'topic';
        $this->access = 'topic';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        {
            try{  
                $data['title'] = $this->title;
                $data['route'] = $this->route;
                $data['view'] = $this->view;
                $data['path'] = $this->path;
                $data['access'] = $this->access;
                $data['statuses'] = Topic::STATUSES;
                $data['chapters'] = Chapter::select('id','name')->get();
                $topics = Topic::query();
                if(request()->has('status') && request()->get('status') != null) {
                    $topics->where('status',request()->get('status'));
                }
                if(request()->has('chapter_id') && request()->get('chapter_id') != null) {
                    $topics->where('chapter_id',request()->get('chapter_id'));
                }
                $data['rows'] = $topics->latest()->get();
                return view($this->view.'.index', $data);
            } catch(\Exception $e){
    
                Toastr::error(__('msg_error'), __('msg_error'));
    
                return redirect()->back();
            } 
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
            $data['statuses'] = Topic::STATUSES;
            $data['chapters'] = Chapter::select('id','name')->where('status',1)->get();
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
                'chapter_id' => 'required',
            ]);

            // Insert Data
            $topic = new Topic;
            $topic->name = $request->name;
            $topic->note = $request->note;
            $topic->chapter_id = $request->chapter_id;
            $topic->start_date = $request->start_date;
            $topic->end_date = $request->end_date;
            $topic->status = $request->status;
            $topic->save();
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
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = Topic::STATUSES;
            $data['chapters'] = Chapter::select('id','name')->where('status',1)->get();
            $data['row'] = $topic;
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
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $topic->name = $request->name;
            $topic->chapter_id = $request->chapter_id;
            $topic->note = $request->note;
            $topic->start_date = $request->start_date;
            $topic->end_date = $request->end_date;
            $topic->status = $request->status;
            $topic->save();
            
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
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        try{
            if($topic){
                $topic->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
