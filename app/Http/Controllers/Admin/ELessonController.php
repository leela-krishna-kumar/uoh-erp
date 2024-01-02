<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ELesson;
use App\Models\Book;
use App\Models\TestPaper;
use App\Models\ESection;
use App\Traits\FileUploader;
use App\User;
use Illuminate\Http\Request;
use Toastr;

class ELessonController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_elesson', 1);
        $this->route = 'admin.elesson';
        $this->view = 'admin.elesson';
        $this->path = 'elesson';
        $this->access = 'elesson';

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
            $data['types'] = ELesson::TYPES;
            $elesson = ELesson::query();
            if(request()->has('type') && request()->has('type')){
                $elesson->where('type', $request->get('type'));
                }
            $data['rows'] = $elesson->orderBy('id', 'desc')->get();
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
            $data['types'] = ELesson::TYPES;
            $data['books'] = Book::where('status',1)->select('id','title')->get();
            $data['testpapers'] = TestPaper::select('id','title')->get();
            $data['esections'] = ESection::select('id','title')->latest()->get();
            return view($this->view.'.create',$data);
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
        // return  $request->file('link');
        // try{
            // return $request->all();
            $this->validate($request, [ 
                'title' => 'nullable|',    
            ]);
            $existRecord = ELesson::where('title',$request->title)->first();
            if($existRecord){
                Toastr::error(__('msg_title_already_exists'), __('msg_error'));
                return redirect()->back();
            }
            $elesson = new ELesson;
            $elesson->title = $request->title;
            $elesson->short_description = $request->short_description;
            $elesson->type = $request->type;
            $elesson->type_id = $request->type_id;
            $elesson->e_section_id = $request->e_section_id;
            if(!$request->has('is_published')){
                $elesson->is_published = 0;
            }else{
                $elesson->is_published = $request->is_published;
            }
            
                // Type = 0 ; Video Mode
            if($request->type == 'Video'){
                
                if($request->mode_type == 'upload'){
                    $elesson->link = $this->uploadImage($request, 'link', $this->path, 300, 300);
                }else{
                    $elesson->link = $request->link;
                }
                //Type = 1 ;Live Mode 
            }else if($request->type == 'Live'){
                $elesson->link = $request->link;
                //Type = 2 ; EBook Mode
            }else if($request->type == 'Ebook'){
                if($request->e_book_mode == 'upload'){
                   $elesson->link = $this->uploadImage($request,'link', $this->path, 300, 300);
                   if($elesson->link == 'Invalid Extension'){
                        return back()->with('error','File Extension Is Invalid Please Upload With These Extensions jpg,jpeg,png,gif,ico,svg,webp');
                   }
                }elseif($request->book_type_id != null){
                    $elesson->type_id = $request->book_type_id;
                }else{
                  
                    $elesson->link = $request->link;
                }
                //Type = 3 ; ETest Mode
            }else{
                $elesson->type_id = $request->test_type_id;
                if($request->test_paper_mode == 'link'){
                    $elesson->link = $request->link;
                }
            }
            $elesson->created_by = auth()->id();
            $elesson->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->route($this->route.'.index');
        // }catch(\Exception $e){

        //     Toastr::error(__('msg_updated_error'), __('msg_error'));

        //     return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ELesson  $eLesson
     * @return \Illuminate\Http\Response
     */
    public function show(ELesson $elesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ELesson  $elesson
     * @return \Illuminate\Http\Response
     */
    public function edit(ELesson $elesson)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['types'] = ELesson::TYPES;
            $data['row'] = $elesson;
             $data['esections'] = ESection::select('id','title')->latest()->get();
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
     * @param  \App\Models\ELesson  $elesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ELesson $elesson)
    {
        try{
            // return $request->all();
            // Field Validation
            $request->validate([
                'title' => 'required|max:191|unique:e_lessons,title,'.$elesson->id,
            ]);
            $elesson->title = $request->title;
            $elesson->short_description = $request->short_description;
            $elesson->type = $request->type;
            $elesson->e_section_id = $request->e_section_id;
            $elesson->link = $request->link;
            if(!$request->has('is_published')){
                $elesson->is_published = 0;
            }else{
                $elesson->is_published = $request->is_published;
            }
            $elesson->created_by = auth()->id();
            $elesson->save();

            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect('admin/elesson')->with( __('msg_success'), __('msg_updated_successfully'));
        }catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ELesson  $elesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(ELesson $elesson)
    {
        //
           //
           try{
            $elesson;
            if ($elesson) {
                 $elesson->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
 }

