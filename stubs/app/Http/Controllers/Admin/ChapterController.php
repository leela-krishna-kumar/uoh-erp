<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Subject;
use Toastr;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_chapter', 1);
        $this->route = 'admin.chapter';
        $this->view = 'admin.chapter';
        $this->path = 'chapter';
        $this->access = 'chapter';


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
            $data['statuses'] = Chapter::STATUSES;
            $data['subjects'] = Subject::select('id','title')->get();
            $chapters = Chapter::query();
            if(request()->has('status') && request()->get('status') != null) {
                $chapters->where('status',request()->get('status'));
            }
            if(request()->has('subject_id') && request()->get('subject_id') != null) {
                $chapters->where('subject_id',request()->get('subject_id'));
            }
            $data['rows'] = $chapters->latest()->get();
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
            $data['statuses'] = Chapter::STATUSES;
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
            // return $request->all();
            // Field Validation
            $request->validate([
                'name' => 'required',
                'start_date' => 'required|date|after:today',
                'end_date' => 'date|after:start_date',
                'subject_id' => 'required',
            ]);

            // Insert Data
            $chapter = new Chapter;
            $chapter->name = $request->name;
            $chapter->note = $request->note;
            $chapter->subject_id = $request->subject_id;
            $chapter->start_date = $request->start_date;
            $chapter->end_date = $request->end_date;
            $chapter->status = $request->status;
            $chapter->save();
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
    public function edit(chapter $chapter)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = Chapter::STATUSES;
            $data['subjects'] = Subject::where('status',1)->get();
            $data['row'] = $chapter;
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
    public function update(Request $request, Chapter $chapter)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $chapter->name = $request->name;
            $chapter->subject_id = $request->subject_id;
            $chapter->note = $request->note;
            $chapter->start_date = $request->start_date;
            $chapter->end_date = $request->end_date;
            $chapter->status = $request->status;
            $chapter->save();
            
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
    public function destroy(Chapter $chapter)
    {
        try{
            if($chapter){
                $chapter->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
