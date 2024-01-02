<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdmissionType;
use Illuminate\Http\Request;
use Toastr;


class AdmissionTypeController extends Controller
{
    //

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('admission_type', 1);
        $this->route = 'admin.admission-type';
        $this->view = 'admin.admission_types';
        $this->path = 'admission_types';
        $this->access = 'admission-type';


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
        $admissiontypes = AdmissionType::query();
        $data['rows'] = $admissiontypes->orderBy('id', 'desc')->get();
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
            $admissiontype = new AdmissionType;
            $admissiontype->name = $request->name;
            $admissiontype->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function update(Request $request, AdmissionType  $admissionType)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $admissionType->name = $request->name;
            $admissionType->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    public function destroy(AdmissionType $admissionType)
    {
        try{
            if($admissionType){
                $admissionType->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }

}