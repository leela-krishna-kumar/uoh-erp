<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\Donor;
use Illuminate\Http\Request;
use Toastr;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_scholarship', 1);
         $this->route = 'admin.scholarship';
         $this->view = 'admin.scholarship';
         $this->path = 'scholarship';
         $this->access = 'scholarship';
 
 
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
        $data['donors'] = Donor::get();
        $scholarship = Scholarship::query();
        $data['rows'] = $scholarship->orderBy('id', 'desc')->get();
        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['donors'] = Donor::get();

            return view($this->view.'.create', $data);
        // } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        // } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        // try{
            $request->validate([
                'title' => 'required',
                'donor_id' => 'required',
                'note' => 'required',
                'received_amount' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
            ]);

            // Insert Data
            $scholarship = new Scholarship;
            $scholarship->title = $request->title;
            $scholarship->donor_id = $request->donor_id;
            $scholarship->note = $request->note;
            $scholarship->received_amount = $request->received_amount;
            $scholarship->from_date = $request->from_date;
            $scholarship->to_date = $request->to_date;
            $scholarship->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect('admin/scholarship');
        // } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        // } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Scholarship  $scholarship
     * @return \Illuminate\Http\Response
     */
    public function show(Scholarship $scholarship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scholarship  $scholarship
     * @return \Illuminate\Http\Response
     */
    public function edit(Scholarship $scholarship)
    {
        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['donors'] = Donor::get();
            $data['row'] = $scholarship;
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
     * @param  \App\Models\Scholarship  $scholarship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scholarship $scholarship)
    {

        try{
           
            $scholarship->title = $request->title;
            $scholarship->donor_id = $request->donor_id;
            $scholarship->note = $request->note;
            $scholarship->received_amount = $request->received_amount;
            $scholarship->from_date = $request->from_date;
            $scholarship->to_date = $request->to_date;
            $scholarship->save();
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect('admin/scholarship')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scholarship  $scholarship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scholarship $scholarship)
    {
        //
          //
          try{
            $scholarship;
            if ($scholarship) {
                 $scholarship->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
