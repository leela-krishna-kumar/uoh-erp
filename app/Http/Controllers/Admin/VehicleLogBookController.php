<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\VehicleLogBook;
use App\Models\TransportVehicle;
use Illuminate\Http\Request;

use App\User;
use Toastr;

class VehicleLogBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



 public function __construct()
 {
 // Module Data
 $this->title = trans_choice('module_transport_log_book',1);
 $this->route = 'admin.transport-vehicle-log';
 $this->view = 'admin.transport-vehicle-log';
 $this->path = 'transport-vehicle';
 $this->access = 'transport-vehicle';


 $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete',
 ['only' => ['index','show']]);
 $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
 $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
 }


   public function index()
    {
        
         $data['title'] = $this->title;
         $data['route'] = $this->route;
         $data['view'] = $this->view;
         $data['path'] = $this->path;
         $data['access'] = $this->access;
         $data['rows'] = VehicleLogBook::get();   
         $data['vehicles'] = TransportVehicle::get();
         $data['drivers'] = User::where('status', '1')
           ->with('roles')
           ->whereHas('roles', function ($query) {
           $query->where('slug', 'driver');
           })->get();

         return view($this->view.'.index',$data);
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
       // Field Validation
       // Insert Data
       $vehicleLogBook = new VehicleLogBook;
       $vehicleLogBook->vehicle_id = $request->vehicle_id;
       $vehicleLogBook->driver_id = $request->driver_id;
       $vehicleLogBook->date = $request->date;
       $vehicleLogBook->note = $request->note;
       $vehicleLogBook->start_time = $request->start_time;
       $vehicleLogBook->end_time = $request->end_time;
       $vehicleLogBook->checkin_odometer = $request->checkin_odometer;
       $vehicleLogBook->checkout_odometer = $request->checkout_odometer;   
       $vehicleLogBook->save();
       Toastr::success(__('msg_created_successfully'), __('msg_success'));
       return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleLogBook  $vehicleLogBook
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleLogBook $vehicleLogBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleLogBook  $vehicleLogBook
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleLogBook $vehicleLogBook)
    {
        //
         $data['vehicles'] = TransportVehicle::get();
        $data['drivers'] = User::where('status', '1')
        ->with('roles')
        ->whereHas('roles', function ($query) {
        $query->where('slug', 'driver');
        })->get();
         return view($this->view.'.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleLogBook  $vehicleLogBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       
        $vehicleLogBook = VehicleLogBook::find($id);
        $vehicleLogBook->vehicle_id = $request->vehicle_id;
        $vehicleLogBook->driver_id = $request->driver;
        $vehicleLogBook->note = $request->note;
        $vehicleLogBook->date = $request->date;
        $vehicleLogBook->start_time = $request->start_time;
        $vehicleLogBook->end_time = $request->end_time;
        $vehicleLogBook->checkin_odometer = $request->checkin_odometer;
        $vehicleLogBook->checkout_odometer = $request->checkout_odometer;
        $vehicleLogBook->save();
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
         return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleLogBook  $vehicleLogBook
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         try{

        $vehicleLogBook = VehicleLogBook::find($id);
         if($vehicleLogBook){
         $vehicleLogBook->delete();
         }

         Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
         return redirect()->back();
         }catch(\Exception $e){

         Toastr::error(__('msg_deleted_fail'), __('msg_error'));

         return redirect()->back();
         }
         }
    
        }
