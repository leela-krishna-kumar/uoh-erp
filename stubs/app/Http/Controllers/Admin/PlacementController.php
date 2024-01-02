<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Placement;
use App\Models\Company;
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
        try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $placements = Placement::query();
            if(request()->has('date') && request()->get('date') != null) {
                $placements->where('date',request()->get('date'));
            }
            $data['rows'] = $placements->orderBy('id', 'desc')->select('id','company_id','date','description')->get();
            $data['companies'] = Company::where('status',1)->select('id','name')->get();
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
        try{
            // Field Validation
            $request->validate([
                'company_id' => 'required',
            ]);

            // Insert Data
            $placement = new Placement;
            $placement->company_id = $request->company_id;
            $placement->date = $request->date;
            $placement->description = $request->description;
            $placement->save();
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
        try{
            // Field Validation
            $request->validate([
                'company_id' => 'required',
            ]);
            $placement->company_id = $request->company_id;
            $placement->date = $request->date;
            $placement->description = $request->description;
            $placement->save();
            
            // Toastr::success(__('msg_updated_successfully'), __('msg_success'));
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
