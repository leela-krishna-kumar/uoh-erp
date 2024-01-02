<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DeviceLog;
use App\Models\Fleets;
use Illuminate\Http\Request;
use Toastr;

class DeviceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_device-log', 1);
        $this->route = 'admin.device-log';
        $this->view = 'admin.device-log';
        $this->path = 'device-log';
        $this->access = 'device-log';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }
   public function index()
   {

       $data['title'] = $this->title;
       $data['route'] = $this->route;
       $data['view'] = $this->view;
       $data['path'] = $this->path;
       $data['access'] = $this->access;
      $data['fleet'] = Fleets::select('id','name')->where('id',request()->get('fleet_id'))->first();
       $data['statuses'] = DeviceLog::STATUSES;
       $deviceLog= DeviceLog::query();
       $data['rows'] = $deviceLog->orderBy('id', 'desc')->get();

       return view($this->view.'.index', $data);
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

          //    return $request->all();
        // Insert Data
        $deviceLog = new DeviceLog;
        $deviceLog->fleet_id  = $request->fleet_id ;
        $deviceLog->coordinates = $request->coordinates;
        $deviceLog->location = $request->location;
        $deviceLog->status = $request->status;
        $deviceLog->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeviceLog  $deviceLog
     * @return \Illuminate\Http\Response
     */
    public function show(DeviceLog $deviceLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeviceLog  $deviceLog
     * @return \Illuminate\Http\Response
     */
    public function edit(DeviceLog $deviceLog)
    {
        
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = DeviceLog::STATUSES;
            $data['row'] = $deviceLog;
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
     * @param  \App\Models\DeviceLog  $deviceLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeviceLog $deviceLog)
    {
        try {
      
        $deviceLog->coordinates = $request->coordinates;
        $deviceLog->location = $request->location;
        $deviceLog->status = $request->status;
        $deviceLog->save();
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/device-log')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeviceLog  $deviceLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeviceLog $deviceLog)
    {
        //
        try{
            $deviceLog;
            if ($deviceLog) {
                 $deviceLog->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
