<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportVehicle;
use App\Models\RenewalCategory;
use App\Models\Renewal;
use App\User;
use Illuminate\Http\Request;
use Toastr;

class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_renewal', 1);
        $this->route = 'admin.renewal';
        $this->view = 'admin.renewal';
        $this->path = 'renewal';
        $this->access = 'renewal';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;


            $renewals = Renewal::query();

            if(request()->has('renewal_category_id') && request()->get('renewal_category_id') != null) {
                $renewals->where('renewal_category_id',request()->get('renewal_category_id'));
            }
            $data['categories'] = RenewalCategory::select('id','name')->orderBy('name', 'asc')->get();
            $data['rows'] = $renewals->get();
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
    public function create(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['renewal_categories'] = RenewalCategory::select('id','name')->orderBy('name', 'asc')->get();
        $data['vehicles'] = TransportVehicle::select('id','number','type')->orderBy('number', 'asc')->get();
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
        $request->validate([
            'name' => 'required',
            'vehicle_id' => 'required',
            'renewal_category_id' => 'required',
        ]);
        // Insert Data
        $renewal = new Renewal;
        $renewal->name = $request->name;
        $renewal->renewal_category_id = $request->renewal_category_id;
        $renewal->vehicle_id = $request->vehicle_id;
        $renewal->renewal_date = $request->renewal_date;
        $renewal->expiry_date = $request->expiry_date;
        $renewal->note = $request->note;
        $renewal->created_by = auth()->id();
        $renewal->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Renewal $renewal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Renewal $renewal)
    {
       //
       $data['title'] = $this->title;
       $data['route'] = $this->route;
       $data['view'] = $this->view;
       $data['path'] = $this->path;
       $data['row'] = $renewal;
       $data['renewal_categories'] = RenewalCategory::select('id','name')->orderBy('name', 'asc')->get();
        $data['vehicles'] = TransportVehicle::select('id','number','type')->orderBy('number', 'asc')->get();
       return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Renewal $renewal)
    {
        try{
            $request->validate([
                'name' => 'required',
                'vehicle_id' => 'required',
                'renewal_category_id' => 'required',
            ]);
            // Update Data
            $renewal->name = $request->name;
            $renewal->renewal_category_id = $request->renewal_category_id;
            $renewal->vehicle_id = $request->vehicle_id;
            $renewal->renewal_date = $request->renewal_date;
            $renewal->expiry_date = $request->expiry_date;
            $renewal->note = $request->note;
            $renewal->created_by = $renewal->created_by;
            $renewal->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
    
            return redirect()->route($this->route.'.index');
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
    public function destroy(Renewal $renewal)
    {
        try{
            if($renewal){
                $renewal->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
   
}
