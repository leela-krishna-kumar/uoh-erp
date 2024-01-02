<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ESection;
use App\Models\ECourse;
use Illuminate\Http\Request;
use Toastr;

class ESectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_esection', 1);
         $this->route = 'admin.esection';
         $this->view = 'admin.esection';
         $this->path = 'esection';
         $this->access = 'esection';
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);

     }
 
    public function index(){

       try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $esection = ESection::query();

            $data['rows'] = $esection->orderBy('id', 'desc')->get();
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
            $data['ecourses'] = ECourse::select('id','title')->latest()->get();
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
        try{
            $esection = new ESection;
            $esection->title = $request->title;
            $esection->short_description = $request->short_description;
            $esection->sequence = $request->sequence;
            $esection->e_course_id = $request->e_course_id;
            $esection->created_by = auth()->id();
            $esection->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.index');
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_successfully'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ESection  $eSection
     * @return \Illuminate\Http\Response
     */
    public function show(ESection $esection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ESection  $esection
     * @return \Illuminate\Http\Response
     */
    public function edit(ESection $esection)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['ecourses'] = ECourse::select('id','title')->get();
            $data['row'] = $esection;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_successfully'), __('msg_error'));

            return redirect()->back();
        } 
        //


    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ESection  $esection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ESection $esection)
    {
        try{
            // Field Validation
            $request->validate([
                'title' => 'required',
            ]);
            $esection->title = $request->title;
            $esection->short_description = $request->short_description;
            $esection->sequence = $request->sequence;
            $esection->e_course_id = $request->e_course_id;
            $esection->created_by = auth()->id();
            $esection->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect('admin/esection')->with( __('msg_success'), __('msg_updated_successfully'));
        }catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ESection  $esection
     * @return \Illuminate\Http\Response
     */
    public function destroy(ESection $esection)
    {
        //
        try{
            if ($esection) {
                 $esection->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
