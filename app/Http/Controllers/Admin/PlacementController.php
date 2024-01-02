<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Placement;
use App\Models\Company;
use App\Models\Event;
use App\Models\PlacementCategory;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Toastr;

class PlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_placement', 1);
        $this->route = 'admin.placement';
        $this->view = 'admin.placement';
        $this->path = 'placement';
        $this->access = 'placement';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        // try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $placements = Placement::query();
            if(request()->has('date') && request()->get('date') != null) {
                $placements->where('date',request()->get('date'));
            }
            $data['rows'] = $placements->orderBy('id', 'desc')->select('id','company_id','date','description','deadline_date', 'required_document','category_id','criteria_description')->get();
            $data['categories'] = PlacementCategory::select('id','name')->get();
            $data['companies'] = Company::where('status',1)->select('id','name')->get();

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
        //
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['categories'] = PlacementCategory::select('id','name')->get();
            $data['companies'] = Company::where('status',1)->select('id','name')->get();

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

        try{
            // Field Validation
            $request->validate([
                'company_id' => 'required',
            ]);
            $existRecord = Placement::where('company_id',$request->company_id)->first();
            if($existRecord){
                Toastr::error(__('msg_record_already_exists'), __('msg_error'));
                return redirect()->back();
            }
            // Insert Data
            $placement = new Placement;
            $placement->company_id = $request->company_id;
            $placement->date = $request->date;
            $placement->deadline_date = $request->deadline_date;
            $placement->required_document = $request->required_document;
            $placement->is_event = $request->is_event;
            $placement->category_id = $request->category_id;
            $placement->description = $request->description;
            $placement->criteria_description = $request->criteria_description;
            $placement->save();
            
            $placementEvent = EventCategory::where('name','Placement')->first();
            if(!$placementEvent){
                // Insert Data
                $eventCategory = new EventCategory;
                $eventCategory->name = "Placement";
                $eventCategory->save();
                $placementEvent = $eventCategory;
            }

            if($request->is_event == "on"){
                // Insert Data
                $event = new Event;
                $event->title = $placement->company->name . " Placement Event";
                $event->role_id = $request->role_id;
                $event->category_id = $placementEvent->id; // Placement;
                $event->start_date = $request->date;
                $event->end_date = $request->date;
                $event->description = $request->description;
                $event->is_default = isset($request->is_default) ? 1 : 0;
                $event->save();
            }   
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
     * @param  \App\Models\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function show(Placement $placement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function edit(Placement $placement)
    {
        //

        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['categories'] = PlacementCategory::select('id','name')->get();
            $data['companies'] = Company::where('status',1)->select('id','name')->get();
            $data['row'] = $placement;

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
     * @param  \App\Models\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Placement $placement)
    {
        // return $request->all();
        try{
            // Field Validation
            $request->validate([
                'company_id' => 'required|unique:placements,company_id,'.$placement->id,
                // 'company_id' => 'required',
            ]);
            $placement->company_id = $request->company_id;
            $placement->date = $request->date;
            $placement->description = $request->description;
            $placement->deadline_date = $request->deadline_date;
            $placement->required_document = $request->required_document;
            $placement->save();
            
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
     * @param  \App\Models\Placement  $placement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Placement $placement)
    {
        try{
            if($placement){
                $placement->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
