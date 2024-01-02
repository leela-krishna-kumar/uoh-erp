<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostelMaster;
use Toastr;

class HostelMasterController extends Controller
{
    //

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('hostel_master', 1);
        $this->route = 'admin.hostel-master';
        $this->view = 'admin.hostel-master';
        $this->path = 'hostel-master';
        $this->access = 'hostel-master';


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
        $hostelmastertype = HostelMaster::query();
        $data['rows'] = $hostelmastertype->orderBy('id', 'desc')->get();
        return view($this->view.'.index', $data);
    } catch(\Exception $e){

        Toastr::error(__('msg_error'), __('msg_error'));

        return redirect()->back();
    }
    }

    public function store(Request $request)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            // Insert Data
            $hostelmaster = new HostelMaster;
            $hostelmaster->name = $request->name;
            $hostelmaster->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function update(Request $request, HostelMaster $hostelMaster)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $hostelMaster->name = $request->name;
            $hostelMaster->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    // public function show(HostelMaster $hostelMaster)
    // {
    //     //

    //     $data['title'] = $this->title;
    //     $data['route'] = $this->route;
    //     $data['view'] = $this->view;
    //     $data['path'] = $this->path;
    //     $data['access'] = $this->access;
    //     $data['row'] = $hostelMaster;
    //     return view($this->view.'.show', $data);

        

    // }

    public function destroy(HostelMaster $hostelMaster)
    {
        try{
            // return $hostelMaster;
            if($hostelMaster){
            $hostelMaster->delete();
            }
             Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}