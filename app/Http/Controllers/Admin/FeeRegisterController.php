<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CollegeBank;
use App\Models\FeeRegister;
use App\Models\Student;
use Illuminate\Http\Request;
use Auth;
use DB;
use Toastr;

class FeeRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_fee_register', 1);
        $this->route = 'admin.fee-register';
        $this->view = 'admin.fee-register';
        $this->path = 'fee-register';
        $this->access = 'fee-register';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-show', ['only' => ['show']]);

    }
    public function index()
    {
        //
        try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = FeeRegister::STATUSES;
            $feeRegister = FeeRegister::query();
  
            if(request()->has('status') && request()->has('status')){
                $feeRegister->where('status', $request->get('status'));
            }
            $data['rows'] = $feeRegister->orderBy('id', 'desc')->get();
           
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
        try{ 
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['status'] = FeeRegister::STATUS_OPEN;
            $data['collegebank'] = CollegeBank::get();
            return view($this->view.'.create', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        } 
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
       
        try{
            // return $request->all();
            // Field Validation
            $request->validate([
               
            ]);
            // Insert Data
            $feeRegister = new FeeRegister;
            $feeRegister->bank_id = $request->bank_id;
            $feeRegister->created_by = auth()->id();
            $feeRegister->status = $request->status;
            $feeRegister->date = $request->date;
            $feeRegister->note = $request->note;
            $feeRegister->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect('admin/fee-register');
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollegeBank  $collegeBank
     * @return \Illuminate\Http\Response
     */
    public function show(FeeRegister $feeRegister)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeRegister  $feeRegister
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeRegister $feeRegister)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['statuses'] = FeeRegister::STATUSES;
            $data['collegebank'] = CollegeBank::get();
            $data['row'] = $feeRegister;
            return view($this->view.'.edit', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_successfully'), __('msg_error'));

            return redirect()->back();
        } 
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollegeBank  $collegeBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeRegister $feeRegister)
    {
        //
    try{
        // Field Validation
        $feeRegister->bank_id = $request->bank_id;
        $feeRegister->status = $request->status;
        $feeRegister->date = $request->date;
        $feeRegister->note = $request->note;
        $feeRegister->save();
        
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/fee-register')->with( __('msg_success'), __('msg_updated_successfully'));
    }
    catch(\Exception $e){

        Toastr::error(__('msg_updated_error'), __('msg_error'));

        return redirect()->back();
    }        
}

/**
 * Remove the specified resource from storage.
 *
 * @param  \App\Models\FeeRegister  $feeRegister
 * @return \Illuminate\Http\Response
 */
public function destroy(FeeRegister $feeRegister)
{

    try{
        $feeRegister;
        if ($feeRegister) {
             $feeRegister->delete();
        }
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        return redirect()->back();
    }catch(\Exception $e){

        Toastr::error(__('msg_deleted_fail'), __('msg_error'));

        return redirect()->back();
    }
}

}
  