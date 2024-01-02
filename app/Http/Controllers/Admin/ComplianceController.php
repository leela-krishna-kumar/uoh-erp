<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compliance;
use App\Models\ComplianceCategory;
use App\Models\ComplianceAttachment;
use Illuminate\Http\Request;
use Toastr;

class ComplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_compliance', 1);
         $this->route = 'admin.compliance';
         $this->view = 'admin.compliance';
         $this->path = 'compliance';
         $this->access = 'compliance';
 
 
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
            $data['categories'] = ComplianceCategory::select('id','name')->orderBy('name', 'asc')->get();
            $compliances = Compliance::query();
            if(request()->has('category_id') && request()->get('category_id') != null) {
                $compliances->where('category_id',request()->get('category_id'));
            }
            $data['rows'] = $compliances->latest()->get();
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
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'note' => 'required'
        ]);

        // Insert Data
        $compliance = new Compliance;
        $compliance->title = $request->title;
        $compliance->category_id = $request->category_id;
        $compliance->note = $request->note;
        $compliance->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Compliance $compliance)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Compliance $compliance)
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
    public function update(Request $request,Compliance $compliance)
    {
        try{
            $request->validate([
                'title' => 'required',
                'category_id' => 'required'
            ]);
            
            // Update Data
            $compliance->title = $request->title;
            $compliance->category_id = $request->category_id;
            $compliance->note = $request->note;
            $compliance->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
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
    public function destroy(Compliance $compliance)
    {
        try{
            if($compliance){
                $compliance->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
