<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Grievance;
use App\User;
use Illuminate\Http\Request;
use Toastr;


class GrievanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_grievance', 1);
         $this->route = 'admin.grievance';
         $this->view = 'admin.grievance';
         $this->path = 'grievance';
         $this->access = 'grievance';
 
 
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
        $data['statuses'] = Grievance::STATUSES;
         $grievance = Grievance::query();
        
        if(request()->has('status') && request()->has('status')){
            $grievance->where('status', $request->get('status'));

        }
        $data['rows'] = $grievance->orderBy('id', 'desc')->get();
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
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function show(Grievance $grievance)
    {
        //

        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['statuses'] = Grievance::STATUSES;
        $data['row'] = $grievance;
        return view($this->view.'.show', $data);

        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function edit(Grievance $grievance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grievance $grievance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grievance  $grievance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grievance $grievance)
    {
        try{
            $grievance;
            if ($grievance) {
                 $grievance->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function updateGrievance(Request $request, $id)
    {
        try{
            // return $request->all();
            $request->validate([
                'status' => 'required',  
            ]);
            
       $grievance = Grievance::where('id', $id)->first();
        $grievance->status = $request->status;
        $grievance->save(); 
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/grievance')->with( __('msg_success'), __('msg_updated_successfully'));
    }
    catch(\Exception $e){

        Toastr::error(__('msg_updated_error'), __('msg_error'));

        return redirect()->back();
    } 
 }       
}
