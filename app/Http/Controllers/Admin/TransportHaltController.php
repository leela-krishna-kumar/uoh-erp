<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportHalt;
use App\Models\FeesCategory;
use App\Models\Department;
use App\Models\TransportRoute;
use Illuminate\Http\Request;
use Toastr;

class TransportHaltController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_transport_halt', 1);
        $this->route = 'admin.transport-halt';
        $this->view = 'admin.transport-halt';
        $this->path = 'transport-halt';
        $this->access = 'transport-halt';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['transportRoute'] = TransportRoute::where('id',request()->route_id)->first();
        $data['rows'] = TransportHalt::where('route_id',request()->route_id)->orderBy('name', 'asc')->get();

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
        // Field Validation
        $request->validate([
            'name' => 'required|max:191',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        $transportHalt = new TransportHalt;
        $transportHalt->name = $request->name;
        $transportHalt->route_id = $request->route_id;
        $transportHalt->latitude = $request->latitude;
        $transportHalt->longitude = $request->longitude;
        $transportHalt->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TransportHalt $transportHalt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TransportHalt $transportHalt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Field Validation
        $request->validate([
            'name' => 'required|max:191',
        ]);

        // Update Data
        $transportHalt = TransportHalt::findOrFail($id);
        $transportHalt->name = $request->name;
        $transportHalt->longitude = $request->longitude;
        $transportHalt->latitude = $request->latitude;
        $transportHalt->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete Data
        $transportHalt = TransportHalt::findOrFail($id);
        $transportHalt->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
