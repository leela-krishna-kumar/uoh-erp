<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddressType;
use Illuminate\Http\Request;
use Toastr;


class AddressTypeController extends Controller
{
    //

    
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('address_type', 1);
        $this->route = 'admin.address-type';
        $this->view = 'admin.address-type';
        $this->path = 'address-type';
        $this->access = 'address-type';


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
        $addressTypes = AddressType::query();
        $data['rows'] = $addressTypes->orderBy('id', 'desc')->get();
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
            $existRecord = AddressType::where('name',$request->name)->first();
            if($existRecord){
                Toastr::error(__('msg_name_already_exists'), __('msg_error'));
                return redirect()->back();
            }
            // Insert Data
            $addressType = new AddressType;
            $addressType->name = $request->name;
            $addressType->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function update(Request $request, AddressType $addressType)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required|max:191|unique:address_types,name,'.$addressType->id,
            ]);
            $addressType->name = $request->name;
            $addressType->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    public function destroy(AddressType $addressType)
    {
        try{
            if($addressType){
                $addressType->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}