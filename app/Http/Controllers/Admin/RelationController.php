<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Relation;
use App\Models\GuardianDetail;
use Toastr;


class RelationController extends Controller
{
    //

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('relation_type', 1);
        $this->route = 'admin.relation-type';
        $this->view = 'admin.relation-type';
        $this->path = 'relation-type';
        $this->access = 'relation-type';


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
        $relationTypes = Relation::query();
        $data['rows'] = $relationTypes->orderBy('id', 'desc')->get();
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
            //convert the title into array
            $text = trim($_POST['name']);
            $textAr = explode("\r\n", $text);
            $names = array_filter($textAr, 'trim');
            foreach ($names as $name) {
                // Check if the name exists in the database
                if (Relation::where('name', $name)->exists()) {
                    Toastr::error(__('msg_name_already_exists'), __('msg_error'));
                    return redirect()->back()->withInput();
                }
            }
            foreach ($names as $name) {
                //check record in DB
                $existName = Relation::where('name', $name)->first();
                if(!$existName){
                    // Insert Data if name does not exist
                    $relationType = new Relation;
                    $relationType->name = $name;
                    $relationType->save();
                }
            }
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function update(Request $request, Relation $relationType)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $relationType->name = $request->name;
            $relationType->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    public function destroy(Relation $relationType)
    {
        try{
            if( $relationType){
                $associated = GuardianDetail::whereNotNull('student_id')->where('relation_id',$relationType->id)->first();
                if($associated){
                    Toastr::error(__('msg_cant_deleted'), __('msg_error'));
                    return redirect()->back();
                }
                $relationType->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}