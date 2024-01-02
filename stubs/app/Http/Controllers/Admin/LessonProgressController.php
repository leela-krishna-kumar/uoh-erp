<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\LessonProgress;
use App\Models\ECourse;
use App\Models\ELesson;
use App\User;
use Illuminate\Http\Request;
use Toastr;
class LessonProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
         $this->title = 'Lesson Progress';
         $this->route = 'admin.lesson-progress';
         $this->view = 'admin.lesson-progress';
         $this->path = 'lesson-progress';
         $this->access = 'lesson-progress';
     }
 
    public function index()
    {

       try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
    
            $lessonProgress = LessonProgress::query();
            $data['courses'] = ECourse::select('id','title')->get();
            $data['lessons'] = ELesson::select('id','title')->get();

            $data['rows'] = $lessonProgress->orderBy('id', 'desc')->get();
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
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LessonProgress  $lessonProgress
     * @return \Illuminate\Http\Response
     */
    public function show(LessonProgress $lessonProgress)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LessonProgress  $lessonProgress
     * @return \Illuminate\Http\Response
     */
    public function edit(LessonProgress $lessonProgress , Request $request)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LessonProgress  $lessonProgress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LessonProgress $lessonProgress)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LessonProgress  $lessonProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(LessonProgress $lessonProgress)
    {
  
        // 
       
    }
   
    
}
