<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MotherTongue;
use App\Models\Student;
use Toastr;


class MotherTongueController extends Controller
{
    //

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('mother_tongue', 1);
        $this->route = 'admin.mother-tongue';
        $this->view = 'admin.mother-tongue';
        $this->path = 'mother-tongue';
        $this->access = 'mother-tongue';


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
        $motherTongueTypes = MotherTongue::query();
        $data['rows'] = $motherTongueTypes->orderBy('id', 'desc')->get();
        return view($this->view.'.index', $data);
    // } catch(\Exception $e){

    //     Toastr::error(__('msg_error'), __('msg_error'));

    //     return redirect()->back();
    // }
    }

    public function store(Request $request)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            //convert the title into array
            $text = trim($_POST['name']);
            $textAr = explode("\r\n", $text);
            $names = array_filter($textAr, 'trim');
    
            foreach ($names as $name) {
                //check record in DB
                $existName = MotherTongue::where('name', $name)->first();
                if(!$existName){
                    // Insert Data if name does not exist
                    $motherTongueType = new MotherTongue;
                    $motherTongueType->name = $name;
                    $motherTongueType->save();
                }else{
                    Toastr::error(__($name.' Name already exist'), __('msg_error'));
                    return redirect()->back();  
                }
            }
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function update(Request $request, MotherTongue $motherTongue)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $motherTongue->name = $request->name;
            $motherTongue->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    public function destroy(MotherTongue $motherTongue)
    {
        try{
            if( $motherTongue){
                $associated = Student::where('mother_tongue',$motherTongue->id)->first();
                if($associated){
                    Toastr::error(__('msg_cant_deleted'), __('msg_error'));
                    return redirect()->back();
                }
                $motherTongue->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}