<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Toastr;


class StaffBookPublishController extends Controller
{

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('Addresses', 1);
        $this->route = 'admin.addresses';
        $this->view = 'admin.addresses';
        $this->path = 'addresses';
        $this->access = 'addresses';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','type','sendPassword']]);
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
        $data['types'] = Address::TYPES;
        $address = Address::query();
        if(request()->has('type') && request()->has('type')){
            $address->where('type', $request->get('type'));
        }
        $data['rows'] = $address->orderBy('id', 'desc')->get();
       
        return view($this->view.'.index', $data);
    } catch(\Exception $e){

        Toastr::error(__('msg_error'), __('msg_error'));

        return redirect()->back();
    } 
    
    }

    public function create()
    {
       
    }

    public function store(Request $request)
    {
        // return $request->all();
        try{
            $address = new Address;
            $address->type = $request->type;
            $address->model_id = $request->model_id;
            $address->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->route($this->route.'.index',['model_id' => $request->model_id]);
        } catch(\Exception $e){
            Toastr::error(__('msg_updated_error'), __('msg_error'));
            return redirect()->back();
        } 
    }

    public function edit(Address $address)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['types'] = Address::TYPES;
            $data['row'] = $address;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_successfully'), __('msg_error'));

            return redirect()->back();
        } 
    }

    public function update(Request $request, Address $address)
    {
        try{
            $address->type = $request->type;
            $address->model_type = $request->model_type;
            $address->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->route($this->route.'.index',['model_id' => $address->model_id])->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }        
    }

    public function destroy( Address $address)
    {
        //
        try{
            $address;
            if ($address) {
                 $address->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }


    
}
